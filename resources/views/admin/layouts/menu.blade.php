<a class="nav-link @if(Request::is('admin/user*')) active @endif" href="{{ route('admin_user') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Felhasználók
</a>
<a class="nav-link @if(Request::is('admin/category*')) active @endif" href="{{ route('admin_category') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-folder-tree"></i></div>Kategóriák
</a>
