<?php

namespace App\Http\Controllers;

use App\Models\Pencatatan;
use Illuminate\Http\Request;

class PencatatanController extends Controller
{
    public function index()
    {
        $data = Pencatatan::latest()->get();
        return view('pencatatan.index', compact('data'));
    }

    // 🔥 FUNCTION INTI (biar gak ngulang code)
    private function hitungStatus($bb, $tb)
    {
        $imt = $bb / pow(($tb / 100), 2);

        $status = match (true) {
            $imt < 14 => 'Gizi Buruk',
            $imt < 16 => 'Gizi Kurang',
            $imt <= 18 => 'Normal',
            $imt <= 20 => 'Risiko Lebih',
            default => 'Gizi Lebih'
        };

        return [$imt, $status];
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required',
            'umur' => 'required|numeric|min:0|max:60',
            'bb' => 'required|numeric|min:2|max:30',
            'tb' => 'required|numeric|min:45|max:120',
            'lk' => 'nullable|numeric'
        ]);

        $bb = $request->bb;
        $tb = $request->tb;

        // 🔥 pakai function
        [$imt, $status] = $this->hitungStatus($bb, $tb);

        Pencatatan::create([
            'nama' => $request->nama,
            'jk' => $request->jk,
            'umur' => $request->umur,
            'bb' => $bb,
            'tb' => $tb,
            'lk' => $request->lk,
            'imt' => $imt,
            'status' => $status
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $item = Pencatatan::findOrFail($id);
        return view('pencatatan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required',
            'umur' => 'required|numeric|min:0|max:60',
            'bb' => 'required|numeric|min:2|max:30',
            'tb' => 'required|numeric|min:45|max:120',
            'lk' => 'nullable|numeric'
        ]);

        $bb = $request->bb;
        $tb = $request->tb;

        // 🔥 pakai function yang sama
        [$imt, $status] = $this->hitungStatus($bb, $tb);

        $data = Pencatatan::findOrFail($id);

        $data->update([
            'nama' => $request->nama,
            'jk' => $request->jk,
            'umur' => $request->umur,
            'bb' => $bb,
            'tb' => $tb,
            'lk' => $request->lk,
            'imt' => $imt,
            'status' => $status
        ]);

        return redirect()->route('pencatatan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Pencatatan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
