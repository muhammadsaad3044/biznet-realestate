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
        Schema::create('user_profilings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('current_credit_score')->nullable();
            $table->string('empoyment_status')->nullable();
            $table->string('buy_home_or_investing_property')->nullable();
            $table->string('purchase_home_or_investing_property')->nullable();
            $table->string('opening_working_with_private_lender')->nullable();
            $table->string('fimilar_with_buy_or_investing_property')->nullable();
            $table->string('working_as_realtor')->nullable();
            $table->string('bought_house_before')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profilings');
    }
};
