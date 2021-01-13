{{-- MENU --}}
<ul class="nav navbar-nav center_nav pull-right">

     <!--================ HOME =================-->
     <li class="nav-item active">
         <a class="nav-link" href="{{ route('front.index') }}">Home</a>
     </li>
     <!--================ HOME =================-->

     <!--================ PRODUK =================-->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('front.product') }}">Produk</a>
     </li>
     <li class="nav-item submenu dropdown">
         <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
         <ul class="dropdown-menu">
             <li class="nav-item">
                 <a class="nav-link" href="category.html">Shop Category</a>
             </li>
         </ul>
     </li>
     <!--================ PRODUK =================-->

     <!--================ KONTAK =================-->
     <li class="nav-item">
         <a class="nav-link" href="contact.html">Contact</a>
     </li>
     <!--================ KONTAK =================-->

 </ul>
 