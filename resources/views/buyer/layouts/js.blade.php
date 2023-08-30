<!-- Külső -->
<script src="{{ asset('js/external/jquery-3.6.0.min.js') }}" defer></script>
<script src="{{ asset('js/external/jquery.colorbox.js') }}" defer></script>
<script src="{{ asset('js/external/datatables.min.js') }}" defer></script>

<!-- Saját -->
<script src="{{ asset('js/own/tables.js') }}" defer></script>
@if (Request::is('product/*'))
    <script src="{{ asset('js/own/product.js') }}" defer></script>
@endif
@if (Request::is('buyer/cart'))
    <script src="{{ asset('js/own/buyer_cart.js') }}" defer></script>
@endif
