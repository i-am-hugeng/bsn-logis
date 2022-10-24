<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_memos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_meeting_schedule')->unsigned();
            $table->string('nmr_surat');
            $table->integer('jenis_nodin');
            $table->string('nmr_kepka')->nullable();
            $table->timestamps();
        });

        //Set Foreign Key di kolom id_official_memo pada tabel official_memo_histories
        Schema::table('official_memo_histories', function(Blueprint $table){
            $table->foreign('id_official_memo')->references('id')->on('official_memos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Foreign Key di kolom id_official_memo di tabel official_memo_histories
        Schema::table('official_memo_histories', function(Blueprint $table){
            $table->dropForeign('official_memo_histories_id_official_memo_foreign');
        });

        Schema::dropIfExists('official_memos');
    }
}
