<template>
    <div class="bg-primary text-light p-2 fw-bold">Képek</div>
	<div class="row p-2">
		<div class="col-sm-3 col-6" v-for="item in images">
			<div @click="openPopup(item.image)">
				<img :src="item.thumb" class="img-thumbnail"/>
			</div>
		</div>
	</div>
</template>
<script>
// Importálás
import { openPopup } from './popup';

// Exportálás
export default {
    
    // Változó definiálása
    props: ['images'],

    // Beállítás
    setup() {
        return {
            openPopup
        }
    }
}
</script>