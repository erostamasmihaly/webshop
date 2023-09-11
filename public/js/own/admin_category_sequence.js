$(function () {

    // Felugró ablak elrejtése
    $("#dialog-confirm").hide();

    // Adatok betöltése
    load_sequence();

    // Sortable bekapcsolása
    $("#sortable").sortable();

    // Adatok beküldése
    function load_sequence() {
        
        // AJAX kérés
        $.ajax({
            dataType: "json",
            url: "/admin/category/sequence/load",
            type: "GET",
            cache: false,
            success: function (data) {

                // Lista űrítése
                $("#sortable").html("");

                // Végigmenni minden egyes elemen
                $.each(data, function (key, val) {

                    // Elem megfelelő megjelenítése
                    $("#sortable").append("<li id='"+val.id+"' level='"+val.level+"' class='mb-2'><span class='badge bg-info text-dark' style='margin-left: "+val.level*30+"px;'>"+val.name+"</span></li>");
                });
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

                // Előző szinten legyen
                "<<": function() {
                    $(this).dialog("close");
                    change(id, -1);
                },

                // Megegyező szinten legyen
                "--": function() {
                    $(this).dialog("close");
                    change(id, 0);
                },

                // Következő szinten legyen
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

            // Ha 0-nál kisebb érték jönne ki, akkor maradna 0
            if (level<0) level = 0;

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

            // Ezen új értékek szerint beállítani
            $("#"+id).attr("level", level).find("span").css("margin-left", level*30+"px");
        } else {

            // Beállítani, mint 0 szintű elemet
            $("#"+id).attr("level", 0).find("span").css("margin-left", "0px");
        }
    }

    

    // Szülő lekérdezése
    function get_parent(current_id, max_level) {

        // Mostani elem szintjének lekérdezése
        current_level = $("#"+current_id).attr("level");

        if (current_level==0) {
            
            // Ha nulla, akkor nincsen szüleje
            return null;

        } else {
        
            // Előző elem lekérdezése
            prev_id = get_previous(current_id);

            // Előző elem szintjének lekérdezése
            prev_level = $("#"+prev_id).attr("level");

            if (prev_level >= current_level) {

                // Ha egyezik, akkor folytatni tovább a keresést ezen előző elemmel
                return get_parent(prev_id, max_level);
            } else {

                // Ha kisebb, akkor viszatérni ezen elem azonosítójával
                if (max_level <= prev_level) {
                    return get_parent(prev_id, max_level);
                } else {
                    return prev_id;
                }
                
            }
        }

    }

    // Katefória fa összeállítása
    function get_tree() {

        // Üres tömb létrehozása
        array = [];

        // Végigmenni minden egyes elemen
        $("#sortable li").each(function() {
            
            // Lekérdezni az azonosítóját
            id = $(this).attr("id")

            // Lekérdezni a szintjét
            level = $(this).attr("level");

            // Lekérdezni a szülőjét
            parent_id = get_parent(id, level);

            // Objektum létrehozása
            obj = new Object();
            obj.id = id;
            obj.level = level;
            obj.parent_id = parent_id;
            obj.name = $("#"+id).find("span").html();
            obj.parent_name =  $("#"+parent_id).find("span").html();

            // Objektum elhelyezése a tömbbe
            array.push(obj);
        });

        // JSON létrehozása a tömbből
        json = JSON.stringify(array);

        // Visszatérés ezzel a JSON-nal
        return json;
    }

    // Mentés gomb
    $("body").on("click", "#save", function() {
        tree = get_tree();
        console.log(tree);
    });


});