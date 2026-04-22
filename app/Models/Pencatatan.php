<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencatatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jk',
        'umur',
        'bb',
        'tb',
        'lk',
        'imt',
        'status'
    ];
}
