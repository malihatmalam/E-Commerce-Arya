<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

// MODEL CATEGORY
use App\Category; 

class CategoryController extends Controller
{
    //Menampilkan data  
    public function index()
    {
        // MENAMPILKAN DATA (DARI DATABASE, TABEL CATEGORY)
        // DENGAN SYARAT DIAMBIL DARI DATA YANG MASUK PALING AKHIR ('created_at', 'DESC')
        // DAN MENGAMBIL JUGA DATA YANG BERELASI (FUNGSI RELATIONSHIPS ANTAR TABLE) DENGAN METHODE parent (YANG BERADA PADA MODEL CATEGORY)   
        // DAN DI PAGINATE 10 DATA (DIPISAHKAN YANG TAMPIL DI TABEL BERJUMLAH 10 DATA-AN)
            // JIKA LEBIH DARI 1 MAKA DAPAT DIPISAHKAN DENGAN KOMA, 
            // CONTOH: with(['parent', 'contoh1', 'contoh2'])
        $category = Category::with(['parent'])->orderBy('created_at', 'DESC')->paginate(10);
      
        // QUERY INI MENGAMBIL SEMUA LIST CATEGORY DARI TABLE CATEGORIES, PERHATIKAN AKHIRANNYA ADALAH GET() TANPA ADA LIMIT
        // LALU getParent() DARI MANA? METHOD TERSEBUT ADALAH SEBUAH LOCAL SCOPE
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();
      
        //LOAD VIEW DARI FOLDER CATEGORIES, DAN DIDALAMNYA ADA FILE INDEX.BLADE.PHP
        //KEMUDIAN PASSING DATA DARI VARIABLE $category & $parent KE VIEW AGAR DAPAT DIGUNAKAN PADA VIEW TERKAIT
        return view('categories.index', compact('category', 'parent'));
    }

    //Menambahkan data 
    public function store(Request $request)
    {
        //JADI KITA VALIDASI DATA YANG DITERIMA, DIMANA NAME CATEGORY WAJIB DIISI
        //TIPENYA ADA STRING DAN MAX KARATERNYA ADALAH 50 DAN BERSIFAT UNIK
        //UNIK MAKSUDNYA JIKA DATA DENGAN NAMA YANG SAMA SUDAH ADA MAKA VALIDASINYA AKAN MENGEMBALIKAN ERROR
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories'
        ]);

        //FIELD slug AKAN DITAMBAHKAN KEDALAM COLLECTION $REQUEST
        $request->request->add(['slug' => $request->name]);
    
        //SEHINGGA PADA BAGIAN INI KITA TINGGAL MENGGUNAKAN $request->except()
        //YAKNI MENGGUNAKAN SEMUA DATA YANG ADA DIDALAM $REQUEST KECUALI INDEX _TOKEN
        //FUNGSI REQUEST INI SECARA OTOMATIS AKAN MENJADI ARRAY
        //CATEGORY::CREATE ADALAH MASS ASSIGNMENT UNTUK MEMBERIKAN INSTRUKSI KE MODEL AGAR MENAMBAHKAN DATA KE TABLE TERKAIT
        Category::create($request->except('_token'));
        //APABILA BERHASIL, MAKA REDIRECT KE HALAMAN LIST KATEGORI
        //DAN MEMBUAT FLASH SESSION MENGGUNAKAN WITH()
        //JADI WITH() DISINI BERBEDA FUNGSINYA DENGAN WITH() YANG DISAMBUNGKAN DENGAN MODEL
        return redirect(route('category.index'))->with(['success' => 'Kategori Baru Ditambahkan!']);
    }

    //Mengambil data dan mengirimkannya ke view edit (pada direktori category) 
    //yang nantinya untuk mengedit data 
    public function edit($id)
    {
        $category = Category::find($id); //QUERY MENGAMBIL DATA BERDASARKAN ID
        $parent = Category::getParent()->orderBy('name', 'ASC')->get(); //INI SAMA DENGAN QUERY YANG ADA PADA METHOD INDEX
    
        //LOAD VIEW EDIT.BLADE.PHP PADA FOLDER CATEGORIES
        //DAN PASSING VARIABLE CATEGORY & PARENT
        return view('categories.edit', compact('category', 'parent'));
    }

    //Melakukan edit data (Pembaharuan / Update) 
    public function update(Request $request, $id)
    {
        //VALIDASI FIELD NAME
        //YANG BERBEDA ADA TAMBAHAN PADA RULE UNIQUE
        //FORMATNYA ADALAH unique:nama_table,nama_field,id_ignore
        //JADI KITA TETAP MENGECEK UNTUK MEMASTIKAN BAHWA NAMA CATEGORYNYA UNIK
        //AKAN TETAPI KHUSUS DATA DENGAN ID YANG AKAN DIUPDATE DATANYA DIKECUALIKAN
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories,name,' . $id
        ]);

        $category = Category::find($id); //QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        //KEMUDMIAN PERBAHARUI DATANYA
        //POSISI KIRI ADALAH NAMA FIELD YANG ADA DITABLE CATEGORIES
        //POSISI KANAN ADALAH VALUE DARI FORM EDIT
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
    
        //REDIRECT KE HALAMAN LIST KATEGORI
        return redirect(route('category.index'))->with(['success' => 'Kategori Diperbaharui!']);
    }

    //Menghapus data 
    public function destroy($id)
    {
        //Buat query untuk mengambil category berdasarkan id menggunakan method find()
        //ADAPUN withCount() SERUPA DENGAN EAGER LOADING YANG MENGGUNAKAN with()
        //HANYA SAJA withCount() RETURNNYA ADALAH INTEGER
        //JADI NNTI HASIL QUERYNYA AKAN MENAMBAHKAN FIELD BARU BERNAMA child_count YANG BERISI JUMLAH DATA ANAK KATEGORI
        $category = Category::withCount(['child'])->find($id);
        //JIKA KATEGORI INI TIDAK DIGUNAKAN SEBAGAI PARENT ATAU CHILDNYA = 0
        if ($category->child_count == 0) {
            //MAKA HAPUS KATEGORI INI
            $category->delete();
            //DAN REDIRECT KEMBALI KE HALAMAN LIST KATEGORI
            return redirect(route('category.index'))->with(['success' => 'Kategori Dihapus!']);
        }
        //SELAIN ITU, MAKA REDIRECT KE LIST TAPI FLASH MESSAGENYA ERROR YANG BERARTI KATEGORI INI SEDANG DIGUNAKAN
        return redirect(route('category.index'))->with(['error' => 'Kategori Ini Memiliki Anak Kategori!']);
    }

    //MUTATOR : untuk memodifikasi data sebelum data sebelum
    //data disimpan ke dalam database. 
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    //ACCESSOR : formating dilakukan setelah data diterima dari database. 
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }




  
    //METHOD LAINNYA DISINI JIKA ADA
}
