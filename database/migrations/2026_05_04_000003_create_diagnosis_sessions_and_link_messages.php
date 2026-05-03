<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('diagnosis_sessions')) {
            Schema::create('diagnosis_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('pencatatan_id')->nullable()->constrained('pencatatans')->nullOnDelete();
                $table->string('title')->default('Chat diagnosis');
                $table->timestamps();

                $table->index(['user_id', 'updated_at']);
            });
        }

        Schema::table('diagnosis_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('diagnosis_messages', 'diagnosis_session_id')) {
                $table->foreignId('diagnosis_session_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('diagnosis_sessions')
                    ->cascadeOnDelete();
            }
        });

        $legacyGroups = DB::table('diagnosis_messages')
            ->select('user_id', DB::raw('MIN(created_at) as first_created_at'), DB::raw('MAX(updated_at) as last_updated_at'))
            ->whereNull('diagnosis_session_id')
            ->groupBy('user_id')
            ->get();

        foreach ($legacyGroups as $group) {
            $sessionId = DB::table('diagnosis_sessions')->insertGetId([
                'user_id' => $group->user_id,
                'title' => 'Riwayat sebelumnya',
                'created_at' => $group->first_created_at ?? now(),
                'updated_at' => $group->last_updated_at ?? now(),
            ]);

            DB::table('diagnosis_messages')
                ->where('user_id', $group->user_id)
                ->whereNull('diagnosis_session_id')
                ->update(['diagnosis_session_id' => $sessionId]);
        }
    }

    public function down(): void
    {
        Schema::table('diagnosis_messages', function (Blueprint $table) {
            if (Schema::hasColumn('diagnosis_messages', 'diagnosis_session_id')) {
                $table->dropConstrainedForeignId('diagnosis_session_id');
            }
        });

        Schema::dropIfExists('diagnosis_sessions');
    }
};
