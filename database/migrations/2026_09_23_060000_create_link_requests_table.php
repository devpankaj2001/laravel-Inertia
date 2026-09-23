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
        Schema::create('link_requests', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_company')->nullable();
            $table->string('client_website')->nullable();
            $table->string('target_page_url'); // e.g. /blog/sample-post or /services/custom-software
            $table->string('target_page_title')->nullable();
            $table->string('requested_anchor_text')->nullable();
            $table->string('target_link_url')->nullable(); // The URL they want linked back to their site
            $table->string('link_type')->default('link_insertion'); // link_insertion, guest_post, sponsored_feature, service_partnership
            $table->string('budget_offer')->nullable(); // e.g. $100-$250, $250-$500, $500+, Negotiable
            $table->text('proposed_context')->nullable(); // Sentence / paragraph where link should go
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, accepted, rejected, published
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('client_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_requests');
    }
};
