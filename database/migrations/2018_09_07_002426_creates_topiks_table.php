<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesTopiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('topiks', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_course');
          $table->longText('video');
          $table->string('judul_topik');
          $table->longText('penjelasan')->nullable();
          $table->integer('parent_id')->nullable();
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
      Schema::dropIfExists('topiks');
    }
}
