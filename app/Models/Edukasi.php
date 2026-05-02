<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'konten',
        'ringkasan',
        'tipe',
        'kategori',
        'gambar',
        'sumber',
        'google_scholar_url',
        'pdf_url',
        'durasi_baca',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
