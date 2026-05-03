<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'diagnosis_session_id',
        'role',
        'content',
        'model',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(DiagnosisSession::class, 'diagnosis_session_id');
    }
}
