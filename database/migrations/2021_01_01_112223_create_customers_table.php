<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     // YANG AKAN DI MIGRATE
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Atribute nama
            $table->string('name');
            // Atribute email yang nanti akan dijadikan username
            $table->string('email')->unique();
            // Atribute nomor telepon
            $table->string('phone_number');
            // Atribute detail alamat
            $table->string('address');
            // Atribute kecamatan (yang merujuk pada tabel district)
            $table->unsignedBigInteger('district_id');
            // Atribute Status dengan nilai false
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('customers');
    }
}
