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
        Schema::table('services', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('short_description');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('focus_keywords')->nullable()->after('meta_description');
            $table->string('og_image')->nullable()->after('focus_keywords');
            $table->longText('detailed_content')->nullable()->after('og_image');
            $table->json('faqs')->nullable()->after('features');
            $table->json('process_steps')->nullable()->after('faqs');
            $table->json('technologies')->nullable()->after('process_steps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'focus_keywords',
                'og_image',
                'detailed_content',
                'faqs',
                'process_steps',
                'technologies',
            ]);
        });
    }
};
