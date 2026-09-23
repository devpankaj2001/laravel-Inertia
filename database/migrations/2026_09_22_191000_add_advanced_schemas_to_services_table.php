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
            $table->json('local_schema')->nullable()->after('faqs');
            $table->json('business_schema')->nullable()->after('local_schema');
            $table->longText('custom_schema')->nullable()->after('business_schema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['local_schema', 'business_schema', 'custom_schema']);
        });
    }
};
