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
        Schema::create('start_an_offers', function (Blueprint $table) {
            $table->id();
            $table->integer('p_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('how_much_you_offer')->nullable();
            $table->string('plan_on_buying')->nullable();
            $table->string('tour_this_home_in_person')->nullable();
            $table->Text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('start_an_offers');
    }
};
