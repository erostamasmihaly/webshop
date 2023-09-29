<a class="nav-link @if(Request::is('seller/notification*')) active @endif" href="{{ route('seller_notification') }}">
    <div class="sb-nav-link-icon"><i class="fa-solid fa-bell"></i></div>Értesítések
    @if(auth()->user()->unreadNotifications->count()>0)
        <span class="w-100">
            <span class="badge bg-danger float-end">{{ auth()->user()->unreadNotifications->count() }}</span>
        </span>
    @endif
</a>
<a class="nav-link @if(Request::is('seller/product*')) active @endif" href="{{ route('seller_product') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-boxes-stacked"></i></div>Termékek
</a>