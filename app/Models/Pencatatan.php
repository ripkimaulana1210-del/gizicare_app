<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencatatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'posyandu',
        'jk',
        'umur',
        'bb',
        'tb',
        'lk',
        'imt',
        'status',
        'indikator',
        'z_score',
        'standar',
        'indikator_stunting',
        'z_score_stunting',
        'status_stunting',
        'standar_stunting'
    ];
}
