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
					<div>
						<span class="fw-bold text-uppercase">{{ item.user_name }}</span>
						<span class="float-end fw-bold">
							<span v-for="star in item.stars">&#9733;</span>
							<span v-for="star in 5-(item.stars)">&#9734;</span>
						</span>
					</div>
					<div>
						<span class="fw-bold">{{ item.title }}</span>
					</div>
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
import { onMounted } from 'vue'
import { getRating, ratings } from './rating'

// Exportálás
export default {

    // Beállítás
    setup() {

		// Amikor betöltődött az oldal
		onMounted(() => {
            getRating()
        });

        return {
			getRating,
			ratings
		}
    }
}
</script>