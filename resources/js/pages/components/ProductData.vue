<template>
    <div class="bg-primary text-light p-2 fw-bold">Leírás</div>
    <div class="fw-bold">{{ product.summary }}</div>
    <div><span v-html="product.body"></span></div>
</template>
<script>
// Exportálás
export default {
    
    // Attribútum definiálása
    props: ['product']

}
</script>