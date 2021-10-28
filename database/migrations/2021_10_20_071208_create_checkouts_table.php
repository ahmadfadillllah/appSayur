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
            $table->foreignId('product_id');
            $table->foreignId('pembeli_id');
            $table->foreignId('penjual_id');
            $table->string('order_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('alamat_tujuan');
            $table->string('email');
            $table->string('postal_code');
            $table->string('city');
            $table->string('nomor_telp');
            $table->string('lat_lon');
            $table->text('catatan')->nullable();
            $table->string('metode_pembayaran');
            $table->integer('harga_produk');
            $table->string('total_transaksi');
            $table->integer('qty');
            $table->integer('onkir');
            $table->smallInteger('status')->comment('1 = pending, 2 = gagal, 3 = success, 4 = error');
            $table->timestamp('expired_at');
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
