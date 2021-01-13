<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Menggunakan Model Product
use App\Product;
// Menggunakan Model Category
use App\Category;

class FrontController extends Controller
{
    // Menampilkan Produk (Index)
    public function index()
    {
        //MEMBUAT QUERY UNTUK MENGAMBIL DATA PRODUK YANG DIURUTKAN BERDASARKAN TGL TERBARU
        //DAN DI-LOAD 10 DATA PER PAGENYA
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        //LOAD VIEW INDEX.BLADE.PHP DAN PASSING DATA DARI VARIABLE PRODUCTS
        return view('ecommerce.index', compact('products'));
    }

    // Menampilkan Detail Dari Produk (Show)
    public function show($slug)
    {
        //QUERY UNTUK MENGAMBIL SINGLE DATA BERDASARKAN SLUG-NYA
        $product = Product::with(['category'])->where('slug', $slug)->first();
        //LOAD VIEW SHOW.BLADE.PHP DAN PASSING DATA PRODUCT
        return view('ecommerce.show', compact('product'));
    }
    

    // Mengirimkan Semua Data Produk 
    public function product()
    {
        //BUAT QUERY UNTUK MENGAMBIL DATA PRODUK, LOAD PER PAGENYA KITA GUNAKAN 12 AGAR PRESISI PADA HALAMAN TERSEBUT KARENA DALAM SEBARIS MEMUAT 4 BUAH PRODUK
        $products = Product::orderBy('created_at', 'DESC')->paginate(12);


        //BAGIAN BAWAH INI (YANG DIUBAH JADI COMMENT) TIDAK DIPERLUKAN LAGI KARENA SUDAH DI HANDEL CATEGORY COMPOSER UNTUK MENINGKATKAN EFEKTIFITAS PENGKODEAN
            // //LOAD JUGA DATA KATEGORI YANG AKAN DITAMPILKAN PADA SIDEBAR
            // $categories = Category::with(['child'])->withCount(['child'])->getParent()->orderBy('name', 'ASC')->get();
            // //LOAD VIEW PRODUCT.BLADE.PHP DAN PASSING KEDUA DATA DIATAS
        
        return view('ecommerce.product', compact('products', 'categories'));
    }

    // Menampilkan data produk dari kategori yang dipilih dengan parameter slug
    public function categoryProduct($slug)
    {
       //JADI QUERYNYA ADALAH KITA CARI DULU KATEGORI BERDASARKAN SLUG, SETELAH DATANYA DITEMUKAN
       //MAKA SLUG AKAN MENGAMBIL DATA PRODUCT YANG BERELASI MENGGUNAKAN METHOD PRODUCT() YANG TELAH DIDEFINISIKAN PADA FILE CATEGORY.PHP SERTA DIURUTKAN BERDASARKAN CREATED_AT DAN DI-LOAD 12 DATA PER SEKALI LOAD
        $products = Category::where('slug', $slug)->first()->product()->orderBy('created_at', 'DESC')->paginate(12);
        //LOAD VIEW YANG SAMA YAKNI PRODUCT.BLADE.PHP KARENA TAMPILANNYA AKAN KITA BUAT SAMA JUGA
        return view('ecommerce.product', compact('products'));
    }
    
    


    
}
