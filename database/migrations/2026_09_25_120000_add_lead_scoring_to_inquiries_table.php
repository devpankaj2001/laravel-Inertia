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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->unsignedSmallInteger('lead_score')->nullable()->after('status');
            $table->string('lead_intent', 50)->nullable()->after('lead_score');
            $table->text('ai_summary')->nullable()->after('lead_intent');
            $table->text('ai_suggested_reply')->nullable()->after('ai_summary');
            $table->timestamp('ai_analyzed_at')->nullable()->after('ai_suggested_reply');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn([
                'lead_score',
                'lead_intent',
                'ai_summary',
                'ai_suggested_reply',
                'ai_analyzed_at',
            ]);
        });
    }
};
