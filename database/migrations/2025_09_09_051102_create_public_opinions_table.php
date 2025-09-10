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
        Schema::create('public_opinions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->longText('comment')->nullable();
            $table->string('attachment')->nullable();
            $table->string('attachment_display_name')->nullable();
            $table->string('user_ip')->nullable();
            $table->longText('user_agent_info')->nullable();
            $table->timestamp('entry_time')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_openions');
    }
};
