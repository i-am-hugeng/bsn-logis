<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionDecreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_decrees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pic');
            $table->string('nmr_sk_sni');
            $table->longText('uraian_sk');
            $table->date('tanggal_sk');
            $table->date('tanggal_terima');
            $table->string('nmr_sni_baru');
            $table->longText('jdl_sni_baru');
            $table->year('tahun_sni_baru');
            $table->integer('status_proses_pic');
            $table->integer('status_bahan_rapat');
            $table->integer('sifat_sni')->nullable();
            $table->timestamps();
        });

        //Set Foreign Key di kolom id_sk_revisi pada tabel old_standards
        Schema::table('old_standards', function(Blueprint $table){
            $table->foreign('id_sk_revisi')->references('id')->on('revision_decrees')->onDelete('cascade')->onUpdate('cascade');
        });

        //Set Foreign Key di kolom id_sk_revisi pada tabel identifications
        Schema::table('identifications', function(Blueprint $table){
            $table->foreign('id_sk_revisi')->references('id')->on('revision_decrees')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Foreign Key di kolom id_sk_revisi di tabel old_standards
        Schema::table('old_standards', function(Blueprint $table){
            $table->dropForeign('old_standards_id_sk_revisi_foreign');
        });

        //Drop Foreign Key di kolom id_sk_revisi di tabel identifications
        Schema::table('identifications', function(Blueprint $table){
            $table->dropForeign('identifications_id_sk_revisi_foreign');
        });

        Schema::dropIfExists('revision_decrees');
    }
}
