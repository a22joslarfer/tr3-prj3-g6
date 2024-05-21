<template>
  <div class="social-profile">
    <div class="header-icon">
      <button @click="llevarAgenerarCodigoQr()">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
          <path d="M80-680v-200h200v80H160v120H80Zm0 600v-200h80v120h120v80H80Zm600 0v-80h120v-120h80v200H680Zm120-600v-120H680v-80h200v200h-80ZM700-260h60v60h-60v-60Zm0-120h60v60h-60v-60Zm-60 60h60v60h-60v-60Zm-60 60h60v60h-60v-60Zm-60-60h60v60h-60v-60Zm120-120h60v60h-60v-60Zm-60 60h60v60h-60v-60Zm-60-60h60v60h-60v-60Zm240-320v240H520v-240h240ZM440-440v240H200v-240h240Zm0-320v240H200v-240h240Zm-60 500v-120H260v120h120Zm0-320v-120H260v120h120Zm320 0v-120H580v120h120Z"/>
        </svg>
      </button>
    </div>
    <div class="profile-header">
      <div class="profile-image">
        <div class="bordered-image">
          <img :src="profileImageUrl" alt="Profile Image">
        </div>
      </div>
      <div class="profile-info">
        <div v-if="user" class="user-username">
          <h3 class="username">{{ user }}</h3>
          <p class="bio">¡Bienvenido al mundo de las redes sociales! Conéctate, comparte y descubre.</p>
        </div>
      </div>
    </div>
    <div class="user-stats">
      <div class="stat">
        <span class="stat-label">Publicaciones</span>
        <span class="stat-value">10</span>
      </div>
      <div class="stat">
        <span class="stat-label">Seguidores</span>
        <span class="stat-value">{{ seguidores }}</span>
      </div>
      <div class="stat">
        <span class="stat-label">Siguiendo</span>
        <span class="stat-value">300</span>
      </div>
    </div>
    <div class="edit-profile">
      <button @click="editarPerfil()">Editar perfil</button>
    </div>
    <div class="amigos-lista" v-if="filteredAmigos.length > 0">
      <div class="amigos-lista-content">
        <div v-for="amigo in filteredAmigos" :key="amigo.id" @click="startChatWith(amigo.id, amigo.name)" class="amigo">
          <div class="amigo-avatar">
            <img :src="getProfilePhotoUrl(amigo.profile_photo)" alt="Imagen del perfil">
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-bar">
      <div class="selected-line" :style="{ left: barPosition }"></div>
      <div class="icon" @click="scrollTo('inicio')">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
          <path d="M480-260q75 0 127.5-52.5T660-440q0-75-52.5-127.5T480-620q-75 0-127.5 52.5T300-440q0 75 52.5 127.5T480-260Zm0-80q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM160-120q-33 0-56.5-23.5T80-200v-480q0-33 23.5-56.5T160-760h126l74-80h240l74 80h126q33 0 56.5 23.5T880-680v480q0 33-23.5 56.5T800-120H160Zm0-80h640v-480H638l-73-80H395l-73 80H160v480Zm320-240Z"/>
        </svg>
      </div>
      <div class="icon" @click="scrollTo('explorar')">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
          <path d="m160-800 80 160h120l-80-160h80l80 160h120l-80-160h80l80 160h120l-80-160h120q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800Zm0 240v320h640v-320H160Zm0 0v320-320Z"/>
        </svg>
      </div>
      <div class="icon" @click="scrollTo('notificaciones')">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
          <path d="m80-80 200-560 360 360L80-80Zm132-132 282-100-182-182-100 282Zm370-246-42-42 224-224q32-32 77-32t77 32l24 24-42 42-24-24q-14-14-35-14t-35 14L582-458ZM422-618l-42-42 24-24q14-14 14-34t-14-34l-26-26 42-42 26 26q32 32 32 76t-32 76l-24 24Zm80 80-42-42 144-144q14-14 14-35t-14-35l-64-64 42-42 64 64q32 32 32 77t-32 77L502-538Zm160 160-42-42 64-64q32-32 77-32t77 32l64 64-42 42-64-64q-14-14-35-14t-35 14l-64 64ZM212-212Z"/>
        </svg>
      </div>
    </div>
    <div class="content">
      <div v-if="selectedSection === 'inicio'">
        <div class="publications">
          <div class="publication">
            <div class="row" v-for="(imageRow, index) in imageRows" :key="index">
              <div class="column" v-for="(image, i) in imageRow" :key="i">
                <img :src="image.src" :alt="'Publicación ' + (index * 3 + i + 1)">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else-if="selectedSection === 'explorar'">
        <h2>Contenido de videos</h2>
      </div>
      <div v-else-if="selectedSection === 'notificaciones'">
        <h2>Contenido de nombres</h2>
      </div>
    </div>
  </div>
</template>
  <script>
import { useStore } from '../stores/index.js';

export default {
  data() {
    return {
      user: null,
      profileImageUrl: null,
      seguidores: 0,
      barPosition: '5%', // Posición inicial de la barra
      selectedSection: 'inicio', // Sección seleccionada inicialmente
      sections: {
        inicio: 5,
        explorar: 38,
        notificaciones: 70,
      },
      amigos: [], // Inicializamos amigos como un array vacío
      searchQuery: '', // Añadimos una propiedad para la búsqueda
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
    const store = useStore();
    const userInfo = store.return_user_info();
    this.user = userInfo.username;

    // Obtener la id del usuario
    const userId = userInfo.id;
    this.fetch();
    this.fetchAmigos();
  },
  
  methods: {

    async fetch() {
      try {
        const store = useStore();
        const id = store.return_user_id();

        // Fetch de la imagen de perfil
        const profilePhotoResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/profile_photo/${id}`);
        const profilePhotoData = await profilePhotoResponse.json();
        console.log(profilePhotoData);
        this.profileImageUrl = profilePhotoData; // Suponiendo que la respuesta contiene la URL de la imagen de perfil

        // Fetch del número de seguidores
        const followersResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/seguidores/${id}`);
        const followersData = await followersResponse.json();
        console.log(followersData);
        this.seguidores = followersData.seguidores; // Asigna el número de seguidores
      } catch (error) {
        console.error('Error al obtener los datos del usuario:', error);
      }
    },
    async fetchAmigos() {
      try {
        const store = useStore();
        const userId = store.return_user_id();
        
        const amigosResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/amigos/${userId}`);
        const amigosData = await amigosResponse.json();
        this.amigos = amigosData; // Asigna la lista de amigos
      } catch (error) {
        console.error('Error al obtener los amigos:', error);
      }
    },

    getProfilePhotoUrl(photoPath) {
      return `http://elysium.daw.inspedralbes.cat/backend/public/${photoPath}`;
    },
    
    scrollTo(section) {
      this.barPosition = this.sections[section] + '%';
      this.selectedSection = section;
    },
    
    llevarAgenerarCodigoQr() {
      this.$router.push('../generarQR');
    },
    
    editarPerfil() {
      this.$router.push('/PERFIL/ajustes');
    }
  }
}
</script>
  
  <style scoped>
  .instagram-stories {
    display: flex;
    overflow-x: auto;
    padding: 10px 0;
  }
  
  .story {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-right: 10px;
    position: relative;
    background-size: cover;
    background-position: center;
    border: 2px solid #ffc40000;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .story-username {
    position: absolute;
    bottom: -20px;
    width: 100%;
    text-align: center;
    font-size: 12px;
    color: #555;
  }
  
  .header-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
  }
  
  .bottom-bar {
    position: absolute;
    left: 0;
    width: 100%;
    height: 46px;
    background-color: #fff;
    display: flex;
    justify-content: space-around;
    align-items: center;
    border-top: 1px solid #ccc;
    z-index: 999;
  }
  
  .selected-line {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 25%;
    height: 4px;
    background-color: black;
    transition: left 0.3s ease;
  }
  
  .icon {
    cursor: pointer;
  }
  
  html,
  body {
    width: 100%;
    margin: 0;
    padding: 0;
  }
  
  /* Estilos del contenido dinámico */
  .content {
    margin-top: 20px;
    border-radius: 5px;
    width: 100%;
    /* Ajusta el ancho al 100% */
  }
  
  /* Estilos de las publicaciones */
  .publication {
    width: 100%;
    padding: 5px;
    margin-top: 25px;
  }
  
  .row {
    display: flex;
    justify-content: space-between;
  }
  
  .column {
    flex: 0 0 30%;
    /* Ajusta el ancho de la columna según tus necesidades */
  }
  
  .publication img {
    width: 100%;
    /* Hacer que las imágenes ocupen todo el ancho disponible */
    height: auto;
    /* Mantener la proporción original */
    border-radius: 5px;
  }
  
  /* Estilos del perfil */
  .social-profile {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-left: -10px;
    margin-right: -10px;
    margin-top: -15px;
  }
  
  .profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .bordered-image {
    position: relative;
    overflow: hidden;
    border-radius: 50%;
    animation: border-pulse 2s infinite alternate;
  }
  
  .bordered-image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
  }
  
  .profile-info {
    flex: 1;
  }
  
  .username {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
  }
  
  .bio {
    font-size: 14px;
    color: #777;
  }
  
  .user-stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    margin-top: -10px;
  }
  
  .stat {
    text-align: center;
  }
  
  .stat-label {
    font-size: 14px;
    color: #555;
  }
  
  .stat-value {
    font-size: 18px;
    font-weight: bold;
  }
  
  .edit-profile button {
    width: 400px;
    position: relative;
    left: -10px;
    align-items: center;
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
  }
  
  @keyframes border-pulse {
    0% {
      border: 2px solid #ffc400;
    }
  
    100% {
      border: 2px solid #555;
    }
  }
  
  /* Nuevos estilos para la lista de amigos */
  .amigos-lista-content {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  padding: 10px 0;
  overflow-y: hidden;
  scrollbar-width: none; /* Oculta la barra de desplazamiento en Firefox */
  -ms-overflow-style: none; /* Oculta la barra de desplazamiento en IE y Edge */
}
.amigos-lista-content::-webkit-scrollbar {
  width: 0;
  height: 0; /* Oculta la barra de desplazamiento en Webkit (Chrome, Safari) */
}

.amigo {
  display: flex;
  align-items: center;
  margin-right: 15px;
  flex-shrink: 0; /* Asegura que los elementos no se reduzcan */
}

.amigo-avatar img {
  width: 50px;
  height: 80px;
  border-radius: 17%;
}
  
  .amigo-info {
    margin-left: 10px;
    font-size: 14px;
  }
  
  .amigo-nombre {
    white-space: nowrap;
  }
  </style>