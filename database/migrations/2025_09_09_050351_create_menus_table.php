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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_category_id')->nullable();
            $table->string('name_bn')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('entry_by')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->unsignedBigInteger('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('menu_category_id')->references('id')->on('menu_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
