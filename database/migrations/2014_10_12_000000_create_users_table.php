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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->char('language', 5)->default('de');
            $table->enum('state', Status::values())->default(Status::ACTIVE);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->enum('sex', ['MALE', 'FEMALE', 'DIVERS'])->default('MALE')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('DE')->nullable();

            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();

            $table->index(['id', 'email']);
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
