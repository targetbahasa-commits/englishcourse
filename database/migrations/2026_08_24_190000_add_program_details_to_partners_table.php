<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->foreignId('program_id')->nullable()->after('industry')->constrained('programs')->nullOnDelete();
            $table->unsignedInteger('total_meetings')->nullable()->after('program_id');
            $table->date('program_start_date')->nullable()->after('total_meetings');
            $table->date('program_end_date')->nullable()->after('program_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_id');
            $table->dropColumn(['total_meetings', 'program_start_date', 'program_end_date']);
        });
    }
};
