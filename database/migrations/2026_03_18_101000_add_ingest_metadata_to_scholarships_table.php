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
        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('ingest_source_type', 40)->nullable()->after('funding_type');
            $table->string('ingest_source_ref', 500)->nullable()->after('ingest_source_type');
            $table->string('ingest_parser', 120)->nullable()->after('ingest_source_ref');
            $table->timestamp('ingested_at')->nullable()->after('ingest_parser');
            $table->boolean('ingest_quality_pass')->nullable()->after('ingested_at');

            $table->index(['ingest_source_type', 'ingested_at'], 'scholarships_ingest_type_time_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropIndex('scholarships_ingest_type_time_idx');
            $table->dropColumn([
                'ingest_source_type',
                'ingest_source_ref',
                'ingest_parser',
                'ingested_at',
                'ingest_quality_pass',
            ]);
        });
    }
};
