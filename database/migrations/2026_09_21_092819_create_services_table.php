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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // 'Engineering & Architecture', 'Growth & Intelligence', 'Design & Reliability'
            $table->string('icon');
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();
            $table->string('badge')->nullable();
            $table->json('features')->nullable();
            $table->string('kpi_label')->nullable();
            $table->string('kpi_value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
