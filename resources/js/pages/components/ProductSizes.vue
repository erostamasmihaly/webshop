<template>
    <div class="bg-primary text-light p-2 fw-bold">Méretek és árak</div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Méret</th>
                <th scope="col">Mennyiség</th>
                <th scope="col">Egységár</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in prices">
                <td>{{ index }}</td>
                <td>{{ item.quantity }} {{ unit }}</td>
                <td>{{ item.discount_ft }}</td>
            </tr>
        </tbody>
    </table>
</template>
<script>
// Exportálás
export default {
    
    // Változó definiálása
    props: ['prices','unit'],

    // Beállítás
    setup(props) {
        return {
        }
    }
}
</script>