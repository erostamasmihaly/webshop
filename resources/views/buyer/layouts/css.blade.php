<!-- Külső -->
<link href="{{ asset('css/external/colorbox.css') }}" rel="stylesheet">

<!-- Saját --->
@if (Request::is('/'))
    <link href="{{ asset('css/own/buyer_index.css') }}" rel="stylesheet">
@endif
@if (Request::is('product/*'))
    <link href="{{ asset('css/own/product.css') }}" rel="stylesheet">
@endif