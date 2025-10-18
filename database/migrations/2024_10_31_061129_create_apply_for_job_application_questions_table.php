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
        Schema::create('apply_for_job_application_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('appy_for_job_id')->nullable();
            $table->string('at_least_18_year_old')->nullable();
            $table->string('legal_rights_to_work_in_country')->nullable();
            $table->string('need_visa_support')->nullable(); 
            $table->string('preferred_pronouns')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_for_job_application_questions');
    }
};
