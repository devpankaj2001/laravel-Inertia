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
        Schema::create('ai_audits', function (Blueprint $table) {
            $table->id();
            $table->string('domain_url');
            $table->string('email');
            $table->string('phone', 50)->nullable();
            $table->unsignedInteger('speed_score')->nullable();
            $table->unsignedInteger('seo_score')->nullable();
            $table->json('performance_metrics')->nullable();
            $table->json('ai_roadmap')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('status', 50)->default('completed');
            $table->foreignId('inquiry_id')->nullable()->constrained('inquiries')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_audits');
    }
};
