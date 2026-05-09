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
        Schema::table('meeting_scores', function (Blueprint $table) {
            $table->foreignId('program_id')->nullable()->after('user_id')->constrained('programs')->onDelete('cascade');
        });

        // Set default to Grammar for Writing (ID 1 usually) for legacy records
        $grammarProgramId = \App\Models\Program::where('slug', 'grammar-for-writing')->value('id');
        if ($grammarProgramId) {
            \Illuminate\Support\Facades\DB::table('meeting_scores')->whereNull('program_id')->update(['program_id' => $grammarProgramId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_scores', function (Blueprint $table) {
            $table->dropForeign(['program_id']);
            $table->dropColumn('program_id');
        });
    }
};
