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
            $table->json('categories')->nullable()->after('category');
        });

        // Initialize existing services' categories with their current category
        try {
            $services = \Illuminate\Support\Facades\DB::table('services')->get();
            foreach ($services as $svc) {
                if (!empty($svc->category)) {
                    \Illuminate\Support\Facades\DB::table('services')
                        ->where('id', $svc->id)
                        ->update(['categories' => json_encode([$svc->category])]);
                }
            }
        } catch (\Throwable $e) {
            // Ignore if in fresh testing environment
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('categories');
        });
    }
};
