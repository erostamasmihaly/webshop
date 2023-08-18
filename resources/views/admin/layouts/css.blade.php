<!-- Külső -->
<link href="{{ asset('css/external/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/sb-styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/jquery-ui.css') }}" rel="stylesheet">

<!-- Saját --->
<link href="{{ asset('css/own/tables.css') }}" rel="stylesheet">

<!-- Admin: Üzlet szerkesztése -->
@if (Request::is('admin/shop/edit/*'))
    <link href="{{ asset('css/own/admin_shop_edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/external/leaflet.css') }}" rel="stylesheet">
@endif
