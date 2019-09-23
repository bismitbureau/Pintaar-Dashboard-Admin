<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesPertanyaanTopiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pertanyaan_topiks', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_topik');
          $table->string('pertanyaan');
          $table->string('judul_pertanyaan');
          $table->integer('jawaban');
          $table->string('opsi_1')->nullable();
          $table->string('opsi_2')->nullable();
          $table->string('opsi_3')->nullable();
          $table->string('opsi_4')->nullable();
          $table->string('gambar')->nullable();
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
      Schema::dropIfExists('pertanyaan_topiks');
  }

}
