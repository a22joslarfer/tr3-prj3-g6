<template>
    <div>
        <h1>Reviews</h1>
        <div class="form-group">
            <label for="categoria">Category:</label>
            <select id="categoria" v-model="categoria" class="form-control" required>
                <option v-for="categoria in categorias_reviews" :key="categoria.nombre" :value="categoria.id">
                    {{ categoria.nombre }}
                </option>
            </select>
        </div>
        <button @click="fetchReviews" class="btn btn-primary">Fetch Reviews</button>
        <div v-for="review in reviews" :key="review.id">
            <h2>{{ review.titulo }}</h2>
            <p>{{ review.content }}</p>
            <p>{{ review.puntuacion }}</p>
            <img :src="review.photo" alt="review photo">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            reviews: [],
            categorias_reviews: [],
            categoria: '',
        };
    },
    methods: {
        fetchReviews() {
            fetch('http://localhost:8000/api/reviews', {
                method: 'GET',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error submitting review: ${response.status} - ${response.statusText}`);
                    }
                    this.reviews = response.json();

                })
                .catch(error => {
                    alert('Error fetching reviews');
                });
        }
    }
}
</script>

<style scoped></style>