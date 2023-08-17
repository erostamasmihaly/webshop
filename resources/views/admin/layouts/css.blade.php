<!-- Külső -->
<link href="{{ asset('css/kulso/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/kulso/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/kulso/sb-styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/kulso/jquery-ui.css') }}" rel="stylesheet">

<!-- Saját --->
<link href="{{ asset('css/sajat/tablak.css') }}" rel="stylesheet">

<!-- Admin: Üzlet szerkesztése -->
@if (Request::is('admin/shop/edit/*'))
    <link href="{{ asset('css/sajat/admin_shop_edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/kulso/leaflet.css') }}" rel="stylesheet">
@endif
