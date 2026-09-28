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
        // 1. Google Keyword Ranking Searches & Results
        Schema::create('seo_keyword_rankings', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 255)->index();
            $table->string('keyword', 255)->index();
            $table->string('country', 10)->default('in');
            $table->integer('position')->nullable(); // e.g. 4, 18, or null if > 100
            $table->integer('page')->nullable();     // e.g. 1, 2
            $table->text('ranking_url')->nullable();
            $table->json('competitors')->nullable(); // Top 3 competitors
            $table->string('ai_difficulty', 50)->nullable(); // Easy, Medium, Hard
            $table->string('ai_intent', 50)->nullable();     // Commercial, Informational, etc.
            $table->text('ai_recommendations')->nullable();
            $table->string('user_email', 150)->nullable()->index();
            $table->string('user_ip', 45)->nullable();
            $table->timestamps();
        });

        // 2. Backlink & Domain Authority Audits
        Schema::create('seo_backlink_audits', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 255)->index();
            $table->unsignedInteger('domain_authority')->default(0); // 0 to 100
            $table->decimal('page_rank', 4, 2)->default(0.00);      // 0.00 to 10.00
            $table->unsignedInteger('dofollow_ratio')->default(75);
            $table->string('toxic_risk', 50)->default('Low Risk');
            $table->json('sample_links')->nullable();
            $table->text('ai_link_opportunities')->nullable();
            $table->string('user_email', 150)->nullable()->index();
            $table->string('user_ip', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_backlink_audits');
        Schema::dropIfExists('seo_keyword_rankings');
    }
};
