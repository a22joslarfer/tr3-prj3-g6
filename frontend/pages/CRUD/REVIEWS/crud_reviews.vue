<template>
    <div class="container">
      <div class="title">CRUD Reseñas</div>
  
      <div v-if="reviews.length > 0">
        <div class="title">Reseñas</div>
        <table class="disco-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Comentario</th>
              <th>Valoración</th>
              <th>Discoteca</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="review in reviews"
              :key="review.id"
              class="disco-table-item"
            >
              <td>{{ review.id }}</td>
              <td>{{ review.titulo }}</td>
              <td>{{ review.content }}</td>
              <td>
                <div class="star-rating">
                  <span v-for="n in 5" :class="{ filled: n <= review.puntuacion }"
                    >&#9733;</span
                  >
                </div>
              </td>
              <td>{{ review.discoName }}</td>
              <td>
                <div class="btn-holder">
                  <button
                    class="btn-edit"
                    @click="editReview(review.id, review.disco_id)"
                  >
                    Editar
                  </button>
                  <button
                    class="btn-delete"
                    @click="deleteReview(review.id, review.disco_id)"
                  >
                    Eliminar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        reviews: [],
      };
    },
  
    methods: {
      async fetchReviews() {
        try {
          const response = await fetch("http://localhost:8000/api/reviews");
          if (!response.ok) {
            throw new Error(
              `Error al obtener las reseñas: ${response.status} - ${response.statusText}`
            );
          }
          this.reviews = await response.json();
          await this.getDiscoNom();
        } catch (error) {
          console.error("Error al obtener las reseñas:", error);
        }
      },
      async getDiscoNom() {
        await Promise.all(
          this.reviews.map(async (review) => {
            try {
              const response = await fetch(
                `http://localhost:8000/api/discotecas/${review.disco_id}`
              );
              if (!response.ok) {
                throw new Error(
                  `Error al obtener el nombre de la discoteca: ${response.status} - ${response.statusText}`
                );
              }
              const disco = await response.json();
              review.discoName = disco.nombre_local;
            } catch (error) {
              console.error("Error al obtener el nombre de la discoteca:", error);
              review.discoName = "Nombre no disponible";
            }
          })
        );
      },
      editReview(id, disco_id) {
        navigateTo(`/Editar-Review/${id}/${disco_id}`);
   
      },
      async deleteReview(id) {
        if (confirm("¿Estás seguro de que quieres eliminar esta reseña?")) {
          try {
            const response = await fetch(
              `http://localhost:8000/api/reviews/${id}`,
              {
                method: "DELETE",
                headers: {
                  "Content-Type": "application/json",
                },
              }
            );
  
            if (response.ok) {
              this.reviews = this.reviews.filter((review) => review.id !== id);
            } else {
              console.error("Error al eliminar la reseña:", response.statusText);
            }
          } catch (error) {
            console.error("Error al eliminar la reseña:", error.message);
          }
        }
      },
    },
  
    mounted() {
      this.fetchReviews();
    },
  };
  </script>
  
  <style lang="scss" scoped>
  .container {
    max-width: 800px;
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
  
  .disco-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  .disco-table th,
  .disco-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  .disco-table th {
    background-color: #f2f2f2;
  }
  
  .disco-table-item:nth-child(even) {
    background-color: #dfdfdf;
  }
  
  .disco-table-item:nth-child(odd) {
    background-color: #fff;
  }
  
  .btn-holder {
    display: flex;
    justify-content: space-around;
  }
  
  .btn-edit {
    background-color: #191a16;
    color: floralwhite;
    padding: 8px 40px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
  }
  
  .btn-delete {
    background-color: #191a16;
    color: floralwhite;
    padding: 8px 40px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
  }
  
  .btn-delete:hover {
    background-color: #e60303;
  }
  
  .btn-edit:hover {
    background-color: #088ce4;
  }
  
  .star-rating {
    color: rgb(201, 201, 191);
  }
  
  .star-rating .filled {
    color: gold;
  }
  </style>