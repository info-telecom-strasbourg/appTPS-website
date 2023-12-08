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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bde_id')->unique()->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->string('unistra_id')->unique()->nullable();
            $table->string('user_name')->unique()->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->year('promotion_year')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sector_id')->references('id')->on('sectors')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
