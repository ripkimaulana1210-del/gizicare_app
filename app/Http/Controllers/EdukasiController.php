<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\Quiz;

class EdukasiController extends Controller
{
    public function index()
    {
        $materi = Edukasi::where('tipe', 'materi')->latest()->get();
        $jurnal = Edukasi::where('tipe', 'jurnal')->latest()->get();
        $totalQuiz = Quiz::count();

        return view('edukasi.index', compact('materi', 'jurnal', 'totalQuiz'));
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
