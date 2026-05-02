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
            if (! Schema::hasColumn('edukasis', 'ringkasan')) {
                $table->text('ringkasan')->nullable()->after('konten');
            }

            if (! Schema::hasColumn('edukasis', 'google_scholar_url')) {
                $table->string('google_scholar_url', 512)->nullable()->after('sumber');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('edukasis')) {
            return;
        }

        $columns = array_filter(
            ['ringkasan', 'google_scholar_url'],
            fn ($column) => Schema::hasColumn('edukasis', $column)
        );

        if (empty($columns)) {
            return;
        }

        Schema::table('edukasis', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
