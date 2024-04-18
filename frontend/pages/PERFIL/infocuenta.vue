<template>
    <div class="container">
        <HeaderPerfil />

        <h1 class="title">Configuración de Perfil</h1>
        <form @submit.prevent="submitForm" class="form">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" v-model="username" class="input">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" v-model="email" class="input">

            <button type="submit" class="button">Guardar cambios</button>
        </form>
        <FooterOptions />

    </div>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            email: ''
            // Agrega más datos de configuración según sea necesario
        }
    },
    methods: {
        submitForm() {
            // Aquí puedes agregar la lógica para enviar los datos del formulario al servidor
            console.log('Datos del formulario:', this.username, this.email);
            alert('Cambios guardados exitosamente');
        }
    }
}
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.title {
    font-size: 24px;
    margin-bottom: 20px;
}

.form {
    display: flex;
    flex-direction: column;
}

.input {
    margin-bottom: 10px;
    padding: 10px;
    font-size: 16px;
}

.button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3;
}
</style>