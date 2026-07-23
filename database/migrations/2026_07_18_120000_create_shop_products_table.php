<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', [
                'book_physical',
                'book_digital',
                'class_voucher',
                'video_class',
                'mock_test',
                'mock_test_pte',
            ]);
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('price_discounted')->nullable();
            $table->integer('stock')->nullable()->comment('null = unlimited (for digital products)');
            $table->boolean('is_active')->default(true);
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->string('file_url')->nullable()->comment('Download link or video URL for digital products');
            $table->json('platform_links')->nullable()->comment('{"shopee":"...","tokopedia":"...","tiktok":"...","whatsapp":"...","instagram":"..."}');
            $table->integer('weight_gram')->nullable()->comment('For physical books (shipping calculation)');
            $table->unsignedInteger('sold_count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};
