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
        Schema::table('industry_domains', function (Blueprint $table) {
            $table->string('category_group')->nullable()->after('icon');
            $table->string('hero_tagline')->nullable()->after('description');
            $table->longText('detailed_content')->nullable()->after('hero_tagline');
            $table->json('challenges')->nullable()->after('detailed_content');
            $table->json('solutions')->nullable()->after('challenges');
            $table->json('technologies')->nullable()->after('solutions');
            $table->json('kpis')->nullable()->after('technologies');
            $table->json('faqs')->nullable()->after('kpis');
            $table->string('featured_image')->nullable()->after('faqs');
            $table->string('meta_title')->nullable()->after('featured_image');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('focus_keywords')->nullable()->after('meta_description');
            $table->text('custom_schema')->nullable()->after('focus_keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_domains', function (Blueprint $table) {
            $table->dropColumn([
                'category_group',
                'hero_tagline',
                'detailed_content',
                'challenges',
                'solutions',
                'technologies',
                'kpis',
                'faqs',
                'featured_image',
                'meta_title',
                'meta_description',
                'focus_keywords',
                'custom_schema',
            ]);
        });
    }
};
