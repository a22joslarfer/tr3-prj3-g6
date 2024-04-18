<template>
    <div class="settings">
        <HeaderPerfil />
        <div class="buscador"> <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
          <path
            d="M783.522-110.913 529.848-364.587q-29.761 23.044-68.642 36.565-38.88 13.522-83.119 13.522-111.152 0-188.326-77.174Q112.587-468.848 112.587-580q0-111.152 77.174-188.326Q266.935-845.5 378.087-845.5q111.152 0 188.326 77.174Q643.587-691.152 643.587-580q0 44.478-13.522 83.12-13.521 38.641-36.565 68.163l253.913 254.152-63.891 63.652ZM378.087-405.5q72.848 0 123.674-50.826Q552.587-507.152 552.587-580q0-72.848-50.826-123.674Q450.935-754.5 378.087-754.5q-72.848 0-123.674 50.826Q203.587-652.848 203.587-580q0 72.848 50.826 123.674Q305.239-405.5 378.087-405.5Z" />
        </svg>
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
input {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    color: #222222;
}
input::placeholder{
    color: #ccc;
    font-size: 16px;
    
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