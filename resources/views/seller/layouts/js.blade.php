<!-- Külső -->
<script src="{{ asset('js/external/jquery-3.6.0.min.js') }}" defer></script>
<script src="{{ asset('js/external/sb-scripts.js') }}" defer></script>
<script src="{{ asset('js/external/datatables.min.js') }}" defer></script>
<script src="{{ asset('js/external/select2.min.js') }}" defer></script>
<script src="{{ asset('js/external/jquery-ui.js') }}" defer></script>
<script src="{{ asset('js/external/popper.min.js') }}" defer></script>
<script src="{{ asset('js/external/font-awesome.js') }}" defer></script>

<!-- Saját -->
<script src="{{ asset('js/own/select2.js') }}" defer></script>
<script src="{{ asset('js/own/selectdate.js') }}" defer></script>
<script src="{{ asset('js/own/tables.js') }}" defer></script>

@if (Request::is('seller/product/edit/*'))
    <script src="{{ asset('js/own/seller_product_edit.js') }}" defer></script>
@endif
