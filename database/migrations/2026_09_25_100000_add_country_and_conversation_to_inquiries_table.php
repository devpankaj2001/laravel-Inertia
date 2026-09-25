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
            $table->string('country', 100)->nullable()->after('ip_address');
            $table->foreignId('conversation_id')->nullable()->after('status')->constrained('ai_conversations')->nullOnDelete();
            $table->string('session_id', 64)->nullable()->index()->after('conversation_id');
        });

        Schema::table('ai_conversations', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('lead_phone');
            $table->string('country', 100)->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['conversation_id']);
            $table->dropColumn(['country', 'conversation_id', 'session_id']);
        });

        Schema::table('ai_conversations', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'country']);
        });
    }
};
