<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pencatatan_id',
        'title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pencatatan()
    {
        return $this->belongsTo(Pencatatan::class);
    }

    public function messages()
    {
        return $this->hasMany(DiagnosisMessage::class);
    }
}
