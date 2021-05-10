<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_reservasi');
            $table->foreign('id_karyawan')->references('id')->on('users');
            $table->foreign('id_reservasi')->references('id')->on('reservasis');
            $table->integer('no_transaksi');
            $table->string('metode_pembayaran');
            $table->date('tgl_transaksi');
            $table->double('subtotal');
            $table->double('total');
            $table->string('kode_etc')->default('-');
            $table->string('status');
            $table->string('is_delete')->default('available');
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
        Schema::dropIfExists('transaksis');
    }
}


