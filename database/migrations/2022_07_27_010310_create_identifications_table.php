<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sk_revisi')->unsigned();
            $table->string('komtek');
            $table->longText('sekretariat_komtek');
            $table->timestamps();
        });

        //Set Foreign Key di kolom id_identifikasi pada tabel standard_implementers
        Schema::table('standard_implementers', function(Blueprint $table){
            $table->foreign('id_identifikasi')->references('id')->on('identifications')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Foreign Key di kolom id_identifikasi di tabel standard_implementers
        Schema::table('standard_implementers', function(Blueprint $table){
            $table->dropForeign('standard_implementers_id_identifikasi_foreign');
        });

        Schema::dropIfExists('identifications');
    }
}
