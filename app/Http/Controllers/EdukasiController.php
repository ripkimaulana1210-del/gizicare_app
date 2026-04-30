<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edukasi;
use App\Models\Quiz;

class EdukasiController extends Controller
{
    public function index()
    {
        $materi = Edukasi::where('tipe', 'materi')->latest()->get();
        $jurnal = Edukasi::where('tipe', 'jurnal')->latest()->get();
        $kategori = Edukasi::where('tipe', 'materi')->distinct()->pluck('kategori');

        return view('edukasi.index', compact('materi', 'jurnal', 'kategori'));
    }

    public function show($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        $related = Edukasi::where('tipe', $edukasi->tipe)
            ->where('id', '!=', $id)
            ->limit(3)
            ->get();

        return view('edukasi.show', compact('edukasi', 'related'));
    }

}
