<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_media_post_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // Canva, Google Drive, YouTube, Instagram, TikTok, Facebook, Landing Page, Other
            $table->string('url', 2000);
            $table->string('description', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_links');
    }
};
