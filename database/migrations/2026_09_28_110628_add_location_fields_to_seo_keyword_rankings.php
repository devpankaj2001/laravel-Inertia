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
        Schema::table('seo_keyword_rankings', function (Blueprint $table) {
            $table->string('state', 100)->nullable()->after('country');
            $table->string('district', 100)->nullable()->after('state');
            $table->string('search_volume', 50)->nullable()->after('ai_intent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_keyword_rankings', function (Blueprint $table) {
            $table->dropColumn(['state', 'district', 'search_volume']);
        });
    }
};
