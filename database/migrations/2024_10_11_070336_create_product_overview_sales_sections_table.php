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
        Schema::create('product_overview_sales_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('p_id')->nullable();
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->string('price')->nullable();
            $table->string('est_price')->nullable();
            $table->string('price_tag')->nullable();
            $table->string('beds')->nullable();
            $table->string('bath')->nullable();
            $table->string('sq_ft')->nullable();
            $table->string('about_section_title')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_overview_sales_sections');
    }
};
