<template>
	<div class="bg-primary text-light p-2 fw-bold">Termék kosárba helyezése</div>
	<div class="row p-2">
		<div class="col-sm-3 fw-bold">Méret</div>
		<div class="col-sm-3 fw-bold">Mennyiség</div>
		<div class="col-sm-6"></div>
		<div class="col-sm-3">
			<select class="form-control" v-model="mycart.size_id">
				<option v-for="(item, index) in prices" :value="item.id">{{  index }}</option>
			</select>
		</div>
		<div class="col-sm-3">
			<select class="form-control" v-model="mycart.quantity">
				<option v-for="n in 10" :value="n">{{ n }}</option>
			</select>
		</div>
		<div class="col-sm-6">
			<button class="btn btn-primary w-100" @click="putCart()">Kosárba helyezés</button>
		</div>
		<div>
			<div class="alert alert-success m-2" role="alert" v-show="cartresult.success">
				Termék sikeresen a kosárba helyezve!
			</div>
			<div class="alert alert-danger m-2" role="alert" v-show="cartresult.error">
				<span v-html="cartresult.message"></span>
			</div>
		</div>
	</div>
</template>
<script>

// Importálás
import { request } from "../../helper_vue";
import { ref } from 'vue'
import router from '../../route'

// Exportálás
export default {
    
    // Attribútum definiálása
    props: ['prices'],

    // Beállítás
    setup() {
        
        // Változók definiálása
        let mycart = ref({});
        let cartresult = ref({
            button: true
        });

        // Termék kosárba helyezése
        const putCart = async () => {
            try {
                // Termék azonosító felvitele
                mycart.value.product_id = router.currentRoute.value.params.id;;
                
                // GET kérés küldése a szervernek
                const response = await request('put', '/api/cart/', mycart.value);
                
                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {
                    
                    // Mezők visszaállítása
                    mycart.value = {};
                    
                    // Eredmény mutatása
                    cartresult.value = { success: true };
                }
                else {

                    // Hiba mutatása
                    cartresult.value = { error: true, message: "Hiba történt a művelet során!" };
                }
            }
            catch (error) {

                // Hibák lekérdezése
                let errors = error.response.data.errors;

                // Hibaszöveg létrehozása ezen hibákból
                let errorMessage = Object.values(errors).join("<br>");
                
                // Hiba mutatása
                cartresult.value = { error: true, message: errorMessage };
                
            }

            // 3 másodperc múlva az eredmény elrejtése
            setTimeout(function () {
                cartresult.value = {};
            }, 3000);
        };

        // Visszatérés
        return {
            putCart,
            mycart,
            cartresult
        }
    }
}
</script>