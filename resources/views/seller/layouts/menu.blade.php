<a class="nav-link @if(Request::is('seller/notification*')) active @endif" href="{{ route('seller_notification') }}">
    <div class="sb-nav-link-icon"><i class="fa-solid fa-bell"></i></div>Értesítések
    <span class="w-100">
        <span class="badge bg-danger float-end">{{ auth()->user()->unreadNotifications->count() }}</span>
    </span>
</a>
<a class="nav-link @if(Request::is('seller/product*')) active @endif" href="{{ route('seller_product') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-boxes-stacked"></i></div>Termékek
</a>
<a class="nav-link @if(Request::is('seller/user*')) active @endif" href="">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Alkalmazottak
</a>