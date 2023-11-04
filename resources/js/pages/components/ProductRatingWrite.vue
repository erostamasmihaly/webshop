<template>
	<div v-if="is_buyed">
		<div class="bg-primary text-light p-2 fw-bold">Értékelés írása</div>
		<div class="row m-1">
			<div class="col-sm-2 fw-bold">Cím</div>
			<div class="col-sm-10">
				<input class="form-control" type="text" v-model="myrating.title"/>
			</div>
		</div>
		<div class="row m-1">
			<div class="col-sm-2 fw-bold">Leírás</div>
			<div class="col-sm-10">
				<textarea class="form-control" v-model="myrating.body"/>
			</div>
		</div>
		<div class="row m-1">
			<div class="col-sm-2 fw-bold">Csillag</div>
			<div class="col-sm-10">
				<select class="form-control" v-model="myrating.stars">
					<option v-for="num in 5" :value="num">{{ num }}</option>
				</select>
			</div>
		</div>
		<div>
			<button class="btn btn-primary" type="button" @click="putRating()" v-show="ratingresult.button">Értékelés elküldése</button>
			<div class="alert alert-success" role="alert" v-show="ratingresult.success">
				Értékelés sikeresen elküldve. Jelenleg moderálás alatt!
			</div>
			<div class="alert alert-danger" role="alert" v-show="ratingresult.error">
				Hiba történt az értékelés elküldése során!
			</div>
		</div>
	</div>
</template>
<script>
// Importálás
import {ref} from 'vue'
import router from '../../route'
import {request} from '../../helper_vue'

// Exportálás
export default {
    
    // Változó definiálása
    props: ['is_buyed'],

    // Beállítás
    setup(props) {
        let myrating = ref({
            stars: 5
        });
        let ratingresult = ref({
            button: true
        });
        let product_id = router.currentRoute.value.params.id;

        // Értékelés elküldése
        const putRating = async () => {
            try {
                // Termékazonosító megadása
                myrating.value.product_id = product_id;
                // Kérés küldése a szerver felé
                const response = await request('put', '/api/rating', myrating.value);
                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {
                    // Értékelések újratöltése
                    getRating();
                    // Mezők visszaállítása
                    myrating.value = { stars: 5 };
                    // Eredmény mutatása
                    ratingresult.value = { success: true };
                }
                else {
                    // Hiba mutatása
                    ratingresult.value = { error: true };
                }
                // 3 másodperc múlva az eredmény elrejtése
                setTimeout(function () {
                    ratingresult.value = { button: true };
                }, 3000);
            }
            catch (error) {
                console.log(error);
            }
        };

        return {
            putRating,
            myrating,
            ratingresult
        }
    }
}
</script>