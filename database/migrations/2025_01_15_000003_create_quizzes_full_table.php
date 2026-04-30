<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('quizzes');
        
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edukasi_id')->nullable()->constrained('edukasis')->onDelete('cascade');
            $table->string('pertanyaan');
            $table->json('pilihan');
            $table->string('jawaban_benar');
            $table->string('kategori');
            $table->text('penjelasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
