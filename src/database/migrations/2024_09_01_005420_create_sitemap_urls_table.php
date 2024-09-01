<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Keasy9\SitemapGenerator\Enums\SitemapChangeFreqEnum;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sitemap_urls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->tinyInteger('active')->default(1);
            $table->unsignedInteger('sort')->default(500);
            $table->string('url')->unique();
            $table->dateTime('lastmod')->nullable();
            $table->enum('changefreq', array_values(SitemapChangeFreqEnum::values()))->nullable();
            $table->float('priority', 2, 1)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitemap_urls');
    }
};
