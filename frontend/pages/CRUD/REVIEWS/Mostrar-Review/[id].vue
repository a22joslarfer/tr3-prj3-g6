<template>
    <div class="container">
        <div class="title">Reseñas para la Disco {{ puntoInteresId }}</div>
        <div v-if="reviews.length > 0" class="reviews-list">
            <div v-for="review in reviews" :key="review.id" class="review">
                <h3>{{ review.titulo }}</h3>
                <p>{{ review.content }}</p>
                <div class="star-rating">
                    <span v-for="star in parseInt(review.puntuacion)" class="star" role="img" aria-label="star">⭐</span>
                </div>
                <img :src="review.photo" alt="Foto de la reseña" class="review-photo" />
            </div>
        </div>
        <div v-else>
            <p>No hay reseñas disponibles para esta disco.</p>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            puntoInteresId: null,
            reviews: []
        };
    },
    methods: {
        fetchReviews() {
            fetch(`http://localhost:8000/api/review/${this.puntoInteresId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error al obtener las reseñas: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data); // Agrega este console.log para verificar los datos recibidos
                    this.reviews = data;
                })
                .catch(error => {
                    console.error('Error al obtener las reseñas:', error);
                });
        }

    },
    created() {
        this.puntoInteresId = this.$route.params.id;
        this.fetchReviews();
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

.reviews-list {
    margin-top: 20px;
}

.review {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 20px;
}

.review h3 {
    font-size: 20px;
    margin-bottom: 10px;
}

.star-rating {
    unicode-bidi: bidi-override;
    direction: rtl;
    text-align: center;
    margin-bottom: 10px;
}

.star-rating .star {
    font-size: 20px;
    color: #ffc107;
}

.review-photo {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}
</style>