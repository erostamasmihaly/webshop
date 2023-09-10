$(function () {

    load_sequence();

    $("#sortable").sortable();

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
                    $("#sortable").append("<li id='li_"+val.id+"' category_id='"+val.category_id+"' level='"+val.level+"' class='mb-2'><span class='badge bg-info text-dark' style='margin-left: "+val.level*30+"px;'>"+val.name+"</span></li>");
                });
                console.log(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $("#sortable").on("sortstop", function(event, ui) {
        id = ui.item.attr("id");
        prev_id = get_previous(id);
        if (prev_id != undefined) {
            category_id = $("#"+prev_id).attr("category_id");
            level = $("#"+prev_id).attr("level");
            $("#"+id).attr("category_id", category_id).attr("level", level).find("span").css("margin-left", level*30+"px");
        } else {
            $("#"+id).attr("category_id", null).attr("level", 0).find("span").css("margin-left", "0px");
        }
    });

    

    function get_previous(id) {
        has_sibling = $("#"+id).prev().attr("id");
        return has_sibling;
    }


});