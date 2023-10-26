<!-- Külső -->
<link href="{{ asset('css/external/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/colorbox.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/datatables.min.css') }}" rel="stylesheet">

<!-- Saját --->
<link href="{{ asset('css/own/tables.css') }}" rel="stylesheet">
@if (Request::is('vue/*'))
    <link href="{{ asset('css/own/vue.css') }}" rel="stylesheet">
@endif
@if (Request::is('/'))
    <link href="{{ asset('css/own/buyer_index.css') }}" rel="stylesheet">
@endif
@if (Request::is('shop/*'))
    <link href="{{ asset('css/own/buyer_shop.css') }}" rel="stylesheet">
    <link href="{{ asset('css/external/leaflet.css') }}" rel="stylesheet">
@endif
@if (Request::is('buyer/user'))
    <link href="{{ asset('css/own/buyer_user.css') }}" rel="stylesheet">
@endif