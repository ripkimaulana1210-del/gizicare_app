<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencatatans', function (Blueprint $table) {
            $table->string('posyandu')->default('Umum')->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('pencatatans', function (Blueprint $table) {
            $table->dropColumn('posyandu');
        });
    }
};
