<!-- Külső -->
<link href="{{ asset('css/external/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/sb-styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/jquery-ui.css') }}" rel="stylesheet">

<!-- Saját --->
<link href="{{ asset('css/own/tables.css') }}" rel="stylesheet">

@if (Request::is('seller/product/edit/*'))
    <link href="{{ asset('css/own/seller_product_edit.css') }}" rel="stylesheet">
@endif
