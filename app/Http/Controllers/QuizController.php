<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $kategori = Quiz::select('kategori')->distinct()->pluck('kategori');
        $totalSoal = Quiz::count();
        $history = QuizResult::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('quiz.index', compact('kategori', 'totalSoal', 'history'));
    }

    public function show()
    {
        $soal = Quiz::inRandomOrder()->take(5)->get();

        if ($soal->isEmpty()) {
            return redirect()->route('quiz.index')->with('error', 'Belum ada soal quiz.');
        }

        return view('quiz.show', compact('soal'));
    }

    public function submit(Request $request)
    {
        $jawaban = $request->input('jawaban', []);
        $soalIds = array_keys($jawaban);
        $soal = Quiz::whereIn('id', $soalIds)->get();

        $benar = 0;
        $detail = [];

        foreach ($soal as $q) {
            $jawabanUser = $jawaban[$q->id] ?? null;
            $isBenar = $jawabanUser === $q->jawaban_benar;
            if ($isBenar) {
                $benar++;
            }

            $detail[] = [
                'pertanyaan' => $q->pertanyaan,
                'jawaban_user' => $jawabanUser,
                'jawaban_benar' => $q->jawaban_benar,
                'benar' => $isBenar,
                'penjelasan' => $q->penjelasan,
            ];
        }

        $total = count($soal);
        $score = $total > 0 ? round(($benar / $total) * 100) : 0;

        QuizResult::create([
            'user_id' => auth()->id(),
            'total_soal' => $total,
            'jawaban_benar' => $benar,
            'score' => $score,
            'detail_jawaban' => $detail,
        ]);

        return view('quiz.result', compact('benar', 'total', 'score', 'detail'));
    }
}

