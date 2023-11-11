<template>
    <div id="popup_background" v-show="show">
		<div id="popup" class="text-center">
			<div id="popup_close" @click="closePopup()">X</div>
			<img :src="image" class="img-fluid mh-100"/>
		</div>
	</div>
</template>
<script>
// Importálás
import { popup, closePopup } from './popup'; 

// Exportálás
export default {
    
    // Változó definiálása
    props: ['show','image'],

    // Beállítás
    setup() {

        return {
            closePopup,
            popup
        }
    }
}
</script>