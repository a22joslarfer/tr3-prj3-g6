<template>
  <HeaderGeneral />

  <div class="container">
    <form @submit.prevent="submitReview" class="form">

      <div class="form-group">
        <label for="titulo" class="texto">Título *</label>
        <input type="text" id="titulo" v-model="titulo" class="form-control" required
          placeholder="Ingresa el título de la reseña...">
      </div>

      <div class="form-group">
        <label for="content" class="texto">Contenido </label>
        <textarea id="content" v-model="content" class="form-control" required
          placeholder="Escribe aquí el contenido de la reseña..."></textarea>
      </div>

      <div class="form-group">
        <label class="texto">Categoría </label>
        <select v-model="categoria" class="form-control">
          <option v-for="(item, index) in categorias_reviews" :key="index" :value="index">{{ item.nombre }}</option>
        </select>
      </div>

      <div class="form-group">
        <label for="puntuacion" class="texto">Puntuación </label>
        <!-- <input type="number" id="puntuacion" v-model="puntuacion" min="1" max="5" class="form-control"> -->
        <NuxtRating :read-only="false" :ratingValue="1.2" class="stars-rating"/>

      </div>

      <div class="form-group" >
        <label for="photo" class="texto">Foto (opcional):</label>
        <div class="dropzone" @click="openFileInput">
          <input type="file" id="photo" ref="fileInput" @change="handleFileUpload" class="form-control-file"
            accept="image/*">
          <div class="dropzone-text" @click="openFileInput">

          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="margin-bottom: 150px;">Enviar reseña</button>
    </form>
    <div class="footer">

    <FooterOptions />
    </div>  
  </div>
</template>

<script>
import { useStore } from '../stores/index.js';
export default {
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

    logRating(rating) {
      console.log('Rating:', rating);
      this.puntuacion = rating;
    },
    submitReview() {
      if (!this.categoria) {
        alert('Please select a category.');
        return;
      }
      if (!this.photo || this.photo === null) {
        alert('Please select a photo.');
        return;
      }

      let formData = new FormData();
      formData.append('disco_id', this.disco_id);
      formData.append('usuario_id', this.usuario_id);
      formData.append('titulo', this.titulo);
      formData.append('content', this.content);
      formData.append('puntuacion', this.puntuacion);
      formData.append('categoria', this.categoria);
      formData.append('photo', this.photo);

      fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/reviews', {
        method: 'POST',
        headers: {
          'Accept': 'application/json'
        },
        body: formData,
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error submitting review: ${response.status} - ${response.statusText}`);
          }

          this.$router.push('/reviews');
        })
        .catch(error => {
          alert('Error submitting review: ' + error.message);
        });
    },
    handleFileUpload(event) {
      this.photo = event.target.files[0];
    },
    openFileInput() {
      this.$refs.fileInput.click();
    },
    fetchCategorias() {
      fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/categorias_reviews')
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error fetching categorias: ${response.status} - ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          this.categorias_reviews = data;
          console.log('Categorias:', this.categorias_reviews);
        })
        .catch(error => {
          alert('Error fetching categorias: ' + error.message)
        });
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
@import url('https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
.container {
  padding: 20px;
  overflow-y: auto;
  background-color: rgb(181, 205, 214);
  margin-bottom: 60px; /* Añadir un margen inferior para evitar solapamiento con el footer */
}

.footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: #fff; /* Ajusta el color según tu diseño */
  height: 60px; /* Ajusta la altura según tu diseño */
  box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
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
  font-variation-settings:
    "wdth" 100;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  font-size: 13px;
  transition: border-color 0.3s ease;
  margin-top:10px;
}

.dropzone {
  position: relative;
  width: 100%;
  min-height: 50px;
  border: 2px dashed #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
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
.stars-rating{
position: relative;
  }

@media (min-width: 768px) {
  .container {
    max-width: 600px;
    margin: 0 auto;
  }
}
</style>
