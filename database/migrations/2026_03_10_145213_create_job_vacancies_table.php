<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->string('country');
            $table->longText('description');
            $table->text('requirements')->nullable();
            $table->string('english_requirement')->nullable(); // ielts, toefl, pte, none, other
            $table->string('min_score')->nullable(); // e.g. 6.5, 500
            $table->date('deadline')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
