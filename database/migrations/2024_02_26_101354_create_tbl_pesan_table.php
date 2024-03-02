<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pesan', function (Blueprint $table) {
            $table->increments('pesan_id');
            $table->string('pesan_kode');
            $table->string('pesan_jumlah');
            $table->string('pesan_status');
            $table->string('pesan_totalharga');
            $table->string('pesan_idbarang');
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
        Schema::dropIfExists('tbl_pesan');
    }
};