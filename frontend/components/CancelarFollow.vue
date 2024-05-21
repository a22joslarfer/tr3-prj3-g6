<template>

    <UButton  class="follow-btn" @click="cancelarFollow()">Cancelar</UButton >
        

</template>

<script>
export default {

    methods: {
        cancelarFollow() {
            navigateTo('/');
        },
    }
}
</script>

<style scoped>
.follow-btn {
    background-color: #e22108;
    color: #fff;
    border: none;
    padding: 12px 24px; /* Se ajusta el padding */
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    font-weight: 600;
    border-radius: 8px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.follow-btn:hover {
    background-color: #7e0303;
}
</style>