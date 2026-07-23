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
        Schema::table('ielts_speaking_topics', function (Blueprint $table) {
            $table->tinyInteger('part')->nullable()->after('id');
            $table->json('idioms')->nullable();
            $table->json('collocations')->nullable();
            $table->json('advanced_verbs')->nullable();
            $table->json('advanced_adverbs')->nullable();
            $table->json('advanced_adjectives')->nullable();
            
            // For Part 2 specifically
            $table->string('part3_title')->nullable();
            $table->json('part3_questions')->nullable();
            $table->json('part3_idioms')->nullable();
            $table->json('part3_collocations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_speaking_topics', function (Blueprint $table) {
            $table->dropColumn([
                'part',
                'idioms',
                'collocations',
                'advanced_verbs',
                'advanced_adverbs',
                'advanced_adjectives',
                'part3_title',
                'part3_questions',
                'part3_idioms',
                'part3_collocations',
            ]);
        });
    }
};
