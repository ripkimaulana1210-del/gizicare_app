<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('edukasis')) {
            return;
        }

        Schema::table('edukasis', function (Blueprint $table) {
            if (! Schema::hasColumn('edukasis', 'pdf_url')) {
                $table->string('pdf_url', 512)->nullable()->after('google_scholar_url');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('edukasis') || ! Schema::hasColumn('edukasis', 'pdf_url')) {
            return;
        }

        Schema::table('edukasis', function (Blueprint $table) {
            $table->dropColumn('pdf_url');
        });
    }
};
