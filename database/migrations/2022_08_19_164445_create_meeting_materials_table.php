<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_meeting_schedule')->unsigned();
            $table->string('nmr_sni_lama');
            $table->string('jdl_sni_lama');
            $table->integer('status_sni_lama')->nullable();
            $table->integer('status_nodin');
            $table->longText('catatan')->nullable();
            $table->timestamps();
        });

        //Set Foreign Key di kolom id_sni_lama pada tabel transition_times
        Schema::table('transition_times', function(Blueprint $table){
            $table->foreign('id_sni_lama')->references('id')->on('meeting_materials')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Foreign Key di kolom id_sni_lama di tabel transition_times
        Schema::table('transition_times', function(Blueprint $table){
            $table->dropForeign('transition_times_id_sni_lama_foreign');
        });

        Schema::dropIfExists('meeting_materials');
    }
}
