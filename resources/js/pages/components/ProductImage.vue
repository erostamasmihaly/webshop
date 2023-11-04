<template>
    <div class="bg-primary text-light p-2 fw-bold">Képek</div>
	<div class="row p-2">
		<div class="col-sm-3 col-6" v-for="item in images">
			<div @click="openPopup(item.image)">
				<img :src="item.thumb" class="img-thumbnail"/>
			</div>
		</div>
	</div>
	<div id="popup_background" v-show="popup.show">
		<div id="popup" class="text-center">
			<div id="popup_close" @click="closePopup()">X</div>
			<img :src="popup.image" class="img-fluid mh-100"/>
		</div>
	</div>
</template>
<script>
// Importálás
import { ref } from 'vue'

// Exportálás
export default {
    
    // Változó definiálása
    props: ['images'],

    // Beállítás
    setup(props) {

        // Definiálás
        let popup = ref({});

        // Felugró ablak megnyitása
        const openPopup = async (src) => {
            popup.value = { show: true, image: src };
        };

        // Felugró ablak bezárása
        const closePopup = async () => {
            popup.value = {};
        };

        return {
            openPopup,
            closePopup,
            popup
        }
    }
}
</script>