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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); 
            $table->text('description')->nullable();
            $table->string('video');
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
        // Schema::table('videos', function (Blueprint $table) {
        //     $table->dropForeign(['author_id']);
        // });
        Schema::dropIfExists('videos');
    }
};
