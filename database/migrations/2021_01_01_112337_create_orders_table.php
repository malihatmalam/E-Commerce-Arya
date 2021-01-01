<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // YANG NANTI AKAN DI MIGRATE
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Atribute nomor pemesanan
            $table->string('invoice')->unique();
            // Atribute menghubungkan dengan customer 
            $table->string('customer_id');
            // Atribute penyimpanan nama kustomer (jika nanti profil kustomer berubah 
            // maka tidak merubah data di order )
            $table->string('customer_name');
            // Atribute penyimpanan nomor telepon kustomer (jika nanti profil kustomer berubah 
            // maka tidak merubah data di order )
            $table->string('customer_phone');
            // Atribute penyimpanan alamat kustomer (jika nanti profil kustomer berubah 
            // maka tidak merubah data di order )
            $table->string('customer_address');
            // Atribute yang menghubungkan dengan tabel district (Kecamatan)
            $table->unsignedBigInteger('district_id');
            // Atribute yang menyimpan total dari order
            $table->integer('subtotal');
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
        Schema::dropIfExists('orders');
    }
}
