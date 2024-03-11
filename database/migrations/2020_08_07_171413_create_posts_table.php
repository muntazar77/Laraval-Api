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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // $table->string('des');
            $table->longText('content');
            $table->integer('category_id');
            $table->unsignedInteger("visits")->default(0);
            $table->string('image');
            $table->string('slug')->index();

            // $table->boolean('featured')->default(0);
            $table->enum('featured',['0','1'])->default('0');

            $table->integer('user_id');
            $table->text('meta_description')->nullable();
            // $table->string('seo_title')->nullable();


            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
}
