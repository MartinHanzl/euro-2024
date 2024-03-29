<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone_prefix')->default('+420');
            $table->string('phone')->nullable();
            $table->string('email');
            /*$table->string('street')->nullable();
            $table->integer('postcode')->nullable();
            $table->integer('city')->nullable();*/
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('verification_code', 64)->nullable();
            $table->string('invitation_code', 6)->nullable();
            $table->smallInteger('active')->default(0);
            $table->smallInteger('verified')->default(0);
            $table->rememberToken();
            $table->integer('points')->default(0);
            $table->timestamps();
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
