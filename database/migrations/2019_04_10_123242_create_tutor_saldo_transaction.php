<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorSaldoTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('tutor_saldo_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tutor');
            $table->integer('withdraw_amount');
            $table->integer('withdraw_status');
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

        Schema::dropIfExists('tutor_saldo_transaction');

    }
}
