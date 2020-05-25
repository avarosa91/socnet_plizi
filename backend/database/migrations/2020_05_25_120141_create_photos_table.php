<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('author_id', 24);
            $table->string('original_name')->default('');
            $table->string('path')->default('');
            $table->string('mime_type')->default('');
            $table->integer('size')->default(0);
            $table->string('image_normal_path')->nullable();
            $table->string('image_medium_path')->nullable();
            $table->string('image_thumb_path')->nullable();
            $table->integer('image_normal_width')->nullable();
            $table->integer('image_normal_height')->nullable();
            $table->integer('image_thumb_width')->nullable();
            $table->integer('image_thumb_height')->nullable();
            $table->integer('image_medium_width')->nullable();
            $table->integer('image_medium_height')->nullable();
            $table->integer('image_original_width')->nullable();
            $table->integer('image_original_height')->nullable();
            $table->integer('likes')->default(0);
            $table->string('creatable_id');
            $table->string('creatable_type')->nullable();
            $table->integer('updated_at')->default(time());
            $table->integer('created_at')->default(time());

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
