<!-- MEMANGGIL MASTER TEMPLATE YANG SUDAH DIBUAT SEBELUMNYA, YAKNI admin.blade.php -->
@extends('layouts.admin')

{{-- Mengubah Title menjadi Tambah Produk --}}
@section('title')
    <title>Tambah Produk</title>
@endsection

@section('content')
<main class="main">

     {{-- Breadcrumb, Home > Product  --}}
      <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active">Product</li>
      </ol>

     {{-- Bagian Inti dari Halaman --}}
     <div class="container-fluid">
          <div class="animated fadeIn">
               
               <!-- TAMBAHKAN ENCTYPE="" KETIKA MENGIRIMKAN FILE PADA FORM -->
               <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                         <div class="col-md-8">

                              {{-- Card 1 : Nama dan Deskripsi --}}
                              <div class="card">

                                   {{-- Bagian Header dari Halaman --}}
                                   <div class="card-header">
                                        <h4 class="card-title">Tambah Produk</h4>
                                   </div>

                                   {{-- Bagian Inti dari Halaman --}}
                                   <div class="card-body">
                                        
                                        {{-- Nama --}}
                                        <div class="form-group">
                                             <label for="name">Nama Produk</label>
                                             <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                             <p class="text-danger">{{ $errors->first('name') }}</p>
                                        </div>

                                        {{-- Deskripsi --}}
                                        <div class="form-group">
                                             <label for="description">Deskripsi</label>
                                        
                                             <!-- TAMBAHKAN ID YANG NANTINYA DIGUNAKAN UTK MENGHUBUNGKAN DENGAN CKEDITOR -->
                                             <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                             <p class="text-danger">{{ $errors->first('description') }}</p>
                                        </div>

                                   </div>

                              </div>

                         </div>

                         <div class="col-md-4">

                              {{-- Card 2 : Status, Kategori, Harga, Berat dan Foto  --}}
                              <div class="card">
                                   <div class="card-body">

                                        {{-- Status --}}
                                        <div class="form-group">
                                             <label for="status">Status</label>
                                             <select name="status" class="form-control" required>
                                                  <option value="1" {{ old('status') == '1' ? 'selected':'' }}>Publish</option>
                                                  <option value="0" {{ old('status') == '0' ? 'selected':'' }}>Draft</option>
                                             </select>
                                             <p class="text-danger">{{ $errors->first('status') }}</p>
                                        </div>

                                        {{-- Kategori --}}
                                        <div class="form-group">
                                             
                                             <label for="category_id">Kategori</label>
                                             
                                             <!-- DATA KATEGORI DIGUNAKAN DISINI, SEHINGGA SETIAP PRODUK USER BISA MEMILIH KATEGORINYA -->
                                             <select name="category_id" class="form-control">
                                                  <option value="">Pilih</option>
                                                  @foreach ($category as $row)
                                                  <option value="{{ $row->id }}" {{ old('category_id') == $row->id ? 'selected':'' }}>{{ $row->name }}</option>
                                                  @endforeach
                                             </select>

                                             <p class="text-danger">{{ $errors->first('category_id') }}</p>
                                        </div>

                                        {{-- Harga --}}
                                        <div class="form-group">
                                             <label for="price">Harga</label>
                                             <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                                             <p class="text-danger">{{ $errors->first('price') }}</p>
                                        </div>

                                        {{-- Berat --}}
                                        <div class="form-group">
                                             <label for="weight">Berat</label>
                                             <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" required>
                                             <p class="text-danger">{{ $errors->first('weight') }}</p>
                                        </div>

                                        {{-- Foto Produk --}}
                                        <div class="form-group">
                                             <label for="image">Foto Produk</label>
                                             <input type="file" name="image" class="form-control" value="{{ old('image') }}" required>
                                             <p class="text-danger">{{ $errors->first('image') }}</p>
                                        </div>

                                        {{-- Submit --}}
                                        <div class="form-group">
                                             <button class="btn btn-primary btn-sm">Tambah</button>
                                        </div>

                                   </div>   
                              </div>

                         </div>
                    </div>
               </form>

          </div>
     </div>
</main>
@endsection

<!-- PADA ADMIN LAYOUTS, TERDAPAT YIELD JS YANG BERARTI KITA BISA MEMBUAT SECTION JS UNTUK MENAMBAHKAN SCRIPT JS JIKA DIPERLUKAN -->
@section('js')
    <!-- LOAD CKEDITOR Untuk Memasukan Inputan seperti Word -->
     <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
     <script>
          //TERAPKAN CKEDITOR PADA TEXTAREA DENGAN ID DESCRIPTION
          CKEDITOR.replace('description');
     </script>
@endsection
