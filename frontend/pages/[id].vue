<template>
  <div class="container">
    <form @submit.prevent="submitReview" class="form">

      <div class="form-group">
        <label for="titulo">Title:</label>
        <input type="text" id="titulo" v-model="titulo" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="content">Content:</label>
        <textarea id="content" v-model="content" class="form-control" required></textarea>
      </div>

      <div class="form-group">
        <label for="categoria">Category:</label>
        <select id="categoria" v-model="categoria" class="form-control" required>
          <option v-for="categoria in categorias_reviews" :key="categoria.nombre" :value="categoria.id">
            {{ categoria.nombre }}
          </option>
        </select>
      </div>



      <div class="form-group">
        <label for="puntuacion">Rating:</label>
        <input type="number" id="puntuacion" v-model="puntuacion" class="form-control" required>
      </div>


      <div class="form-group">
        <label for="photo">Photo:</label>
        <div class="dropzone">
          <input type="file" id="photo" ref="fileInput" @change="handleFileUpload" class="form-control-file"
            accept="image/*">
          <div class="dropzone-text" @click="openFileInput">

          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Submit Review</button>
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

      fetch('http://viaegis.daw.inspedralbes.cat/backend/public/api/reviews', {
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
      fetch('http://viaegis.daw.inspedralbes.cat/backend/public/api/categorias_reviews')
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
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  font-weight: bold;
}




input[type="text"],
input[type="number"],
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

textarea {
  height: 150px;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary {
  background-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
}

/* Estilos para el dropzone */
.dropzone {
  position: relative;
  border: 2px dashed #ccc;
  border-radius: 4px;
  padding: 20px;
  cursor: pointer;
}

.dropzone-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #777;
  text-align: center;
}

.dropzone-text span {
  display: block;
}

/* Style the select dropdown */
.select-wrapper select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #fff;
  cursor: pointer;
  padding-right: 30px;
  /* Add space for the arrow */
}

/* Style the arrow icon */
.select-wrapper:after {
  content: '\25BC';
  /* Downward arrow */
  font-size: 16px;
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  pointer-events: none;
}

/* Apply hover and focus styles to the select dropdown */
.select-wrapper:hover select,
.select-wrapper select:focus {
  border-color: #b8daff;
  /* Light blue border color on hover/focus */
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  /* Light blue shadow on hover/focus */
}

/* Style select options */
.select-wrapper select option {
  padding: 10px;
}

/* Estilos para las opciones del select */
.select-wrapper select option {
  padding: 10px;
}
</style>
