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
        if (!Schema::hasTable('committee_member_infos')) {
            Schema::create('committee_member_infos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('designation_id')->nullable();
                $table->unsignedBigInteger('member_category_id')->nullable();
                $table->string('name_bn')->nullable();
                $table->string('name_en')->nullable();
                $table->string('email')->nullable();
                $table->string('mobile')->nullable();
                $table->string('article_url')->nullable();
                $table->string('photo')->nullable();
                $table->longText('description')->nullable();
                $table->string('slug')->nullable();
                $table->unsignedBigInteger('entry_by')->nullable();
                $table->timestamp('entry_time')->nullable();
                $table->unsignedBigInteger('last_update_by')->nullable();
                $table->timestamp('last_update_time')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->foreign('designation_id')
                    ->references('id')->on('designations')
                    ->onDelete('set null');

                $table->foreign('member_category_id')
                    ->references('id')->on('member_categories')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_member_infos');
    }
};
