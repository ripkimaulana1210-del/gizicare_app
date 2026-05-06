<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $totalSoal = Quiz::count();
        $materiOptions = Quiz::select('kategori')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();
        $history = QuizResult::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function (QuizResult $result) {
                $kategori = collect($result->detail_jawaban ?? [])
                    ->pluck('kategori')
                    ->filter()
                    ->unique()
                    ->values();

                $result->materi_label = match (true) {
                    $kategori->count() === 1 => $kategori->first(),
                    $kategori->count() > 1 => 'Campuran',
                    default => 'Quiz Gizi',
                };

                return $result;
            });

        return view('quiz.index', compact('totalSoal', 'materiOptions', 'history'));
    }

    public function show(Request $request)
    {
        $materi = $request->query('materi');
        $query = Quiz::query();

        if ($materi) {
            $query->where('kategori', $materi);
        }

        $totalMateri = (clone $query)->count();
        $jumlahSoal = min(10, $totalMateri);
        $soal = $query->inRandomOrder()->take($jumlahSoal)->get();

        if ($soal->isEmpty()) {
            return redirect()->route('quiz.index')->with('error', 'Belum ada soal quiz untuk materi tersebut.');
        }

        return view('quiz.show', compact('soal', 'materi', 'totalMateri', 'jumlahSoal'));
    }

    public function submit(Request $request)
    {
        $jawaban = $request->input('jawaban', []);
        $soalIds = $request->input('soal_ids', array_keys($jawaban));
        $materi = $request->input('materi');
        $soal = Quiz::whereIn('id', $soalIds)->get()->keyBy('id');

        $benar = 0;
        $detail = [];

        foreach ($soalIds as $id) {
            $q = $soal->get((int) $id);

            if (! $q) {
                continue;
            }

            $jawabanUser = $jawaban[$q->id] ?? null;
            $isBenar = $jawabanUser === $q->jawaban_benar;
            if ($isBenar) {
                $benar++;
            }

            $detail[] = [
                'kategori' => $q->kategori,
                'pertanyaan' => $q->pertanyaan,
                'jawaban_user' => $jawabanUser,
                'jawaban_user_text' => $jawabanUser ? ($q->pilihan[$jawabanUser] ?? null) : null,
                'jawaban_benar' => $q->jawaban_benar,
                'jawaban_benar_text' => $q->pilihan[$q->jawaban_benar] ?? null,
                'benar' => $isBenar,
                'penjelasan' => $q->penjelasan,
            ];
        }

        $total = count($soal);
        $score = $total > 0 ? round(($benar / $total) * 100) : 0;

        if (auth()->check()) {
            QuizResult::create([
                'user_id' => auth()->id(),
                'total_soal' => $total,
                'jawaban_benar' => $benar,
                'score' => $score,
                'detail_jawaban' => $detail,
            ]);
        }

        return view('quiz.result', compact('benar', 'total', 'score', 'detail', 'materi'));
    }
}
