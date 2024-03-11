<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            $table->enum('type',['user','writer','admin'])->default('user');

            $table->string('about')->nullable();
            $table->string('image')->default('admin.png');
            $table->string('facebook')->default('www.acebook.com');
            $table->string('twitter')->default('www.twitter.com');
            $table->string('ins')->default('www.instagram.com');
            $table->string('password');


            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
