<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_course', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('course_id');
          $table->integer('is_deleted');
          $table->timestamps();
          $table->index('user_id');
          $table->index('course_id');
          $table->index('is_deleted');
          $table->index(['user_id', 'course_id', 'is_deleted']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('user_course');

    }
}
