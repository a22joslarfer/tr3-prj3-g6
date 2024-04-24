<template>
    <header class="profile-header">
        <button @click="goBack" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="back-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
        <h1 class="profile-title">{{ pageTitle }}</h1>
    </header>
</template>

<script>
export default {
    props: {
        pageTitle: {
            type: String,
            default: 'Ajustes'
        }
    },
    methods: {
        goBack() {
            // Aquí puedes agregar la lógica para ir hacia atrás
            this.$router.go(-1); // Esto es un ejemplo para volver a la página anterior, ajusta según necesites
        }
    }
}
</script>

<style scoped>
.profile-header {
    display: flex;
    align-items: center;
    padding: 12px;
    background-color: #ffffff;
    border-bottom: 1px solid #eaeaea;
    margin-bottom: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
}

.back-button {
    background: none;
    border: none;
    padding: 0;
    margin-right: 10px;
    cursor: pointer;
    display: grid;
    justify-content: start;
}

.back-icon {
    width: 24px;
    height: 24px;
    color: #333333;
}

.profile-title {
    font-size: 18px;
    margin: 0;
    color: #333333;
    text-align: center;
}
</style>