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
        schema::create('post_medias', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->integer('media_type_id');
            $table->string('media_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('post_medias');
    }
};
