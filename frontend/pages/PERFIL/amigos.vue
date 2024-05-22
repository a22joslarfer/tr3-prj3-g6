<template>
  <div id="container">
      <h1 class="titulo">¡Tus Amigos!</h1>
      <div class="search-and-sort">
      <div class="search-container">
        <input type="text" v-model="searchQuery" @input="searchFriends" placeholder="Buscar amigos por nombre" class="search-input">
        <button @click="sortByName" class="sort-button">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M320-280q17 0 28.5-11.5T360-320q0-17-11.5-28.5T320-360q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm120 320h240v-80H440v80Zm0-160h240v-80H440v80Zm0-160h240v-80H440v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/>
          </svg>
        </button>
      </div>
    </div>
      <div class="scrollable-content">
        <transition-group name="fade">
          <div v-if="loading" key="loading" class="loading-indicator">Cargando...</div>
          <div v-else-if="amigos.length === 0" key="no-amigos" class="no-amigos">¡No tienes amigos!</div>
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
      </transition-group>
      </div>
      <div class="chat"></div>
      <FooterOptions />
    </div>
  </template>
  
  <script>
  import { socket } from "../../socket.js";
  
  export default {
    data() {
      return {
        amigos: [],
        searchQuery: "",
        loading: false
      };
    },
    computed: {
      filteredAmigos() {
        return this.amigos.filter(amigo =>
          amigo.name.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
    },
    mounted() {
      this.checkIfAuth();
      this.getAmigos(this.clientId);
      socket.emit("userJoined", this.clientId);
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
      },
      sortByName() {
        this.amigos.sort((a, b) => {
          const nameA = a.name.toLowerCase();
          const nameB = b.name.toLowerCase();
          return nameA.localeCompare(nameB);
        });
      },
    }
  }
  </script>
  
  <style scoped>
  #container {
    margin-top:30px;
    text-align: center;
    padding-left: 20px;
    padding-right: 20px;
  }
  
  .titulo {
    font-size: 36px;
    margin-bottom: 20px;
    color: #075e54; /* Color verde de WhatsApp */
  }
  
  .search-input {
    margin-right: 30px;
    margin-bottom: 15px;
    padding: 10px 15px;
    border: 2px solid #ccc;
    border-radius: 40px; /* Forma redondeada */
    width: 80%;
    font-size: 16px;
    color: #666;
    transition: border-color 0.3s ease;
  }
  
  .search-input::placeholder {
    color: #999; /* Color de placeholder */
  }
  
  .search-input:focus {
    border-color: #075e54; /* Color verde de WhatsApp al enfocar */
  }
  
  .loading-indicator,
  .no-amigos {
    font-size: 18px;
    margin-top: 20px;
    color: #666; /* Color de texto suave */
    transition: opacity 0.3s ease;
  }
  
  .no-amigos {
    font-size: 24px;
    color: #333; /* Color de texto más oscuro */
  }
  
  .amigos-lista {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    transition: opacity 0.3s ease;
    margin-top:22px;
  }
  
  .amigo {
    
    border-radius: 20px; /* Forma redondeada */
    background-color: #fff; /* Color de fondo blanco */
    box-shadow: 0 4px 8px #075e548f;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
    width: calc(50% - 20px); /* Dos columnas en dispositivos móviles */
    max-width: 200px; /* Máximo ancho de cada tarjeta */
    height: auto;
    margin-bottom: 20px;
  }
  
  .amigo:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }
  
  .amigo-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
  }
  
  .amigo-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
  }
  
  .amigo-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .amigo-info {
    margin-top: 10px;
  }
  
  .amigo-nombre {
    font-size: 18px;
    color: #333; /* Color de texto más oscuro */
  }
  
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
  }
  
  .sort-button {
    margin-left: -20px;
    top:100px;
    position:absolute;
    background: none;
    border: none;
    cursor: pointer;
  }
  
  .sort-button svg {
    height: 38px;
    width: 54px;
    fill: #5f6368;
  }
  .scrollable-content {
    max-height: calc(100vh - 250px); /* Ajusta la altura máxima según tus necesidades */
    overflow-y: auto; /* Habilita la barra de desplazamiento vertical si es necesario */
  }
  </style>
  