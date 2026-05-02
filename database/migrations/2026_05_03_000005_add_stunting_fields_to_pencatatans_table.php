<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencatatans', function (Blueprint $table) {
            $table->string('indikator_stunting')->nullable()->after('standar');
            $table->float('z_score_stunting')->nullable()->after('indikator_stunting');
            $table->string('status_stunting')->nullable()->after('z_score_stunting');
            $table->string('standar_stunting')->nullable()->after('status_stunting');
        });
    }

    public function down(): void
    {
        Schema::table('pencatatans', function (Blueprint $table) {
            $table->dropColumn([
                'indikator_stunting',
                'z_score_stunting',
                'status_stunting',
                'standar_stunting',
            ]);
        });
    }
};
