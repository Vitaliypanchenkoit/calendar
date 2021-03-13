<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('important');
            $table->boolean('read');
            $table->timestamps();
        });

        Schema::table('news_marks', function (Blueprint $table) {
            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('news_marks', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
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
        Schema::table('news_marks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('news_marks', function (Blueprint $table) {
            $table->dropForeign(['news_id']);
        });

        Schema::dropIfExists('news_marks');
    }
}
