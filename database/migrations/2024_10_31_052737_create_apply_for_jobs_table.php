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
        Schema::create('apply_for_jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('receive_job_related_sms')->nullable();

            $table->string('opt_receive_job_related_email')->nullable();
            $table->string('are_you_18_years_old')->nullable();

            $table->string('legal_authorized_to_work_united_state')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_for_jobs');
    }
};
