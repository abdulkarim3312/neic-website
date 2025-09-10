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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attachment_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('title_bn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->nullable();
            $table->string('file_display_name')->nullable();
            $table->unsignedBigInteger('entry_by')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->unsignedBigInteger('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('attachment_id')->references('id')->on('attachment_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
