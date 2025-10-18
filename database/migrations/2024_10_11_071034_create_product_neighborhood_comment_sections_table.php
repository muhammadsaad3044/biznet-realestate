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
        Schema::create('product_neighborhood_comment_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('p_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->Text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_neighborhood_comment_sections');
    }
};
