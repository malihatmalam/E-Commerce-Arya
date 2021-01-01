<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */

     // YANG AKAN DI MIGRATE
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Atribute nama
            $table->string('name');
            // Atribute slug
            $table->string('slug');
            // Atribute yang menghubungkan dengan kategory
            $table->unsignedBigInteger('category_id');
            // Atribute deskripsi product
            $table->text('description')->nullable();
            // Atribute untuk gambar
            $table->string('image');
            // Atribute harga
            $table->integer('price');
            // Atribute berats
            $table->integer('weight');
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
        Schema::dropIfExists('products');
    }
}
