<template>
    <div id="container">
      <div class="amigos-lista">
        <div v-for="amigo in amigos" :key="amigo.id" @click="startChatWith(amigo.id, amigo.name)" class="amigo">
          <img :src="getProfilePhotoUrl(amigo.profile_photo)" alt="Imagen del perfil" width="100" height="100">
          <span class="amigo-nombre">{{ amigo.name }}</span>
        </div>
      </div>
      <div class="chat"></div>
    </div>
  </template>
  
  <script>
  import { socket } from "../../socket.js";
  
  export default {
    data() {
      return {
        amigos: [],
        clientId: null,
      };
    },
    mounted() {
      this.checkIfAuth();
      this.getAmigos(this.clientId);
      socket.emit('userJoined', this.clientId);
    },
    methods: {
      startChatWith(chattingWithId, chattingWithIdName) {
        const store = useStore();
        store.set_chattingWithId(chattingWithId);
        store.set_chattingWithIdName(chattingWithIdName);
        
        console.log('Guardando chattingWithId ' + chattingWithId + ' en store ' + store.return_chattingWithId());
        socket.emit('joinRoomWith', chattingWithId, this.clientId);
  
        this.$router.push(`/perfil/chat`);
      },
      checkIfAuth() {
        const store = useStore();
        this.clientId = store.return_user_id();
        store.set_return_path('/perfil/amigos');
        if (!this.clientId) {
          alert('Necesitas estar logueado para chatear con tus amigos');
          this.$router.push('/login');
        }
      },
      getProfilePhotoUrl(photoPath) {
        return `http://elysium.daw.inspedralbes.cat/backend/public/${photoPath}`;
      },
      getAmigos(id) {
        fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/amigos/${id}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Error fetching amigos');
            }
            return response.json();
          })
          .then(data => {
            this.amigos = data;
            if (data.length === 0) {
              alert('No tienes amigos');
            }
          })
          .catch(error => {
            console.error('Error fetching amigos:', error);
            alert('Error al obtener amigos');
          });
      }
    }
  }
  </script>
  
  <style scoped>
  #container {
    display: flex;
    flex-direction: column;
    height: 100vh;
  }
  
  .amigo {
    margin: 10px;
    padding: 10px;
    border: 1px solid black;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
  }
  </style>
  