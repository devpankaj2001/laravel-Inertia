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
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('author_role')->nullable()->after('author_name');
            $table->json('tags')->nullable()->after('category');
            $table->boolean('is_featured')->default(false)->after('is_published');
            $table->string('meta_title')->nullable()->after('featured_image');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('focus_keywords')->nullable()->after('meta_description');
            $table->json('faqs')->nullable()->after('content');
            $table->text('custom_schema')->nullable()->after('faqs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn([
                'author_role',
                'tags',
                'is_featured',
                'meta_title',
                'meta_description',
                'focus_keywords',
                'faqs',
                'custom_schema',
            ]);
        });
    }
};
