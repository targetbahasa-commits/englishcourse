<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();
            $table->string('program'); // slug: grammar-writing, toefl-itp, ielts-academic, etc.
            $table->string('title');
            $table->string('content_type'); // Tips, Vocabulary, Grammar, etc.
            $table->json('platforms'); // ["Instagram","TikTok","Facebook",...]
            $table->longText('caption')->nullable();
            $table->string('cta', 500)->nullable();
            $table->text('hashtags')->nullable();
            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('reviewer')->nullable();
            $table->string('status')->default('draft'); // draft, scheduled, published, cancelled
            $table->text('notes')->nullable();

            // Checklist
            $table->boolean('checklist_caption')->default(false);
            $table->boolean('checklist_design')->default(false);
            $table->boolean('checklist_video')->default(false);
            $table->boolean('checklist_review')->default(false);
            $table->boolean('checklist_publish')->default(false);

            // Manual Statistics (no API)
            $table->unsignedInteger('stat_views')->default(0);
            $table->unsignedInteger('stat_likes')->default(0);
            $table->unsignedInteger('stat_comments')->default(0);
            $table->unsignedInteger('stat_shares')->default(0);
            $table->unsignedInteger('stat_clicks')->default(0);
            $table->unsignedInteger('stat_leads')->default(0);
            $table->unsignedInteger('stat_registrations')->default(0);

            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_posts');
    }
};
