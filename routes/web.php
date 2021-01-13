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

// Route::get('/', function () {
//     return view('welcome');
// });




// BAGIAN LOGIN DAN REGISTRASI
Auth::routes();

// USER/CUSTOMER (BAGIAN USER)
//CONTOH: /.....
    // BAGIAN DEPAN YANG MEMUNCULKAN PRODUK
    Route::get('/', 'Ecommerce\FrontController@index')->name('front.index');
    // BAGIAN MENGIRIMKAN SEMUA DATA PRODUK
    Route::get('/product', 'Ecommerce\FrontController@product')->name('front.product');
    // BAGIAN JIKA KATEGORI DI KLIK AKAN MUNCUL DATA
    Route::get('/category/{slug}', 'Ecommerce\FrontController@categoryProduct')->name('front.category');
    // BAGIAN DETAIL PRODUK
    Route::get('/product/{slug}', 'Ecommerce\FrontController@show')->name('front.show_product');





// ADMINISTRASI (BAGIAN ADMIN)
//CONTOH: /administrator/.....

Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home'); //JADI ROUTING INI SUDAH ADA DARI ARTIKEL SEBELUMNYA TAPI KITA PINDAHKAN KEDALAM GROUPING

    //INI ADALAH ROUTE UNTUK KATEGORI BARU (Merangkum route store, index, update, delete. Kecuali create dan show )
    Route::resource('category', 'CategoryController')->except(['create', 'show']);

    //INI ADALAH ROUTE UNTUK PRODUK (Merangkum route store, index, update, delete dan create. Kecuali show, karena tidak dibutuhkan)
    Route::resource('product', 'ProductController')->except(['show']);

    //MASS UPLOAD (MEMASUKAN DATA DARI DOKUMEN EXCEL)
        //INI ADALAH ROUTE UNTUK MEMBUAT FORM DAN MENGARAHKANNYA KE VIEW BULK.
        Route::get('/product/bulk', 'ProductController@massUploadForm')->name('product.bulk'); //TAMBAHKAN ROUTE INI

        //INI ADALAH ROUTE UNTUK MENGIRIMKAN DATA (POST) DARI BENTUK EXCEL KE DALAM DATABASE .
        Route::post('/product/bulk', 'ProductController@massUpload')->name('product.saveBulk');


});
