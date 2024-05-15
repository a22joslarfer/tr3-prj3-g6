<template>
    <div id="container">
      <h1 class="titulo">¡Tus Amigos!</h1>
      <input type="text" v-model="searchQuery" @input="searchFriends" placeholder="Buscar amigos por nombre" class="search-input">
      <div v-if="loading" class="loading-indicator">Cargando...</div>
      <div v-else-if="amigos.length === 0" class="no-amigos">No tienes amigos</div>
      <div v-else class="amigos-lista">
        <div v-for="amigo in filteredAmigos" :key="amigo.id" @click="startChatWith(amigo.id, amigo.name)" class="amigo">
          <div class="amigo-content">
            <div class="amigo-avatar">
              <img :src="getProfilePhotoUrl(amigo.profile_photo)" alt="Imagen del perfil">
            </div>
            <div class="amigo-info">
              <span class="amigo-nombre">{{ amigo.name }}</span>
            </div>
          </div>
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
        searchQuery: '',
        loading: false
      };
    },
    computed: {
      filteredAmigos() {
        return this.amigos.filter(amigo => amigo.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
      }
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
        this.loading = true;
        fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/amigos/${id}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Error fetching amigos');
            }
            return response.json();
          })
          .then(data => {
            this.amigos = data;
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching amigos:', error);
            this.loading = false;
            alert('Error al obtener amigos');
          });
      },
      searchFriends() {
        // Lógica de búsqueda de amigos por nombre
        // Si necesitas ayuda con esto, puedo añadir la lógica aquí
      }
    }
  }
  </script>
  
  <style scoped>
  #container {
    text-align: center;
  }
  
  .titulo {
    font-size: 36px;
    margin-bottom: 30px;
    color: #075e54; /* Color verde de WhatsApp */
  }
  
  .search-input {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 25px; /* Forma redondeada */
    width: 80%;
    font-size: 16px;
  }
  
  .loading-indicator, .no-amigos {
    font-size: 18px;
    margin-top: 20px;
    color: #666;
  }
  
  .no-amigos {
    font-size: 24px;
  }
  
  .amigos-lista {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .amigo {
    margin: 20px;
    border-radius: 25px; /* Forma redondeada */
    background-color: #f0f0f0; /* Color de fondo similar al de WhatsApp */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    cursor: pointer;
    width: 290px;
  }
  
  .amigo:hover {
    transform: translateY(-5px);
  }
  
  .amigo-content {
    display: flex;
    align-items: center;
  }
  
  .amigo-avatar {
    width: 100px;
    height: 100px;
    overflow: hidden;
    border-radius: 50%;
  }
  
  .amigo-avatar img {
    position:relative;
    top:20px;
    width: 60%;
    height: 60%;
    object-fit: cover;
    border-radius: 50%;
  }
  
  .amigo-info {
    margin-left: 20px; /* Espacio entre la imagen y el nombre */
  }
  
  .amigo-nombre {
    font-size: 18px;
    color: #333;
  }
  </style>
  