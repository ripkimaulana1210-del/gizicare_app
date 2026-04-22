<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pencatatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->integer('umur');
            $table->float('bb');
            $table->float('tb');
            $table->float('lk')->nullable();

            $table->float('imt');
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencatatans');
    }
};
