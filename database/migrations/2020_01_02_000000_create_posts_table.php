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
            $table->string('name', 100)->unique();
			$table->string('email', 320)->unique();
			$table->text('message')->nullable();
			$table->string('upload_filename', 100);
            $table->integer('upload_width');
            $table->integer('upload_height');
			$table->boolean('public');
			$table->boolean('patrolled');
			$table->bigInteger('source_id')->unsigned();
            $table->integer('like_num')->unsigned();
            $table->timestamps();
            $table->foreign('source_id')->references('id')->on('sources');
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
