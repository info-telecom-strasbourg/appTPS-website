<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('posts');

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('id_user');
            $table->string('email');
            $table->text('content');
            $table->string('asso_club');
            $table->json('file')->nullable();
            $table->boolean('is_delete')->default(FALSE);
            $table->timestamp('deleted_at')->nullable()->default(NULL);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
