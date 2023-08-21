<a class="nav-link @if(Request::is('seller/product*')) active @endif" href="{{ route('seller_product') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Termékek
</a>
<a class="nav-link @if(Request::is('seller/user*')) active @endif" href="">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Alkalmazottak
</a>