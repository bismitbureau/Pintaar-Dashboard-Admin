<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPdfUrlMidtransToPembelianCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembelian_courses', function (Blueprint $table) {
            $table->text('pdf_url_midtrans')->nullable()->after('waktu_valid_pembelian');
            $table->integer('is_visible_on_transaction')->nullable()->after('pdf_url_midtrans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian_courses', function (Blueprint $table) {
            $table->dropColumn('pdf_url_midtrans');
            $table->dropColumn('is_visible_on_transaction');

        });
    }
}
