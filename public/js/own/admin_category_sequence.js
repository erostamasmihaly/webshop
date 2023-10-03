$(function () {

    // Felugró ablak elrejtése
    document.getElementById("dialog-confirm").hide();

    // Kategória csoport lekérdezése
    category_group_id = document.getElementById("category_group_id").value;

    // Adatok betöltése
    load_sequence();

    // Sortable bekapcsolása
    document.getElementById("sortable").sortable();

    // Adatok beküldése
    function load_sequence() {
        
        // AJAX kérés
        $.ajax({
            dataType: "json",
            url: "/admin/category/sequence/load/"+category_group_id,
            type: "GET",
            cache: false,
            success: function (data) {

                // Lista űrítése
                document.getElementById("sortable").innerHTML("");

                // Végigmenni minden egyes elemen
                $.each(data, function (key, val) {

                    // Elem megfelelő megjelenítése
                    document.getElementById("sortable").append("<li id='"+val.id+"' level='"+val.level+"' class='mb-2'><span class='badge bg-info text-dark' style='margin-left: "+val.level*30+"px;'>"+val.name+"</span></li>");
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // Elem elmozgatása befejeződött
    document.getElementById("sortable").on("sortstop", function(event, ui) {

        // Aktuális elem ID lekérdezése
        id = ui.item.getAttribute("id");
        
        // Felugró ablak megjelenítése
        document.getElementById("dialog-confirm").dialog({
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
        return document.getElementById(""+id).prev().getAttribute("id");
    }

    // Következő elem ID lekérdezése
    function get_next(id) {
        return document.getElementById(""+id).next().getAttribute("id");
    }

    // Módosítás
    function change(id, where) {

        // Előző és következő elemek lekérdezése
        prev_id = get_previous(id);
        next_id = get_next(id);

        // Ha van előző leem
        if (prev_id != undefined) {

            // Lekérdezni, hogy milyen szinten van
            prev_level = parseInt(document.getElementById(""+prev_id).getAttribute("level"));

            // Mostani elem szintje ettől legyen a megadott eltéréssel
            level = prev_level + where;

            // Ha 0-nál kisebb érték jönne ki, akkor maradna 0
            if (level<0) level = 0;

            // Ha van következő elem
            if (next_id != undefined) {

                // Lekérdezni, hogy annak mi a szintje
                next_level = parseInt(document.getElementById(""+next_id).getAttribute("level"));

                // Két elem közti szintkülönbség lekérdezése
                dist_level = next_level - level;

                // Ha 2 lenne az eltérés
                if (dist_level==2) {

                    // Mostani elem egyel kintebb tolás
                    level+=1;
                }
            }

            // Ezen új értékek szerint beállítani
            document.getElementById(""+id).getAttribute("level", level).find("span").css("margin-left", level*30+"px");
        } else {

            // Beállítani, mint 0 szintű elemet
            document.getElementById(""+id).getAttribute("level", 0).find("span").css("margin-left", "0px");
        }
    }

    

    // Szülő lekérdezése
    function get_parent(current_id, max_level) {

        // Mostani elem szintjének lekérdezése
        current_level = document.getElementById(""+current_id).getAttribute("level");

        if (current_level==0) {
            
            // Ha nulla, akkor nincsen szüleje
            return null;

        } else {
        
            // Előző elem lekérdezése
            prev_id = get_previous(current_id);

            // Előző elem szintjének lekérdezése
            prev_level = document.getElementById(""+prev_id).getAttribute("level");

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
        document.getElementById("sortable li").each(function() {
            
            // Lekérdezni az azonosítóját
            id = $(this).getAttribute("id")

            // Lekérdezni a szintjét
            level = $(this).getAttribute("level");

            // Lekérdezni a szülőjét
            parent_id = get_parent(id, level);

            // Objektum létrehozása
            obj = new Object();
            obj.id = id;
            obj.category_id = parent_id;

            // Objektum elhelyezése a tömbbe
            array.push(obj);
        });

        // JSON létrehozása a tömbből
        json = JSON.stringify(array);

        // Visszatérés ezzel a JSON-nal
        return json;
    }

    // Mentés gomb
    $("body").addEventListener("click", "#save", function() {

        // Kategória fa lekérdezése
        categories = get_tree();

        // AJAX kérés
        $.ajax({
            dataType: "json",
            url: "/admin/category/sequence/save",
            data: "categories="+categories+"&category_group_id="+category_group_id,
            type: "POST",
            cache: false,
            success: function (data) {
                if (data.OK == 1) {
                    alert("OK");
                } else {
                    alert("Hiba történt a művdelet során!");
                }
            },
            error: function (error) {
                alert("Hiba történt a művdelet során!");
            }
        });
    });


});