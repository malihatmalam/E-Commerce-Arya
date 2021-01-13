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

    // Mengirimkan Semua Data Produk 
    public function product()
    {
        //BUAT QUERY UNTUK MENGAMBIL DATA PRODUK, LOAD PER PAGENYA KITA GUNAKAN 12 AGAR PRESISI PADA HALAMAN TERSEBUT KARENA DALAM SEBARIS MEMUAT 4 BUAH PRODUK
        $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        //LOAD JUGA DATA KATEGORI YANG AKAN DITAMPILKAN PADA SIDEBAR
        $categories = Category::with(['child'])->withCount(['child'])->getParent()->orderBy('name', 'ASC')->get();
        //LOAD VIEW PRODUCT.BLADE.PHP DAN PASSING KEDUA DATA DIATAS
        return view('ecommerce.product', compact('products', 'categories'));
    }
    


    
}
