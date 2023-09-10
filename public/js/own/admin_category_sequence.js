$(function () {

    $("#sortable").sortable();

    load_sequence();

    function load_sequence() {
        
        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/admin/category/sequence/load",
            type: "GET",
            cache: false,
            success: function (data) {
                $("#sortable").html("");
                $.each(data, function (key, val) {
                    $("#sortable").append("<li id='"+val.id+"' class='m-2'><span class='badge bg-info text-dark '>"+val.name+"</span></li>");
                });
            },
            error: function (error) {
                console.log(error);
            }
        });

    }
});