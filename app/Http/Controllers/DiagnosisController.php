<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    //

    public function hasil(Request $request)
    {
        $gejala = $request->gejala;

        if (in_array('lemas', $gejala) && in_array('pucat', $gejala)) {
            $hasil = "Anemia";
        } else {
            $hasil = "Normal";
        }

        return view('hasil', compact('hasil'));
    }
}
