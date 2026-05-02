<?php

namespace App\Http\Controllers;

use App\Models\Pencatatan;
use App\Services\WhoGrowthStandard;
use InvalidArgumentException;
use Illuminate\Http\Request;

class PencatatanController extends Controller
{
    public function __construct(private WhoGrowthStandard $growthStandard)
    {
    }

    public function index(Request $request)
    {
        $selectedPosyandu = $request->query('posyandu');
        $query = Pencatatan::query()->latest();

        if ($selectedPosyandu) {
            $query->where('posyandu', $selectedPosyandu);
        }

        $data = $query->get();
        $posyanduOptions = Pencatatan::query()
            ->select('posyandu')
            ->distinct()
            ->orderBy('posyandu')
            ->pluck('posyandu')
            ->filter()
            ->values();

        $statusLabels = ['Gizi Buruk', 'Gizi Kurang', 'Normal', 'Risiko Lebih', 'Gizi Lebih', 'Obesitas'];
        $statusSummary = collect($statusLabels)->map(fn ($status) => [
            'status' => $status,
            'count' => $data->where('status', $status)->count(),
        ])->values();
        $stuntingLabels = ['Stunting Berat', 'Stunting', 'Normal', 'Tinggi'];
        $stuntingSummary = collect($stuntingLabels)->map(fn ($status) => [
            'status' => $status,
            'count' => $data->where('status_stunting', $status)->count(),
        ])->values();

        $posyanduSummary = $data
            ->groupBy(fn (Pencatatan $item) => $item->posyandu ?: 'Umum')
            ->map(function ($items, $posyandu) {
                return [
                    'posyandu' => $posyandu,
                    'count' => $items->count(),
                    'normal' => $items->where('status', 'Normal')->count(),
                    'needs_attention' => $items->where('status', '!=', 'Normal')->count(),
                    'avg_z_score' => $items->whereNotNull('z_score')->avg('z_score'),
                ];
            })
            ->sortByDesc('count')
            ->values();

        $chartData = [
            'posyandu' => $posyanduSummary->map(fn ($item) => [
                'label' => $item['posyandu'],
                'count' => $item['count'],
                'normal' => $item['normal'],
                'needs_attention' => $item['needs_attention'],
            ])->values(),
            'status' => $statusSummary,
            'stunting' => $stuntingSummary,
        ];

        return view('pencatatan.index', compact(
            'data',
            'posyanduOptions',
            'selectedPosyandu',
            'posyanduSummary',
            'statusSummary',
            'stuntingSummary',
            'chartData'
        ));
    }

    private function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'posyandu' => 'required|string|max:120',
            'jk' => 'required|in:L,P',
            'umur' => 'required|integer|min:0|max:60',
            'bb' => 'required|numeric|min:1|max:35',
            'tb' => 'required|numeric|min:45|max:120',
            'lk' => 'nullable|numeric|min:0'
        ];
    }

    private function payload(Request $request): array
    {
        $bb = (float) $request->bb;
        $tb = (float) $request->tb;
        $umur = (int) $request->umur;
        $imt = $bb / pow(($tb / 100), 2);
        $assessment = $this->growthStandard->assess($request->jk, $umur, $bb, $tb);
        $stunting = $this->growthStandard->assessStunting($request->jk, $umur, $tb);

        return [
            'nama' => $request->nama,
            'posyandu' => trim((string) $request->posyandu),
            'jk' => $request->jk,
            'umur' => $umur,
            'bb' => $bb,
            'tb' => $tb,
            'lk' => $request->lk,
            'imt' => round($imt, 2),
            'status' => $assessment['status'],
            'indikator' => $assessment['indicator'],
            'z_score' => $assessment['z_score'],
            'standar' => $assessment['standard'],
            'indikator_stunting' => $stunting['indicator'],
            'z_score_stunting' => $stunting['z_score'],
            'status_stunting' => $stunting['status'],
            'standar_stunting' => $stunting['standard'],
        ];
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        try {
            Pencatatan::create($this->payload($request));
        } catch (InvalidArgumentException $exception) {
            return back()
                ->withErrors(['tb' => $exception->getMessage()])
                ->withInput();
        }

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $item = Pencatatan::findOrFail($id);
        return view('pencatatan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules());

        $data = Pencatatan::findOrFail($id);

        try {
            $data->update($this->payload($request));
        } catch (InvalidArgumentException $exception) {
            return back()
                ->withErrors(['tb' => $exception->getMessage()])
                ->withInput();
        }

        return redirect()->route('pencatatan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Pencatatan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
