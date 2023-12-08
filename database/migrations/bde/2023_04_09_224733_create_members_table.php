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
        Schema::connection('bde_bdd')->create('members', function (Blueprint $table) {
            $table->id();
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->bigInteger('card_number')->unique()->nullable();
            $table->string('email', 50)->unique();
            $table->string('phone', 50)->unique()->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->boolean('admin')->default(false);
            $table->boolean('contributor')->default(false);
            $table->date('birth_date')->nullable();
            $table->string('sector')->nullable();
            $table->timestamp('created_at')->default(now());
            $table->integer('class')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('bde_bdd')->dropIfExists('members');
    }
};
