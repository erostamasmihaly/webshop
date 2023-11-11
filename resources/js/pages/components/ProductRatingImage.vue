<template>
    <div v-if="images!=null">
		<div class="row p-2">
			<div class="col-sm-3 col-6" v-for="image in images">
				<div @click="openPopup(image.image)">
					<img :src="image.thumb" class="img-thumbnail"/>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
// Importálás
import { onMounted, ref } from 'vue'
import { request } from "../../helper_vue";
import { openPopup } from './popup';

// Exportálás
export default {

    // Változó definiálása
    props: ['id'],

    // Beállítás
    setup(props) {

        let images = ref([]);
        let response = ref(null);

        // Értékelések lekérdezése
        const getImages = async (id) => {
            
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/rating/' + id + '/images');
                        
                // Adatok lekérdezése és megjelenítése
                images.value = response.data;
            }
            catch (error) {
                console.log(error);
            }
        }

        // Amikor betöltődött az oldal
        onMounted(async () => {
            getImages(props.id);
        });

        return {
            getImages, 
            openPopup,
            images
        }
    }
}
</script>