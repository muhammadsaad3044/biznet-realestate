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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('cat_id')->nullable();
            $table->integer('agent_id')->nullable();
            $table->integer('fliter_home_id')->nullable();
            $table->integer('fliter_apartment_id')->nullable();
            $table->integer('fliter_rent_id')->nullable();
            $table->string('title')->nullable();
            $table->Text('desc')->nullable();
            $table->Text('product')->nullable();
            $table->string('location')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->integer('is_approved')->nullable();
            $table->string('user_type')->nullable();
            $table->string('map_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
