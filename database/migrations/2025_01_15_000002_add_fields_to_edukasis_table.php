<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('edukasis')) {
            Schema::create('edukasis', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('konten');
                $table->string('tipe');
                $table->string('kategori')->nullable();
                $table->string('gambar')->nullable();
                $table->string('sumber')->nullable();
                $table->integer('durasi_baca')->nullable()->comment('dalam menit');
                $table->timestamps();
            });

            return;
        }

        Schema::table('edukasis', function (Blueprint $table) {
            if (! Schema::hasColumn('edukasis', 'kategori')) {
                $table->string('kategori')->nullable()->after('tipe');
            }

            if (! Schema::hasColumn('edukasis', 'gambar')) {
                $table->string('gambar')->nullable()->after('kategori');
            }

            if (! Schema::hasColumn('edukasis', 'sumber')) {
                $table->string('sumber')->nullable()->after('gambar');
            }

            if (! Schema::hasColumn('edukasis', 'durasi_baca')) {
                $table->integer('durasi_baca')->nullable()->comment('dalam menit')->after('sumber');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('edukasis')) {
            return;
        }

        $columns = array_filter(
            ['kategori', 'gambar', 'sumber', 'durasi_baca'],
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
