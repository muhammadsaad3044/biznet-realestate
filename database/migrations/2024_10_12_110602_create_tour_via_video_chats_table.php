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
        Schema::create('tour_via_video_chats', function (Blueprint $table) {
            $table->id();
            $table->integer('p_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('backup_date')->nullable();
            $table->string('backup_time')->nullable();
            $table->string('join_us_through')->nullable();
            $table->string('prefer_video_chat_app')->nullable();
            $table->string('id_or_number')->nullable();
            $table->string('prefer_backup_date')->nullable();
            $table->string('prefer_backup_time')->nullable();
            $table->string('prefer_backup_date_1')->nullable();
            $table->string('prefer_backup_time_1')->nullable();
            $table->string('prefer_backup_date_2')->nullable();
            $table->string('prefer_backup_time_2')->nullable();
            $table->boolean('working_as_realstate_agent')->default(0);
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('agreement_committing_to_work_with_agent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_via_video_chats');
    }
};
