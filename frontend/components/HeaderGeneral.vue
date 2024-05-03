<template>
  <div>
    <header class="header">
      <div class="container">
        <div class="logo">
          <!-- Aquí puedes colocar tu logo -->
          <img src="../public/img/copas.png" alt="Logo">
        </div>
        <div class="name">
          <h2>VIAEGIS</h2>
        </div>
        <div class="menu-activador">
          <input type="checkbox" id="lanzador" @click="toggleMenu" />
          <label for="lanzador">
            <span class="menu-activador-linea"></span>
            <span class="menu-activador-linea"></span>
            <span class="menu-activador-linea"></span>
          </label>
        </div>
      </div>
    </header>
    <div class="menu-desplegable" :class="{ 'activo': isMenuOpen }">
      <!-- Contenido del menú desplegable -->
      <div class="settings">
        <HeaderPerfil />
        <div class="buscador"> 
          <input type="search" name="" id="" placeholder="Busca aquí...">
        </div>
        <ul>
          <li v-for="option in options" :key="option.id" @click="navigateTo(option.route)">
            {{ option.name }}
            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20">
              <path d="M559-480 371.5-667.5l13-13.5 201 201-201 201-13-13.5L559-480Z"/>
            </svg>
          </li>
        </ul>
        <FooterOptions />
      </div>
    </div>
  </div>
</template>

<script>
import HeaderPerfil from './HeaderPerfil.vue'; // Ajusta la ruta según la ubicación de tu archivo HeaderPerfil.vue
import FooterOptions from './FooterOptions.vue'; // Ajusta la ruta según la ubicación de tu archivo FooterOptions.vue

export default {
  name: 'Header',
  components: {
    HeaderPerfil,
    FooterOptions,
  },
  data() {
    return {
      isMenuOpen: false,
      options: [
        { id: 1, name: 'Cambiar datos', route: '/PERFIL/ajustes' },
        { id: 2, name: 'Amigos', route: '/PERFIL/amigos' },
        { id: 3, name: 'Chats', route: '/PERFIL/chats' },
        { id: 4, name: 'Notificaciones', route: '/PERFIL/notificaciones' },
        { id: 5, name: 'Login', route: '/Login' },
        { id: 6, name: 'Register', route: '/Register' },
        { id: 7, name: 'Cerrar sesión', route: '/PERFIL/logout' },
      ],
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    navigateTo(route) {
      this.$router.push(route);
    },
  },
};
</script>

<style scoped>
body, html {
  height: 100%; /* Asegura que el cuerpo y el HTML ocupen toda la altura */
  margin: 0;
}

/* Estilos para el header */
.header {
  background-color: #ffffff;
  color: #000;
  padding: 15px 0;
  margin-left: 1px;
  width: 100%;
  top: 0; /* Posicionarlo en la parte superior */
  z-index: 10001; /* Asegurarse de que esté por encima del resto del contenido */
  justify-content: center; /* Centrar horizontalmente */
  align-items: center; /* Centrar verticalmente */
  margin-top: -17px;
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  height: 70px;
  width: 100%;
  max-width: 1200px; /* Ancho máximo del contenedor */
  padding: 0 20px; /* Espaciado interno */
}

.name h2 {
  margin: 0; /* Eliminar el margen */
  font-size: 60px; /* Aumentar el tamaño de la fuente */
  font-weight: bold; /* Añadir negrita */
  color: #333; /* Cambiar el color del texto */
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Añadir sombra al texto */
  letter-spacing: 2px; /* Añadir espaciado entre letras */
  text-transform: uppercase; /* Convertir a mayúsculas */
}

.logo img {
  height: 60px;
}

.menu-activador {
  width: 30px;
  height: 20px;
  margin-left: 20px; /* Ajuste en el margen izquierdo */
}

#lanzador {
  position: absolute;
  left: -9999px;
}

label {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
  cursor: pointer;
}

.menu-activador-linea {
  height: 3px;
  width: 100%;
  background-color: #000;
  opacity: 1;
  transform: translateY(0) rotate(0);
  transition: all 0.3s;
  margin: 2px 0;
}

#lanzador:checked ~ label .menu-activador-linea {
  &:nth-child(1) {
    transform: translateY(8px) rotate(45deg);
  }
  &:nth-child(2) {
    opacity: 0;
  }
  &:nth-child(3) {
    transform: translateY(-8px) rotate(-45deg);
  }
}

/* Estilos del menú desplegable */
.menu-desplegable {
  position: fixed; /* Fijar el menú desplegable */
  top: 10px; /* Altura del header */
  left: 0;
  width: 100%;
  height: calc(100% - 70px); /* Restar el alto del header */
  background-color: #ffffff;
  z-index: 1999; /* Un valor alto para asegurar que esté por encima del resto del contenido */
  visibility: hidden; /* Oculto por defecto */
  opacity: 0;
  transition: opacity 0.3s, visibility 0.3s;
  overflow-y: auto; /* Añadir scroll si el contenido es largo */
}

.menu-desplegable.activo {
  visibility: visible; /* Visible cuando está activo */
  opacity: 1;
}

.menu-desplegable ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.menu-desplegable ul li {
  cursor: pointer;
  padding: 10px 0;
  border-bottom: 1px solid #ccc;
  margin-top: 20px;
}

.menu-desplegable ul li a {
  text-decoration: none;
  color: #000;
  font-size: 18px;
}
.mapboxgl-ctrl-geocoder {
  position: absolute;
  top: 10px; /* Ajusta la posición vertical según lo necesites */
  left: 10px; /* Ajusta la posición horizontal según lo necesites */
  z-index: 998; /* Asegurarse de que esté por debajo del menú desplegable */
  display: none; /* Ocultar por defecto */
}
.menu-desplegable ul li:hover {
  background-color: #f0f0f0;
}
.settings {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}
.menu-activador {
  display: block;
  cursor: pointer;
  position: relative;
  z-index: 2000; /* Asegura que esté por encima de otros elementos */
}
input {
  background-image: url('../public/img/search_FILL1_wght100_GRAD-25_opsz20.svg');
  width: calc(100% - 30px);
  padding: 10px 40px 10px 10px;
  margin-top: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  color: #222222;
  background-repeat: no-repeat;
  background-position: left 10px center;
  background-size: 20px;
}

input::placeholder {
  color: #ccc;
  font-size: 16px;
  position: relative;
  left: 10%;
}

input:focus {
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
  margin-top: 20px;
}

li:hover {
  background-color: #f0f0f0;
}

svg {
  float: right;
}
</style>
