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
import { getImages } from './rating';

// Exportálás
export default {

    // Változó definiálása
    props: ['id'],

    // Beállítás
    setup(props) {

        let images = ref([]);

        // Amikor betöltődött az oldal
        onMounted(async () => {
            images.value = await getImages(props.id);
        });

        return {
            getImages, 
            images
        }
    }
}
</script>