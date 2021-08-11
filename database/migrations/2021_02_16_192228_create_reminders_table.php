<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->time('time');
            $table->time('time_hold')->default(0);

            $table->foreignId('author_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->text('content')->nullable();
            $table->timestamps();

            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropForeign(['author_id']);
        });
        Schema::dropIfExists('reminders');
    }
}
