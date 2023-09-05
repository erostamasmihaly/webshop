<!-- Külső -->
<script src="{{ asset('js/external/jquery-3.6.0.min.js') }}" defer></script>
<script src="{{ asset('js/external/jquery.colorbox.js') }}" defer></script>
<script src="{{ asset('js/external/datatables.min.js') }}" defer></script>
<script src="{{ asset('js/external/font-awesome.js') }}" defer></script>

<!-- Saját -->
<script src="{{ asset('js/own/tables.js') }}" defer></script>
@if (Request::is('product/*'))
    <script src="{{ asset('js/own/buyer_product.js') }}" defer></script>
@endif
@if (Request::is('buyer/cart'))
    <script src="{{ asset('js/own/buyer_cart.js') }}" defer></script>
@endif
@if (Request::is('buyer/user'))
    <script src="{{ asset('js/own/buyer_user.js') }}" defer></script>
@endif
@if (Request::is('shop/*'))
    <script src="{{ asset('js/own/buyer_shop.js') }}" defer></script>
    <script src="{{ asset('js/external/leaflet.js') }}" defer></script>
@endif
@if (Request::is('pay/transaction_success'))
    <script src="{{ asset('js/own/pay_transaction_success.js') }}" defer></script>
@endif
