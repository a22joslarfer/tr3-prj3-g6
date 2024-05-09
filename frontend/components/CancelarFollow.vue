<template>

    <button class="follow-btn" @click="cancelarFollow()">Cancelar</button>

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
    background-color: #ccc;
    color: #1c1c1c;
    height: 10vh;
    font-size: 4rem;
    width: 100vw;
    cursor: pointer;
    transition: background-color 0.3s;
    border: none;
}

.follow-btn:hover {
    background-color: #bd2d17;
}
</style>