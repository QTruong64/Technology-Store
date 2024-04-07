<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('public_id')->default(str()->random())->unique();
            $table->bigInteger('user_id');
            $table->bigInteger('type_id');
            $table->string('name');
            $table->string('slug');
            $table->string('short_desc');
            $table->text('desc');
            $table->string('image');
            $table->integer('view')->default(0);
            $table->integer('status')->default(0);
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
};
