<template>
    <div class="container mt-4">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Editar Revisión</div>
  
            <div class="card-body">
              <form @submit.prevent="updateReview">
                <div class="form-group">
                  <label for="usuario_id">Usuario ID</label>
                  <input type="text" class="form-control" id="usuario_id" v-model="review.usuario_id">
                </div>
  
                <div class="form-group">
                  <label for="disco_id">Discoteca ID</label>
                  <input type="text" class="form-control" id="disco_id" v-model="review.disco_id">
                </div>
  
                <div class="form-group">
                  <label for="titulo">Título</label>
                  <input type="text" class="form-control" id="titulo" v-model="review.titulo">
                </div>
  
                <div class="form-group">
                  <label for="content">Contenido</label>
                  <textarea class="form-control" id="content" rows="3" v-model="review.content"></textarea>
                </div>
  
                <div class="form-group">
                  <label for="puntuacion">Puntuación</label>
                  <input type="number" class="form-control" id="puntuacion" v-model="review.puntuacion">
                </div>
  
                <button type="submit" class="btn btn-primary">Actualizar Revisión</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import 'bootstrap/dist/css/bootstrap.css'
  
  export default {
    data() {
      return {
        review: {
          id: null,
          usuario_id: '',
          disco_id: '',
          titulo: '',
          content: '',
          puntuacion: ''
        }
      };
    },
    head() {
      return {
        link: [
          { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css' }
        ]
      };
    },
    methods: {
      fetchReview() {
        const reviewId = this.$route.params.id;
        fetch(`http://localhost:8000/api/reviews/${reviewId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Error fetching review data');
            }
            return response.json();
          })
          .then(data => {
            this.review = data;
          })
          .catch(error => {
            console.error(error);
          });
      },
      updateReview() {
        const reviewId = this.$route.params.id;
        fetch(`http://localhost:8000/api/reviews/${reviewId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.review)
        })
          .then(response => {
            if (!response.ok) {
              throw new Error('Error updating review');
            }
            return response.json();
          })
          .then(data => {
            console.log('Review updated');
            this.$router.push('/crud/reviews/');          })
          .catch(error => {
            console.error(error);
          });
      }
    },
    created() {
      this.fetchReview();
    }
  };
  </script>