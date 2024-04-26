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
        <label for="content" class="texto">Contenido *</label>
        <textarea id="content" v-model="content" class="form-control" required
          placeholder="Escribe aquí el contenido de la reseña..."></textarea>
      </div>

      <div class="form-group">
        <label for="categoria" class="texto">Categoría *</label>
        <select id="categoria" v-model="categoria" class="form-control" required>
          <option disabled value="">Selecciona una categoría</option>
          <option v-for="categoria in categorias_reviews" :key="categoria.nombre" :value="categoria.id">
            {{ categoria.nombre }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="puntuacion" class="texto">Puntuación *</label>
          <NuxtRating :read-only="false" :rating-count="5" :rating-size="'40px'" :active-color="'gold'"
            :rating-value="1" rating-content="⭐" @rating-selected="logRating" class="star-rating"/>

      </div>

      <div class="form-group">
        <label for="photo" class="texto">Foto (opcional):</label>
        <div class="dropzone" @click="openFileInput">
          <input type="file" id="photo" ref="fileInput" @change="handleFileUpload" class="form-control-file"
            accept="image/*" style="display: none;">
          <span>Seleccionar archivo</span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Enviar reseña</button>
    </form>
    <FooterOptions />
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
      puntuacion: null,
      photo: null,
      categorias_reviews: [],
      categoria: '',
    };
  },
  methods: {

   logRating(rating) {
      console.log('Rating:', rating);
      this.puntuacion = rating;
    },
    submitReview() {
      let data = {
        disco_id: this.disco_id,
        usuario_id: this.usuario_id,
        titulo: this.titulo,
        content: this.content,
        puntuacion: this.puntuacion,
        photo: this.photo,
        categoria: this.categoria,
      };

      fetch('http://localhost:8000/api/reviews', {
        method: 'POST',
        mode: 'no-cors',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error submitting review: ${response.status} - ${response.statusText}`);
          }

          alert('Review submitted successfully!');
          this.$router.push('/');

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
      fetch('http://localhost:8000/api/categorias_reviews')
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error fetching categorias: ${response.status} - ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          this.categorias_reviews = data;
        })
        .catch(error => {
          alert('Error fetching categorias: ' + error.message)
        });
    }
  },
  created() {
    this.disco_id = this.$route.params.id;
    const store = useStore();
    this.usuario_id = store.return_user_id();

    console.log('Disco ID:', this.disco_id);
    console.log('Usuario ID:', this.usuario_id);

  },
  mounted() {
    this.fetchCategorias();
    console.log('Categorias:', this.categorias_reviews);
  },
};
</script>

<style scoped>
.container {
  padding: 20px;
}

.form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 30px;
}

.texto {

  font-weight: bold;
  color: #333;
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

.form-control:focus {
  outline: none;
  border-color: #007bff;
}

.dropzone {
  position: relative;
  width: 100%;
  height: 50px;
  border: 2px dashed #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.dropzone:hover {
  background-color: #f0f0f0;
}

.dropzone span {
  color: #555;
  font-size: 16px;
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

.btn-primary:hover {
  background-color: #0056b3;
}
.star-rating {
  margin-top: 10px;
}
textarea{
  resize: none;
}
</style>
