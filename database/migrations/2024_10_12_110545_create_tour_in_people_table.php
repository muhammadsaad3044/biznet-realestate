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
        Schema::create('tour_in_person', function (Blueprint $table) {
            $table->id();
            $table->integer('p_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('date')->nullable();
            $table->boolean('not_sure_about_this_schedule')->default(0);
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('financing_options')->default(1);
            $table->boolean('working_as_realstate_agent')->default(0);
            $table->string('best_way_to_contact')->nullable();
            $table->boolean('agreement_committing_to_work_with_agent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_in_people');
    }
};
