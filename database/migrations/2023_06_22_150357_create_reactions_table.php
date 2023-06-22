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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('post_comment_id')->nullable();
            $table->unsignedBigInteger('reaction_type_id');

            $table->foreign('reaction_type_id')->references('id')->on('reaction_types');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('post_comment_id')->references('id')->on('post_comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
