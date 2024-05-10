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
        <div v-for="(item, index) in categorias_reviews" :key="index">
          <button type="button" @click="categoria = index">{{ item.nombre }}</button>
        </div>
      </div>

      <div class="form-group">
        <label for="puntuacion" class="texto">Puntuación </label>
        <input type="number" id="puntuacion" v-model="puntuacion" min="1" max="5" class="form-control">
      </div>

      <div class="form-group">
        <label for="photo" class="texto">Foto (opcional):</label>
        <div class="dropzone" @click="openFileInput">
          <input type="file" id="photo" ref="fileInput" @change="handleFileUpload" class="form-control-file"
            accept="image/*">
          <div class="dropzone-text" @click="openFileInput">

          </div>
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
        return; // Don't proceed with review submission if categoria is not selected
      }
      let data = {
        disco_id: this.disco_id,
        usuario_id: this.usuario_id,
        titulo: this.titulo,
        content: this.content,
        puntuacion: this.puntuacion,
        categoria: this.categoria,
      };

      console.log('categoria' + this.categoria);
      // Check if photo is present before adding it to the data object
      if (this.photo) {
        data.photo = this.photo;
      }

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
          alert('Tot correcte!');
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
      fetch('http://localhost:8000/api/categorias_reviews')
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
    checkIfAuth() {
      const store = useStore();
      const user_id = store.return_user_id();
      if (user_id === null) {
        store.set_return_path('/' + this.$route.params.id);
        this.$router.push('/login');
      
      }
    }
  },
  created() {
    this.disco_id = this.$route.params.id;
    const store = useStore();
    this.usuario_id = store.return_user_id();


  },
  computed() {
    this.checkifAuth();
  },
  mounted() {
    this.fetchCategorias();
    console.log('Categorias:', this.categorias_reviews);
    this.checkIfAuth();
  },
};
</script>

<style scoped>
.container {
  padding: 20px;
  height: auto;
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

textarea {
  resize: none;
}
</style>
