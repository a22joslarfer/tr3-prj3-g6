<template>
  <HeaderGeneral />
  <div class="container">
    <form @submit.prevent="submitReview" class="form">
      <div class="form-group">
        <label for="titulo" class="texto">Título *</label>
        <input type="text" id="titulo" v-model="titulo" class="form-control" required placeholder="Ingresa el título de la reseña...">
      </div>

      <div class="form-group">
        <label for="content" class="texto">Contenido </label>
        <textarea id="content" v-model="content" class="form-control" required placeholder="Escribe aquí el contenido de la reseña..."></textarea>
      </div>

      <div class="form-group">
        <label class="texto">Categoría </label>
        <select v-model="categoria" class="form-control">
          <option v-for="(item, index) in categorias_reviews" :key="index" :value="index">{{ item.nombre }}</option>
        </select>
      </div>

      <div class="form-group">
        <label for="puntuacion" class="texto">Puntuación </label>
        <TestRating :ratingValue="puntuacion" @input="updateRating"/>
      </div>

      <div class="form-group">
        <label for="photo" class="texto">Foto (opcional):</label>
        <input type="file" id="photo" ref="fileInput" @change="handleFileUpload" class="form-control-file" accept="image/*" required>
      </div>

      <button type="submit" class="btn btn-primary" style="margin-bottom: 150px;">Enviar reseña</button>
    </form>
    <FooterOptions />
  </div>
</template>

<script>
import { useStore } from '../stores/index.js';
import TestRating from '../components/TestRating.vue'; // Asegúrate de que la ruta sea correcta

export default {
  components: {
    TestRating
  },
  data() {
    return {
      disco_id: '',
      usuario_id: '',
      titulo: '',
      content: '',
      puntuacion: 1,
      photo: null,
      categorias_reviews: [],
      categoria: null,
    };
  },
  methods: {
    submitReview() {
      if (!this.categoria) {
        alert('Por favor selecciona una categoría.');
        return;
      }
      //photo
      if (this.photo) {
        alert('Por favor selecciona una foto.');
        console.log('Foto:', this.photo);
      }

      console.log('Puntuación al enviar:', this.puntuacion);

      let formData = new FormData();
      formData.append('disco_id', this.disco_id);
      formData.append('usuario_id', this.usuario_id);
      formData.append('titulo', this.titulo);
      formData.append('content', this.content);
      formData.append('puntuacion', this.puntuacion);
      formData.append('categoria', this.categoria);
      if (this.photo) {
        formData.append('photo', this.photo);
      }

      fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/reviews', {
        method: 'POST',
        body: formData,
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al enviar la reseña: ${response.status} - ${response.statusText}`);
        }
        this.$router.push('/reviews');
      })
      .catch(error => {
        alert('Error al enviar la reseña: ' + error.message);
      });
    },
    handleFileUpload(event) {
      this.photo = event.target.files[0];
    },
    fetchCategorias() {
      fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/categorias_reviews')
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al obtener las categorías: ${response.status} - ${response.statusText}`);
        }
        return response.json();
      })
      .then(data => {
        this.categorias_reviews = data;
      })
      .catch(error => {
        alert('Error al obtener las categorías: ' + error.message);
      });
    },
    updateRating(value) {
      console.log('Nueva Puntuación:', value);
      this.puntuacion = value;
      console.log('Puntuación actualizada:', this.puntuacion);
    },
  },
  mounted() {
    const store = useStore();
    const user_id = store.return_user_id();

    if (user_id === null) {
      store.set_return_path('/' + this.$route.params.id);
      this.$router.push('/login');
    }

    this.disco_id = this.$route.params.id;
    this.usuario_id = store.return_user_id();

    this.fetchCategorias();
  },
};
</script>


<style scoped>
.container {
  padding: 20px;
  overflow-y: auto;
  background-color: rgb(210 217 219);
    margin-bottom: 60px;
}
.form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 20px;
}

.texto {
  font-family: "Open Sans", sans-serif;
  font-optical-sizing: auto;
  font-weight: 600;
  font-style: normal;
  font-variation-settings: "wdth" 100;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  font-size: 13px;
  transition: border-color 0.3s ease;
  margin-top: 10px;
}

.btn-primary {
  width: 100%;
  padding: 15px;
  border: none;
  border-radius: 5px;
  background-color: #007bff;
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.stars-rating {
  position: relative;
}

@media (min-width: 768px) {
  .container {
    max-width: 600px;
    margin: 0 auto;
  }
}
</style>