<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOldStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_standards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sk_revisi')->unsigned();
            $table->string('nmr_sni_lama');
            $table->longText('jdl_sni_lama');
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
        Schema::dropIfExists('old_standards');
    }
}
