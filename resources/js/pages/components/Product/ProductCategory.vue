<template>    
    <div class="bg-primary text-light p-2 fw-bold">Jellemzők</div>
    <table class="table table-hover">
        <tbody>
            <tr v-for="item in categories">
                <td class="fw-bold w-50">{{ item.key }}</td>
                <td>{{ item.value }}</td>
            </tr>
        </tbody>
    </table>
</template>
<script>
// Exportálás
export default {
    
    // Attribútum definiálása
    props: ['categories']

}
</script>