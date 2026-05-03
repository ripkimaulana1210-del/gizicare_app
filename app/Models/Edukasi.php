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
        'tipe',
        'kategori',
        'gambar',
        'sumber',
        'durasi_baca',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
