<template>
  <div>
    <HeaderGeneral />

    <div class="main-content">
      <div class="bereals-container">
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
    </div>
    <FooterOptions />
  </div>
</template>

<style scoped>
/* Main container styling */
.main-content {
  overflow-y: auto;
  height: calc(100vh - 100px);
}

.bereals-container {
  margin: 20px;
}

/* Section buttons styling */
.section-buttons {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.section-button-left,
.section-button-right {
  width: 48%;
}

.section-button-left h4,
.section-button-right h4 {
  cursor: pointer;
  padding: 10px;
  background-color: #ccc;
  border-radius: 5px;
  text-align: center;
  transition: background-color 0.3s ease;
}

.section-button-left h4.active,
.section-button-right h4.active {
  background-color: #f1693f;
  color: white;
}

/* List styling */
.bereals-list {
  margin-top: 20px;
}

/* Bereal item styling */
.bereal-item {
  margin-bottom: 20px;
  padding: 10px;
  background-color: #f9f9f9;
  border-radius: 16px;
}

.bereal-item h2 {
  font-size: 18px;
  margin-bottom: 5px;
}

.bereal-item p {
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
}

.bereal-images {
  display: flex;
  margin-bottom: 10px;
  justify-content: center;
  justify-items: center;
}

.bereal-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin-right: 10px;
}

/* Button styling */
.comment-button {
  padding: 8px 16px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  display: flex;
  margin: 0 auto;
}

.comment-button:hover {
  background-color: #0056b3;
}
</style>

<script>
import { useStore } from '../stores/index'

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
        const response = await fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/inTimes');
        if (!response.ok) {
          throw new Error('Error al obtener los Bereals');
        }
        const data = await response.json();
        for (const bereal of data) {
          // Obtindre el nom de l'usuari del Bereal
          const usuarioResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${bereal.id_usuari}`);
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
      // Reemplazar solo la segunda aparición de 'storage' con una cadena vacía
      return `http://elysium.daw.inspedralbes.cat/backend/storage/app/public${rutaRelativaImagen}`.replace(/storage(?!.*storage)/, '');
    },
    irAComentarios(idBereal) {
      this.$router.push(`/comentarios/${idBereal}`);
    },
  },
};
</script>
