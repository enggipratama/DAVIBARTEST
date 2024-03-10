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
        Schema::create('tbl_status_order', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('diskon');
            $table->string('kode_inv');
            $table->string('status_tanggal');
            $table->enum('status', ['Pending','Dikirim','Selesai','Dibatalkan'])->default('Pending');
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
        Schema::dropIfExists('tbl_status_order');
    }
};
