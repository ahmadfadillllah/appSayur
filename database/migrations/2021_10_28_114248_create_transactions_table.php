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

            // $table->foreignId('product_id');
            // $table->foreignId('penjual_id');
            // $table->text('catatan')->nullable();
            // $table->integer('harga_produk');
            // $table->integer('qty');
            // $table->integer('onkir');

            // General field
            $table->foreignId('user_id');
            $table->foreignId('order_id');
            $table->string('metode_pembayaran')->nullable();
            $table->string('total_transaksi');
            $table->string('status');
            $table->smallInteger('status_code')
                ->comment('1 = pending|authorize, 2 = deny|cancel|expire, 3 = capture|settlement, 4 = refund|partial_refund');

            // Misc
            $table->string('fraud_status')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('currency')->nullable();

            // Bank
            $table->string('bank')->nullable();
            $table->json('va_number')->nullable();

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
        Schema::dropIfExists('transactions');
    }
}
