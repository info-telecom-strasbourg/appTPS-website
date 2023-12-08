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
        Schema::connection('bde_bdd')->create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('short_name', 50)->unique()->nullable();
            $table->string('name', 50)->unique();
            $table->longText('description')->nullable();
            $table->string('website_link', 255)->nullable();
            $table->string('facebook_link', 255)->nullable();
            $table->string('twitter_link', 255)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->string('discord_link', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->boolean('association')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('bde_bdd')->dropIfExists('organization');
    }
};
