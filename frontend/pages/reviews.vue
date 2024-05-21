<template>
    <div class="container">
        <h1 class="header">Lista de Reseñas</h1>
        <div class="reviews-list">
            <div class="review-card" v-for="review in reviews" :key="review.id">
                <img :src="getImagenUrl(review.photo)" class="review-photo" alt="Foto de reseña">
                <div class="review-content">
                    <h2>{{ review.titulo }}</h2>
                    <p><strong>Usuario:</strong> {{ getUserById(review.usuario_id) }}</p>
                    <p><strong>Disco ID:</strong> {{ getDiscoNameById(review.disco_id) }}</p>
                    <p><strong>Contenido:</strong> {{ review.content }}</p>
                    <p><strong>Puntuación:</strong> {{ review.puntuacion }}</p>
                    <p><strong>Categoría:</strong> {{ review.categoria }}</p>
                    <!-- for each a discotecas -->
            
                </div>
                <button @click="follow(review.usuario_id)">Seguir</button>
            </div>
        </div>
    </div>
</template>

<script>
import { useStore } from '../stores/index.js';

export default {
    data() {
        return {
            reviews: [],
            userMap: {},
            search: '',
            imageSrc: null,
            categorias_reviews: [],
            client_id: null,
            selectedCategory: '',
            
            
        };
    },
    methods: {
        fetchReviews() {
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/reviews')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching reviews: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(reviews => {
                    this.reviews = reviews;
                    reviews.forEach(review => {
                        this.fetchUserById(review.usuario_id);
                    });
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                });
        },
        fetchUserById(id) {
            fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching user: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(response => {
                    this.userMap[id] = response.data;
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                });
        },
        getUserById(id) {
            const userName = this.userMap[id];
            return userName ? userName : 'Usuario Desconocido';
        },
        getDiscoNameById(id) {
            const disco = this.discotecas.find(disco => disco.id === id);
            return disco ? disco.nombre_local : 'Disco Desconocida';
        },
        getImagenUrl(rutaRelativaImagen) {
            return `http://elysium.daw.inspedralbes.cat/backend/storage/app/public${rutaRelativaImagen}`.replace(/storage(?!.*storage)/, '');
        },
        fetchCategoriasReviews() {
            console.log('fetchCategoriasReviews');
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/categorias_reviews')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching categorias_reviews: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(categorias => {
                    this.categorias_reviews = categorias;
                })
                .catch(error => {
                    console.error('Error fetching categorias_reviews:', error);
                });
        },
        checkIfAuth() {
            const store = useStore();
            const user_id = store.return_user_id();
            if (user_id === null) {
                store.set_return_path('/reviews');
                this.$router.push('/login');
            }
            this.client_id = user_id;
        },
      
        follow(seguido_id) {
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/seguidores', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    seguidor: this.client_id,
                    seguido: seguido_id,
                }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error adding friend: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(friend => {
                    alert('Amigo añadido');
                })
                .catch(error => {
                    console.error('Error adding friend:', error);
                    alert('Error adding friend');
                });
        },
        //fetch a discotecas/review.disco_id
        fetchDiscotecas() {
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/discotecas')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching discotecas: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    this.discotecas = data;
                })
                .catch(error => {
                    console.error('Error fetching discotecas:', error);
                });
        },
       
    },
    created() {
        this.checkIfAuth();
        this.fetchReviews();
        this.fetchCategoriasReviews();
        this.fetchDiscotecas();
    },
};
</script>

<style scoped>
.container {
    padding: 5%;
    background-color: #f9f9f9;
}

.header {
    text-align: center;
    margin-bottom: 5%;
    font-size: 1.5em;
}

.reviews-list {
    display: flex;
    flex-direction: column;
    gap: 5%;
}

.review-card {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5%;
    display: flex;
    flex-direction: column;
    gap: 3%;
}

.review-photo {
    width: 100%;
    border-radius: 8px;
}

.review-content h2 {
    margin: 0 0 5% 0;
    font-size: 1.2em;
}

.review-content p {
    margin: 2% 0;
}

button {
    align-self: flex-start;
    padding: 5% 10%;
    margin: 2% 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #007bff;
    color: white;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}
</style>
