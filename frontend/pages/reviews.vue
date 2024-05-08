<template>
    <div class="container">
        <h2>Lista de reviews</h2>
        <div class="dropdown-categorias">
            <select v-model="selectedCategory" class="mobile-select">
                <option disabled value="">Please select one</option>
                <option v-for="categoria in categorias_reviews" :key="categoria.id" :value="categoria.id">
                    {{ categoria.nombre }}
                </option>
            </select>
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
                        <div v-if="review.usuario_id != client_id">
                            <button @click="follow(review.usuario_id)">Follow</button>
                        </div>

                        <div v-else>
                            <button @click="deleteReview(review.id)">Eliminar review</button>
                        </div>
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
            fetch('http://localhost:8000/api/reviews')
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
            fetch(`http://localhost:8000/api/users/${id}`)
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

            return `http://localhost:8000/${rutaRelativaImagen}`;
        },
        fetchCategoriasReviews() {
            fetch('http://localhost:8000/api/categorias_reviews')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error fetching categorias_reviews: ${response.status} - ${response.statusText}`);
                    }
                    return response.json(); // Return the parsed JSON
                })
                .then(categorias => {
                    this.categorias_reviews = categorias;

                })
                .catch(error => {
                    console.error('Error fetching categorias_reviews:', error);
                    alert('Error fetching categorias_reviews');
                });
        },
        checkIfAuth() {
            const store = useStore();
            const user_id = store.return_user_id();
            if (user_id == null) {
                alert('Necesitas estar logueado para crear una review');
                this.$router.push('/login');
                store.set_return_path('/reviews');
            }
            this.client_id = user_id;

        },
        deleteReview(review_id) {
            fetch(`http://localhost:8000/api/reviews/${review_id}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error deleting review: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(review => {
                    alert('Review eliminada');
                    this.fetchReviews();
                })
                .catch(error => {
                    console.error('Error deleting review:', error);
                    alert('Error deleting review');
                });
        },
        follow(seguido_id) {
            fetch('http://localhost:8000/api/seguidores', {
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
        unfollow(seguido_id) {

        },
        checkIfSeguidor(seguidor_id, seguido_id) {
            fetch(`http://localhost:8000/api/seguidores/${seguidor_id}/${seguido_id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching seguidores');
                    }
                    return response.json();

                })
                .then(data => {
                    if (data.status) {
                        return true;
                    } else {
                        return false;
                    }
                })

                .catch(error => {
                    console.error('Error fetching seguidores:', error);
                    alert('Error fetching seguidores catch error');
                });
        }
    },
    mounted() {
        this.fetchReviews();
        this.fetchCategoriasReviews();
        this.checkIfAuth();

    },

};
</script>

<style scoped>
/*normazile*/
* {
    box-sizing: border-box;
    font-family: "Antonio", sans-serif;
    margin: 0;
    padding: 0px;
    overflow: hidden;
    color: #ccc;

}



.container {
    padding: 8px;
    background-color: #30355ade;
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


.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #30355a;
    background-clip: border-box;
    border: 1px solid #23284b;
    border-radius: 1rem;
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
    background-color: rgba(0, 0, 0, 0.301);
    border-top: 1px solid rgba(252, 252, 252, 0.212);
    border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
    display: flex;
    justify-content: space-between;
    align-items: center;
}


.dropdown-categorias {
    width: 100%;
    padding: 0;

}

button {
    background-color: #30355a;
    transition: background-color 0.2s ease-in-out;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #121322a8;

}

h2 {
    margin-top: 20px;
    margin-bottom: 20px;

}

.mobile-select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #30355a;
    border: 1px solid #ccc;

    border-radius: 4px;
}

option {
    background-color: #30355a;
    color: #ccc;
    border: 2px solid #ccc;
}

.dropdown-categorias:focus,
.mobile-select:focus,
.dropdown-categorias:active,
.mobile-select:active {
    outline: none;
}

body {
    margin: 0px;
}
</style>