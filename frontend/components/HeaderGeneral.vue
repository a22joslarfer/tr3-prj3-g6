<template>
  <div>
    <header class="header">
      <div class="container">
        <div class="logo">
          <!-- Aquí puedes colocar tu logo -->
          <img src="../public/copas.png" alt="Logo">
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
      <ul>
        <li><a href="#">Opción 1</a></li>
        <li><a href="#">Opción 2</a></li>
        <li><a href="#">Opción 3</a></li>
        <!-- Agrega más opciones según lo necesites -->
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Header',
  data() {
    return {
      isMenuOpen: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
  },
}
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
  padding: 25px 0;
  margin-left: 1px;
  width: 100%;
  position: fixed; /* Fijar el header */
  top: 0; /* Posicionarlo en la parte superior */
  z-index: 10001; /* Asegurarse de que esté por encima del resto del contenido */
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  height: 25px;
  margin-left: 20px;
}

.logo img {
  height: 60px;
  transform: translateY(-25%);
}

.menu-activador {
  width: 30px;
  height: 20px;
  margin-left: 50px;
  margin: -30px 50px 0; /* Ajuste en el margen-top */
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
  top: 70px; /* Altura del header */
  left: 0;
  width: 100%;
  height: calc(100% - 70px); /* Restar el alto del header */
  background-color: #ffffff;
  z-index: 10000; /* Un valor alto para asegurar que esté por encima del resto del contenido */
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
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.menu-desplegable ul li {
  margin: 15px 0;
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
</style>
