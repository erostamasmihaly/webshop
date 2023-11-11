<template>
    <div class="col-sm-2 text-center" @click="openProduct(item.id)">
        <p class="fw-bold">{{ item.name }}</p>
        <img :src="item.image" class="img-thumbnail"/>
        <p>
            {{ item.discount_price }}<br>
            <button class="btn btn-primary">Megtekintés</button>
        </p>
    </div>
</template>
<script>
// Importálás
import router from '../../route'

// Exportálás
export default {
    // Változó definiálása
    props: ['item'],

    // Beállítás
    setup() {
        
        // Termék oldal megnyitása
        const openProduct = async(id) => {
            router.push('/vue/product/'+id);
        }

        // Visszatérés
        return {
            openProduct
        }
    }
}
</script>