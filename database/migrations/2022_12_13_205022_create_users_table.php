<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_unistra', 50)->unique();
            $table->bigInteger('id_bde')->nullable();
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('username', 50)->nullable();
            $table->string('email')->unique();
            $table->boolean('redacteur')->default(FALSE);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
