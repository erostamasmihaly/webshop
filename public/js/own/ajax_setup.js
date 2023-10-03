$(function () {
    // CSRF token átküldése minden egyes hívás esetén
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').getAttribute('content')
        }
    });
});