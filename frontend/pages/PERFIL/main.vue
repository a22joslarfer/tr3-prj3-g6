<template>
    <div class="settings">
        <HeaderPerfil />
        <div class="buscador"> 
        <input type="search" name="" id="" placeholder="Busca aquí...">
    </div>
        <ul>
            <li v-for="option in options" :key="option.id" @click="navigateTo(option.route)">
                {{ option.name }}<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M559-480 371.5-667.5l13-13.5 201 201-201 201-13-13.5L559-480Z"/></svg>

            </li>
        </ul>
        <FooterOptions />
    </div>
</template>

<script>
export default {
    data() {
        return {
            options: [
                { id: 1, name: 'Cambiar datos', route: '/PERFIL/ajustes' },
                { id: 2, name: 'Amigos', route: '/PERFIL/amigos' },
                { id: 3, name: 'Chats', route: '/PERFIL/chats' },
                { id: 4, name: 'Notificaciones', route: '/PERFIL/notificaciones' },
                { id: 5, name: 'Privacidad', route: '/PERFIL/privacidad' },
                { id: 6, name: 'Seguridad', route: '/PERFIL/seguridad' },
                { id: 7, name: 'Cerrar sesión' , route: '/PERFIL/logout', },

            ]
        }
    },
    methods: {
        navigateTo(route) {
            this.$router.push(route);
        }
    }
}
</script>

<style scoped>
.settings {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}
input{
    background-image: url('../../public/search_FILL1_wght100_GRAD-25_opsz20.svg');
    width: calc(100% - 30px); /* Ajusta el ancho del input para que quepa el ícono */
    padding: 10px 40px 10px 10px; /* Ajusta el padding derecho para dejar espacio al ícono */
    margin-top: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    color: #222222;
    background-repeat: no-repeat;
    background-position: left 10px center;
    background-size: 20px;
}
input::placeholder{
    color: #ccc;
    font-size: 16px;
    position: relative;
    left: 10%;
}
input:focus{
    outline: none;
}
ul {
    list-style-type: none;
    padding: 0;
}

li {
    cursor: pointer;
    padding: 10px 0;
    border-bottom: 1px solid #ccc;
    margin-top:20px;
}

li:hover {
    background-color: #f0f0f0;
}
svg {
    float: right;

}
</style>