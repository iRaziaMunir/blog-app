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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->morphs('commentable');
            $table->unsignedBigInteger('author_id'); // Add this line
            $table->foreign('author_id')->references('id')->on('users');            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('comments', function (Blueprint $table) {
        //     $table->dropForeign(['author_id']);
        // });
        Schema::dropIfExists('comments');
    }
};
