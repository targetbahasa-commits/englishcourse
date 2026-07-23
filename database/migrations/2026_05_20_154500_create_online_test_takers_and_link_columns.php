<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_test_takers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_user_id')->nullable()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();

            $table->index('name');
        });

        Schema::table('online_test_results', function (Blueprint $table) {
            $table->foreignId('online_test_taker_id')->nullable()->after('user_id')->constrained('online_test_takers')->nullOnDelete();
            $table->index(['online_test_taker_id', 'test_slug'], 'online_test_results_taker_slug_idx');
        });

        Schema::table('online_test_user_access', function (Blueprint $table) {
            $table->foreignId('online_test_taker_id')->nullable()->after('user_id')->constrained('online_test_takers')->nullOnDelete();
            $table->index('online_test_taker_id');
            $table->unique(['online_test_taker_id', 'test_slug'], 'online_test_user_access_taker_slug_unique');
        });

        $rows = DB::table('users')
            ->select('id', 'name', 'email')
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('online_test_results')->whereNotNull('user_id');
            })
            ->orWhereIn('id', function ($query) {
                $query->select('user_id')->from('online_test_user_access')->whereNotNull('user_id');
            })
            ->get();

        foreach ($rows as $row) {
            $existing = DB::table('online_test_takers')->where('source_user_id', $row->id)->first();

            if ($existing) {
                $takerId = $existing->id;
            } else {
                $takerId = DB::table('online_test_takers')->insertGetId([
                    'source_user_id' => $row->id,
                    'name' => $row->name ?? 'Unknown',
                    'email' => $row->email ?? ('user' . $row->id . '@targetbahasa.local'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('online_test_results')
                ->where('user_id', $row->id)
                ->update(['online_test_taker_id' => $takerId]);

            DB::table('online_test_user_access')
                ->where('user_id', $row->id)
                ->update(['online_test_taker_id' => $takerId]);
        }
    }

    public function down(): void
    {
        Schema::table('online_test_user_access', function (Blueprint $table) {
            $table->dropUnique('online_test_user_access_taker_slug_unique');
            $table->dropConstrainedForeignId('online_test_taker_id');
        });

        Schema::table('online_test_results', function (Blueprint $table) {
            $table->dropConstrainedForeignId('online_test_taker_id');
            $table->dropIndex('online_test_results_taker_slug_idx');
        });

        Schema::dropIfExists('online_test_takers');
    }
};
