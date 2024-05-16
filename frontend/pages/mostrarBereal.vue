<template>
  <div>
    <HeaderGeneral />
    <body>
      <div class="bereals-container">
        <h1>InTime</h1>
        <div class="section-buttons">
          <div class="section-button-left">
            <h4 @click="showSection('todos')" :class="{ active: activeSection === 'todos' }">Tots els InTime</h4>
          </div>
          <div class="section-button-right">
            <h4 @click="showSection('misIntime')" :class="{ active: activeSection === 'misIntime' }">Mis InTime</h4>
          </div>
        </div>
        <div v-if="activeSection === 'todos'" class="bereals-list" id="bereals-list">
          <div v-if="bereals.length">
            <div v-for="bereal in bereals" :key="bereal.id" class="bereal-item">
              <h2>{{ bereal.usuarioNombre }} </h2>
              <p>{{ bereal.hora.slice(11, 19) }}</p>
              <div class="bereal-images">
                <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
                <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
              </div>
              <button @click="irAComentarios(bereal.id)" class="comment-button">Afegir Comentaris</button>
            </div>
          </div>
          <p v-else>No s'han trobat InTimes.</p>
        </div>
        <div v-else-if="activeSection === 'misIntime'" class="bereals-list" id="bereals-list">
          <div v-if="misIntime.length">
            <div v-for="bereal in misIntime" :key="bereal.id" class="bereal-item">
              <h2>{{ bereal.usuarioNombre }} </h2>
              <p>{{ bereal.hora.slice(11, 19) }}</p>
              <div class="bereal-images">
                <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
                <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
              </div>
              <button @click="irAComentarios(bereal.id)" class="comment-button">Afegir Comentaris</button>
            </div>
          </div>
          <p v-else>No has pujat cap InTime encara.</p>
        </div>
        <p v-else>No s'ha selecionat cap secció.</p>
      </div>
    </body>
    <FooterOptions />
  </div>
</template>

<script>
import { useStore } from '../stores/index';

export default {
  data() {
    return {
      activeSection: 'todos', // Sección activa por defecto
      bereals: [],
    };
  },
  created() {
    this.checkIfAuth();
  },
  async mounted() {
    await this.obtenerBereals();
  },
  computed: {
    misIntime() {
      return this.bereals.filter(bereal => bereal.id_usuari === this.userId);
    },
  },
  methods: {
    checkIfAuth() {
      const store = useStore();
      this.userId = store.return_user_id();
      if (this.userId === null) {
        navigateTo('/login');
      }
    },
    async obtenerBereals() {
      try {
        const store = useStore();
        const userId = store.return_user_id();
        const response = await fetch(`http://localhost:8000/api/bereals`);
        if (!response.ok) {
          throw new Error('Error al obtener los Bereals');
        }
        const data = await response.json();
        for (const bereal of data) {
          // Obtindre el nom de l'usuari del Bereal
          const usuarioResponse = await fetch(`http://localhost:8000/api/users/${bereal.id_usuari}`);
          if (!usuarioResponse.ok) {
            throw new Error('Error al obtener el usuario');
          }
          const usuarioData = await usuarioResponse.json();
          bereal.usuarioNombre = usuarioData.data;
        }
        this.bereals = data;
      } catch (error) {
        console.error(error);
      }
    },
    showSection(section) {
      this.activeSection = section;
    },
    getImagenUrl(rutaRelativaImagen) {
      return `http://localhost:8000/${rutaRelativaImagen}`;
    },
    irAComentarios(idBereal) {
      this.$router.push(`/comentarios/${idBereal}`);
    },
  },
};
</script>

<style scoped>
html,
body {
  margin: 0;
  padding: 0;
  height: 100vh;
  width: 100%;
}

body {
  background-color: black;
}

h1 {
  color: white;
  text-align: center;
  margin-top: 20px;
  margin-bottom: 15px;
}

h2, h4 {
  color: white;
  margin-bottom: 10px;
}

p {
  color: grey;
  margin-bottom: 20px;
}

.bereals-container {
  padding: 20px;
  overflow-y: auto;
  max-height: calc(100vh - 150px);
}

.section-buttons {
  display: flex;
  justify-content: space-between;
}

.section-button-left {
  margin-right: auto;
}

.section-button-right {
  margin-left: auto;
}

.bereal-item {
  margin-bottom: 20px;
  border: 1px solid #ddd;
  padding: 10px;
  overflow: auto;
  border-radius: 5px;
}

.bereal-images {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.bereal-image {
  width: 45%;
  max-width: 150px;
  height: auto;
  border-radius: 5px;
}

.comment-button {
  width: 100%;
  padding: 5px;
  background-color: grey;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

@media (min-width: 768px) {
  .bereal-item {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  .bereal-image {
    width: 100%;
    max-width: none;
    height: 150px;
  }
}
</style>