<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Legacy AI categories (Cloud AI, Gen AI, MLOps, Vision, Data, Agentic AI) have been deprecated.
     * Active industry blogs are seeded via IndustryBlogPostsSeeder.
     */
    public function run(): void
    {
        // Category posts are managed dynamically or through IndustryBlogPostsSeeder
    }
}
