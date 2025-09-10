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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_category_id')->nullable();
            $table->string('title_bn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->nullable();
            $table->longText('details_bn')->nullable();
            $table->longText('details_en')->nullable();
            $table->string('attachment')->nullable();
            $table->string('attachment_display_name')->nullable();
            $table->unsignedBigInteger('entry_by')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->unsignedBigInteger('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('article_category_id')->references('id')->on('article_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
