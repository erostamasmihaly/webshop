<template>
    <div id="popup_background" class="position-fixed top-0 bottom-0 start-0 end-0 bg-secondary bg-opacity-50" v-show="show">
		<div id="popup" class="position-fixed top-0 bottom-0 start-0 end-0 m-3">
            <div class="position-fixed top-0 bottom-0 start-0 end-0 m-3 bg-white">
                <img :src="image" class="img-fluid mh-100 mw-100 mx-auto d-block"/>
            </div>
            <div id="popup_close" class="position-absolute top-0 end-0 m-2">
                <button class="btn btn-primary" @click="closePopup()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="position-absolute bottom-0 start-0 m-2">
                <button class="btn btn-primary" @click="prevImage()">
                    <i class="fa-solid fa-square-caret-left"></i>
                </button>
            </div>
            <div v-if="popup.owner == 1" class="position-absolute bottom-0 start-50 m-2 translate-middle-x">
                <button class="btn btn-primary" @click="deleteImage(popup.id)">
                    Kép törlése
                </button>
            </div>
            <div class="position-absolute bottom-0 end-0 m-2">
                <button class="btn btn-primary" @click="nextImage()">
                    <i class="fa-solid fa-square-caret-right"></i>
                </button>
            </div>
		</div>
	</div>
</template>
<script>
// Importálás
import { popup, closePopup, prevImage, nextImage } from './popup'; 
import { request } from "../../helper_vue";
import { getRating } from './rating';

// Exportálás
export default {
    
    // Attribútumok definiálása
    props: ['show','image'],

    // Beállítás
    setup() {

        // Értékeléshez tartozó kép törlése
        const deleteImage = async (id) => {

            // Megkérdezni a felhasználót, hogy akarja-e a képet törölni
            let user_confirm = confirm("Biztosan törölni szeretné a fényképet?");

            // Ha igen
            if (user_confirm) {
                
                try {
                
                    // DELETE kérés küldése a szervernek
                    const response = await request('delete', '/api/rating/image/'+id);

                    // Ha minden rendben volt
                    if (response.data.OK == 1) {

                        // Popup bezárása
                        closePopup();

                        // Értékelések újbóli lekérdezése
                        getRating();
                    }

                } catch (error) {
                    console.log(error);
                }
            }
        }

        // Visszatérés
        return {
            closePopup,
            prevImage,
            nextImage,
            deleteImage,
            popup
        }
    }
}
</script>