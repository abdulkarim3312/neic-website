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
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('entry_by')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->unsignedBigInteger('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
