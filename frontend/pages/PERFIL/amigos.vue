<template>
    <div id="container">
      <div class="amigos-lista">
        <div v-for="amigo in amigos" :key="amigo.id" @click="startChatWith(amigo.id, amigo.name,amigo.profile_photo)" class="amigo">
          <img :src="amigo.profile_photo" class="amigo-foto" alt="Foto de perfil">
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
  height: 100vh;
}

.amigos-lista {
  flex: 1;
  overflow-y: auto;
}

.amigo {
  display: flex;
  align-items: center;
  padding: 10px;
  cursor: pointer;
}

.amigo-foto {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

.amigo-nombre {
  font-size: 16px;
}

.chat {
  flex: 1;
}
</style>
  