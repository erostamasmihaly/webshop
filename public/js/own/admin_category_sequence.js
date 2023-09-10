$(function () {

    $("#dialog-confirm").hide();

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
                    $("#sortable").append("<li id='li_"+val.id+"' level='"+val.level+"' class='mb-2'><span class='badge bg-info text-dark' style='margin-left: "+val.level*30+"px;'>"+val.name+"</span></li>");
                });
                console.log(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // Elem elmozgatása befejeződött
    $("#sortable").on("sortstop", function(event, ui) {

        // Aktuális elem ID lekérdezése
        id = ui.item.attr("id");
        
        // Felugró ablak megjelenítése
        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "<<": function() {
                    $(this).dialog("close");
                    change(id, -1);
                },
                "--": function() {
                    $(this).dialog("close");
                    change(id, 0);
                },
                ">>": function() {
                    $(this).dialog("close");
                    change(id, 1);
                }
            }
        });
    });

    // Előző elem ID lekérdezése
    function get_previous(id) {
        return $("#"+id).prev().attr("id");
    }

    // Következő elem ID lekérdezése
    function get_next(id) {
        return $("#"+id).next().attr("id");
    }

    // Módosítás
    function change(id, where) {

        // Előző és következő elemek lekérdezése
        prev_id = get_previous(id);
        next_id = get_next(id);

        // Ha van előző leem
        if (prev_id != undefined) {

            // Lekérdezni, hogy milyen szinten van
            prev_level = parseInt($("#"+prev_id).attr("level"));

            // Mostani elem szintje ettől legyen a megadott eltéréssel
            level = prev_level + where;

            // Ha van következő elem
            if (next_id != undefined) {

                // Lekérdezni, hogy annak mi a szintje
                next_level = parseInt($("#"+next_id).attr("level"));

                // Két elem közti szintkülönbség lekérdezése
                dist_level = next_level - level;

                // Ha 2 lenne az eltérés
                if (dist_level==2) {

                    // Mostani elem egyel kintebb tolás
                    level+=1;
                }
            }

            // Ha 0-nál kisebb érték jönne ki, akkor maradna 0
            if (level<0) level = 0;

            // Ezen új értékek szerint beállítani
            $("#"+id).attr("level", level).find("span").css("margin-left", level*30+"px");
        } else {

            // Beállítani, mint 0 szintű elemet
            $("#"+id).attr("level", 0).find("span").css("margin-left", "0px");
        }
    }


});