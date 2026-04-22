<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edukasi;

class EdukasiController extends Controller
{
    public function index()
    {
        $materi = \App\Models\Edukasi::where('tipe', 'materi')->get();
        $jurnal = \App\Models\Edukasi::where('tipe', 'jurnal')->get();

        return view('edukasi.index', compact('materi', 'jurnal'));
    }

    private function checkAdmin()
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }
    }
}
