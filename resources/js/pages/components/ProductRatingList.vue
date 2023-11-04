<template>
    <div class="bg-primary text-light p-2 fw-bold">
		Értékelések ({{  ratings.total }} db)
		<span v-if="ratings.items.length>0" class="float-end fw-bold">
			<span v-for="star in ratings.stars">&#9733;</span>
			<span v-for="star in 5-(ratings.stars)">&#9734;</span>
		</span>
	</div>
	<div v-if="ratings.items.length == 0" class="alert alert-warning mt-2" role="alert">
		Még senki nem értékelte a terméket!
	</div>    
	<table v-else class="table table-hover">
		<tbody>
			<tr v-for="item in ratings.items">
				<td :style="{ 
					color: item.moderated == 0 ? 'red' : 'black',
					fontStyle: item.moderated == 0 ? 'italic' : 'normal' 
				}">
					<span class="fw-bold">{{ item.title }}</span>
					<span class="float-end fw-bold">
						<span v-for="star in item.stars">&#9733;</span>
						<span v-for="star in 5-(item.stars)">&#9734;</span>
					</span>
					<div>
						<span v-html="item.body"></span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>

// Importálás
import {ref, onMounted} from 'vue'
import {request} from '../../helper_vue'
import router from '../../route'

// Exportálás
export default {
    
    // Változó definiálása
    props: ['ratings'],

    // Beállítás
    setup(props) {

		// Definiálás
		let product_id = router.currentRoute.value.params.id;
		let response = ref(null);
		let ratings = ref({
            items: {},
            total: null,
            stars: null
        });

		// Amikor betöltődött az oldal
		onMounted(() => {
            getRating();
        });

		// Értékelések lekérdezése
		const getRating = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/rating/' + product_id);
                // Adatok lekérdezése és megjelenítése
                ratings.value = response.data;
            }
            catch (error) {
                console.log(error);
            }
        };

        return {
			getRating,
			ratings
        }
    }
}
</script>