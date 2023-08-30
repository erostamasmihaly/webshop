<!-- Külső -->
<link href="{{ asset('css/external/colorbox.css') }}" rel="stylesheet">
<link href="{{ asset('css/external/datatables.min.css') }}" rel="stylesheet">

<!-- Saját --->
<link href="{{ asset('css/own/tables.css') }}" rel="stylesheet">
@if (Request::is('/'))
    <link href="{{ asset('css/own/buyer_index.css') }}" rel="stylesheet">
@endif
@if (Request::is('product/*'))
    <link href="{{ asset('css/own/product.css') }}" rel="stylesheet">
@endif