<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // General field
            $table->foreignId('product_id');
            $table->foreignId('pembeli_id');
            $table->foreignId('penjual_id');
            $table->string('order_id')->unique();
            $table->text('catatan')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->integer('harga_produk');
            $table->string('total_transaksi');
            $table->integer('qty');
            $table->integer('onkir');
            $table->string('status');
            $table->smallInteger('status_code')
                ->comment('1 = pending|authorize, 2 = deny|cancel|expire, 3 = capture|settlement, 4 = refund|partial_refund');
            $table->timestamp('expired_at');
            $table->timestamps();

            // Misc
            $table->string('fraud_status')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('currency')->nullable();

            // Bank
            $table->string('bank')->nullable();
            $table->integer('va_number')->nullable();

            // Store
            $table->string('store')->nullable();

            // Card detail data
            $table->string('masked_card')->nullable();
            $table->string('approval_code')->nullable();
            $table->string('eci')->nullable();

            // Shipping address
            $table->string('first_name');
            $table->string('last_name');
            $table->string('alamat_tujuan');
            $table->string('email');
            $table->string('postal_code');
            $table->string('city')->default('makassar');
            $table->string('nomor_telp');
            $table->string('lat_lon');
            $table->string('country_code')->default('IDN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
