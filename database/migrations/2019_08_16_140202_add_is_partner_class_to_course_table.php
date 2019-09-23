<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPartnerClassToCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table(
            'courses', function (Blueprint $table) {
                $table->integer('is_partner_class')->nullable()->after('isPublished');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table(
            'courses', function (Blueprint $table) {
                $table->dropColumn('is_partner_class');
            }
        );

    }
}
