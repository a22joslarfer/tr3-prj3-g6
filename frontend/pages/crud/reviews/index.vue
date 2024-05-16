<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Usuario Id</th>
                    <th>Discoteca Id</th>
                    <th>Título</th>
                    <th>Puntuación</th>
                    <th>Review</th>
                    <th>Foto</th>
                    <th>Crear</th>
                    <th>Delete</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="review in data" :key="review.id">
                    <td>{{ review.id }}</td>
                    <td>{{ review.usuario_id }}</td>
                    <td>{{ review.disco_id }}</td>
                    <td>{{ review.titulo }}</td>
                    <td>{{ review.puntuacion }}</td>

                    <td class="content-cell">{{ truncateContent(review.content) }}</td>

                    <td>
                        <img :src="review.photo" alt="Profile Photo" class="img-fluid rounded-circle" />
                    </td>
                    <td><button class="btn btn-primary" @click="crearNuevoItem()">Crear</button></td>
                    <td><button class="btn btn-danger" @click="eliminarItem(review.id)">Delete</button></td>
                    <td><button class="btn btn-warning" @click="editarItem(review.id)">Editar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css'

export default {
    data() {
        return {
            data: [],
            autenticado: false,
        }
    },
    head() {
        return {
            link: [
                { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css' }
            ]
        }
    },
    methods: {
        fetchData() {
            fetch('http://localhost:8000/api/reviews')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching review data');
                    }
                    return response.json();
                })
                .then(data => {
                    this.data = data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        truncateContent(content) {
            const maxLength = 100; // Maximum number of characters to display
            return content.length > maxLength ? content.slice(0, maxLength) + '...' : content;
        },
        crearNuevoItem() {
            navigateTo('/crud/reviews/create');
        },
        eliminarItem(id) {
            fetch(`http://localhost:8000/api/reviews/${id}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error deleting review');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Review deleted');
                    this.fetchData();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        editarItem(id) {
            navigateTo(`/crud/reviews/edit/${id}`);
        }
    },
    created() {
        this.fetchData();
    },
}
</script>

<style scoped>
.content-cell {
    max-width: 200px;
    overflow: auto;
}

::-webkit-scrollbar {
    width: 5px;
}
</style>
