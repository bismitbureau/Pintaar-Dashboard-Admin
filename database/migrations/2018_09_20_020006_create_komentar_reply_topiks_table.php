<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKomentarReplyTopiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('reply_komentar_topiks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_komentar_topik');
            $table->integer('id_user');
            $table->longText('komentar');
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
        //

        Schema::dropIfExists('reply_komentar_topiks');

    }
}
