<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// BAGIAN LOGIN DAN REGISTRASI
Auth::routes();


// ADMINISTRASI (BAGIAN ADMIN)
//CONTOH: /administrator/.....

Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home'); //JADI ROUTING INI SUDAH ADA DARI ARTIKEL SEBELUMNYA TAPI KITA PINDAHKAN KEDALAM GROUPING

    //INI ADALAH ROUTE UNTUK KATEGORI BARU (Merangkum route store, index, update, delete. Kecuali create dan show )
    Route::resource('category', 'CategoryController')->except(['create', 'show']);

    //INI ADALAH ROUTE UNTUK PRODUK (Merangkum route store, index, update, delete, create dan show)
    Route::resource('product', 'ProductController');

});
