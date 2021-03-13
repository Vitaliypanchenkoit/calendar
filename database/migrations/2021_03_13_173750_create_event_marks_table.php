<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('take_part');
            $table->boolean('not_interesting');
            $table->timestamps();
        });

        Schema::table('event_marks', function (Blueprint $table) {
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('event_marks', function (Blueprint $table) {
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
        Schema::table('event_marks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('event_marks', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
        });

        Schema::dropIfExists('event_marks');
    }
}
