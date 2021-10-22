<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product');
            $table->foreignId('pembeli_id');
            $table->foreignId('penjual_id');
            $table->string('nama_pembeli');
            $table->string('alamat_tujuan');
            $table->string('lat_lon');
            $table->text('catatan')->nullable();
            $table->string('metode_pembayaran');
            $table->integer('harga_produk');
            $table->string('total_transaksi');
            $table->integer('qty');
            $table->smallInteger('status');
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
        Schema::dropIfExists('checkouts');
    }
}
