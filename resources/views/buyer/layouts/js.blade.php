<!-- Külső -->
<script src="{{ asset('js/external/jquery-3.6.0.min.js') }}" defer></script>
<script src="{{ asset('js/external/jquery.colorbox.js') }}" defer></script>

<!-- Saját -->
@if (Request::is('product/*'))
    <script src="{{ asset('js/own/product.js') }}" defer></script>
@endif
