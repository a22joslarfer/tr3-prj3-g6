<template>
  <div class="container">
    <div class="title">Crear Reseña para la Disco {{ puntoInteresId }}</div>
    <form @submit.prevent="submitReview" class="form">
      <input type="text" v-model="titulo" class="input" placeholder="Título" required />
      <textarea v-model="content" class="input" placeholder="Contenido" required></textarea>
      <div class="star-rating">
        <input type="radio" id="star5" name="rating" value="5" v-model="puntuacion" required />
        <label for="star5" title="5 stars"></label>
        <input type="radio" id="star4" name="rating" value="4" v-model="puntuacion" />
        <label for="star4" title="4 stars"></label>
        <input type="radio" id="star3" name="rating" value="3" v-model="puntuacion" />
        <label for="star3" title="3 stars"></label>
        <input type="radio" id="star2" name="rating" value="2" v-model="puntuacion" />
        <label for="star2" title="2 stars"></label>
        <input type="radio" id="star1" name="rating" value="1" v-model="puntuacion" />
        <label for="star1" title="1 star"></label>
      </div>
      <input type="file" @change="handleFileUpload" class="input" accept="image/*" required />
      <button type="submit" class="button">Enviar Reseña</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      usuario_id: 1,
      puntoInteresId: null,
      titulo: '',
      puntuacion: 0,
      content: '',
      photo: null 
    };
  },
  methods: {
    submitReview() {
      const formData = new FormData();
      formData.append('disco_id', this.puntoInteresId);
      formData.append('usuario_id', this.usuario_id);
      formData.append('titulo', this.titulo);
      formData.append('puntuacion', this.puntuacion);
      formData.append('content', this.content);
      formData.append('photo', this.photo); // Agregamos la foto al FormData

      fetch('http://localhost:8000/api/reviews', {
        method: 'POST',
        body: formData
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error al enviar la reseña: ${response.status} - ${response.statusText}`);
          }
          console.log('Reseña enviada correctamente');
          navigateTo('/');
        })
        .catch(error => {
          console.error('Error al enviar la reseña:', error);
        });
    },
    handleFileUpload(event) {
      this.photo = event.target.files[0];
    }
  },
  created() {
    this.puntoInteresId = this.$route.params.id;
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title {
  font-size: 24px;
  margin-bottom: 20px;
}

.input {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

textarea.input {
  height: 150px;
}

.star-rating {
  unicode-bidi: bidi-override;
  direction: rtl;
  text-align: center;
}

.star-rating input[type="radio"] {
  display: none;
}

.star-rating label {
  display: inline-block;
  padding: 5px;
  font-size: 30px;
  color: #ccc;
  cursor: pointer;
}

.star-rating label:before {
  content: '★';
}

.star-rating input[type="radio"]:checked~label {
  color: #ffc107;
}
</style>