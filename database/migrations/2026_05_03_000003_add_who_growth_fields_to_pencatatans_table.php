<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencatatans', function (Blueprint $table) {
            $table->string('indikator')->nullable()->after('status');
            $table->float('z_score')->nullable()->after('indikator');
            $table->string('standar')->nullable()->after('z_score');
        });
    }

    public function down(): void
    {
        Schema::table('pencatatans', function (Blueprint $table) {
            $table->dropColumn(['indikator', 'z_score', 'standar']);
        });
    }
};
