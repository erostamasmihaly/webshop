<template>
    <div class="row p-2">
        <div class="col-sm-2">
            <div class="fw-bold">Bolt</div>
            <select class="form-control" @change="onChange('shop',$event)">
                <option value="0">Összes</option>
                <option :value="item.id" v-for="item in filters.shops">{{ item.name }}</option>
            </select>
        </div>
        <div class="col-sm-2">
            <div class="fw-bold">Méret</div>
            <select class="form-control" @change="onChange('size',$event)">
                <option value="0">Összes</option>
                <option :value="item.id" v-for="item in filters.sizes">{{ item.name }}</option>
            </select>
        </div>
        <div class="col-sm-2">
            <div class="fw-bold">Nem</div>
            <select class="form-control" @change="onChange('gender',$event)">
                <option value="0">Összes</option>
                <option :value="item.id" v-for="item in filters.genders">{{ item.name }}</option>
            </select>
        </div>
        <div class="col-sm-2">
            <div class="fw-bold">Korosztály</div>
            <select class="form-control"  @change="onChange('age',$event)">
                <option value="0">Összes</option>
                <option :value="item.id" v-for="item in filters.ages">{{ item.name }}</option>
            </select>
        </div>
    </div>
</template>
<script>
// Importálás
import { request } from '../../../helper_vue'
import { ref, onMounted } from 'vue'
import { selected, showList } from './list'

// Exportálás
export default {

    // Beállítás
    setup() {

        // Definiálás
        let response = ref(null);
        let filters = ref({
            shop: {},
            age: {},
            gender: {},
            size: {},
        });

        // Amikor betöltődött az oldal
        onMounted(() => {
            getCategories();
        });

        // Termékek listájának lekérdezése
        const getCategories = async () => {

            try {
                
                // GET kérés küldése a szervernek
                response = await request('get', '/api/categories');

                // Szűrők megjelenítése
                filters.value = response.data;

            } catch (error) {
                console.log(error);
            }
        }

        // Módosítás során
        const onChange = (category, event) => {

            // Kiválasztott érték lekérdezése
            let value = parseInt(event.target.value);

            // Ezen érték beállítása az aktuális szűrőhöz
            selected[category] = value;

            // Lista frissítése
            showList();
        }

        // Visszatérés
        return {
            filters,
            onChange
        }
    }

}
</script>