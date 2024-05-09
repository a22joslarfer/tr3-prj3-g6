<template>
    <div>
        <img :src="profileImageUrl" alt="Profile Image">
    </div>
</template>

<script>
import { useStore } from '../stores/index.js';
export default {
    data() {
        return {
            profileImageUrl: null
        }
    },
    methods: {
        
        async fetch() {
            const store = useStore();
            const  id = store.return_user_id();
            
            const response = await fetch(`http://localhost:8000/api/users/profile_photo/${id}`);
            const data = await response.json();
            console.log(data);
            

            this.profileImageUrl = data; // Suponiendo que la respuesta contiene la URL de la imagen de perfil
        },
       
    },
    created() {
        this.fetch();
    }


}
</script>
<style scoped>
/* Estilos para la imagen de perfil */
img {
    width: 100px;
    height: 100px;
}
</style>