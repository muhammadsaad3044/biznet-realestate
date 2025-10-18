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
        Schema::create('schedule_projects', function (Blueprint $table) {
            $table->id();
            $table->string('proj_name')->nullable();
            $table->string('proj_date')->nullable();
            $table->Text('proj_desc')->nullable();
            $table->string('estimate_duration')->nullable();
            $table->string('proj_status')->nullable();
            $table->string('assign_team_member')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_projects');
    }
};
