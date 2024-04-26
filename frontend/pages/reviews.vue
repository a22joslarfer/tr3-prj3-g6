<template>
    <div class="container">
        <h2>Lista de reviews</h2>
        <div class="btn-group" role="group">
            <div class="button-wrapper">
                <button v-for="reviews_categoria in reviews" :key="reviews_categoria.id" type="button"
                    class="btn btn-secondary">
                    {{ reviews_categoria.categoria }}
                </button>
            </div>

        </div>

        <div class="row">
            <div v-for="review in reviews" :key="review.id" class="col-md-4">
                <div class="card mb-3">
                    <img :src="getImagenUrl(review.photo)" class="card-img-top" alt="...">


                    <div class="card-body">
                        <h5 class="card-title">{{ review.titulo }}</h5>
                        <p class="card-text">{{ review.content }}</p>
                        <p class="card-text">Puntuación: {{ review.puntuacion }}</p>

                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Review de {{ getUserById(review.usuario_id) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            reviews: [],
            userMap: {}, // Using an object instead of array to store user data
            search: '',
            imageSrc: null,
        };
    },
    methods: {
        fetchReviews() {
            fetch('http://viaegis.daw.inspedralbes.cat/backend/public/api/reviews')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching reviews: ${response.status} - ${response.statusText}`);
                    }
                    return response.json(); // Return the parsed JSON
                })
                .then(reviews => {
                    this.reviews = reviews;
                    reviews.forEach(review => {
                        this.fetchUserById(review.usuario_id);
                    });
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                    alert('Error fetching reviews');
                });
        },
        fetchUserById(id) {
            fetch(`http://viaegis.daw.inspedralbes.cat/backend/public/api/users/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching user: ${response.status} - ${response.statusText}`);
                    }
                    return response.json(); // Return the parsed JSON
                })
                .then(user => {
                    this.userMap[id] = user; // Direct assignment
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                    alert('Error fetching user');
                });
        },
        getUserById(id) {
            const user = this.userMap[id];
            return user ? user.name : 'Usuario Desconocido';
        },
        getImagenUrl(rutaRelativaImagen) {
            // Reemplazar solo la segunda aparición de 'storage' con una cadena vacía
            return `http://viaegis.daw.inspedralbes.cat/backend/public/${rutaRelativaImagen}`;
        }
    },
    mounted() {
        this.fetchReviews();
    },
    computed: {
        filteredReviews() {

            return this.reviews.filter(review => review.categoria.includes(this.search));
        },
    },
};
</script>

<style scoped>
/* Bootstrap-like CSS */
.container {
    margin-right: auto;
    margin-left: auto;
    padding-right: 15px;
    padding-left: 15px;
}

.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s;
    cursor: pointer;
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #5a6268;
    border-color: #545b62;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
    margin: 40px 0;
}

.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}

.card-body {
    flex: 1 1 auto;
    padding: 1.25rem;
}

.card-title {
    margin-bottom: 0.75rem;
    font-size: 1.25rem;
}

.card-text:last-child {
    margin-bottom: 0;
}

.card-footer {
    padding: 0.75rem 1.25rem;
    background-color: rgba(0, 0, 0, 0.03);
    border-top: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
}

.text-muted {
    color: #539ddf !important;
}

button {
    margin: 5px;
    padding: 20px;
    font-size: 20px;
}

.button-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
</style>