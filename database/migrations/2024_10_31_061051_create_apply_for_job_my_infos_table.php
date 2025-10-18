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
        Schema::create('apply_for_job_my_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('appy_for_job_id')->nullable();
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->string('country')->nullable(); 
            $table->string('preferred_name')->nullable();

            $table->longText('address_line_1')->nullable();
            $table->longText('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_device_type')->nullable();
            $table->string('country_phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('how_you_hear_about_us')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_for_job_my_infos');
    }
};
