<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pic_rapat');
            $table->date('tanggal_rapat');
            $table->integer('status_pembahasan');
            $table->integer('status_nodin');
            $table->timestamps();
        });

        //Set Foreign Key di kolom id_meeting_schedule pada tabel meeting_materials
        Schema::table('meeting_materials', function(Blueprint $table){
            $table->foreign('id_meeting_schedule')->references('id')->on('meeting_schedules')->onDelete('cascade')->onUpdate('cascade');
        });

         //Set Foreign Key di kolom id_meeting_schedule pada tabel official_memos
         Schema::table('official_memos', function(Blueprint $table){
            $table->foreign('id_meeting_schedule')->references('id')->on('meeting_schedules')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Foreign Key di kolom id_meeting_schedule di tabel meeting_materials
        Schema::table('meeting_materials', function(Blueprint $table){
            $table->dropForeign('meeting_materials_id_meeting_schedule_foreign');
        });

        //Drop Foreign Key di kolom id_meeting_schedule di tabel official_memos
        Schema::table('official_memos', function(Blueprint $table){
            $table->dropForeign('official_memos_id_meeting_schedule_foreign');
        });

        Schema::dropIfExists('meeting_schedules');
    }
}
