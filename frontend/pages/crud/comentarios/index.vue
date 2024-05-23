<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>id inTime</th>
                    <th>id usuari</th>
                    <th>Comentario</th>
                    <th>Hora</th>
                    <th>Crear</th>
                    <th>Delete</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="comentario in data" :key="comentario.id">
                    <td>{{ comentario.id }}</td>
                    <td>{{ comentario.id_bereal }}</td>
                    <td>{{ comentario.id_usuari }}</td>
                    <td>{{ comentario.comentario }}</td>
                    <td>{{ comentario.hora }}</td>

                    <td><button class="btn btn-primary" @click="crearNuevoItem()">Crear</button></td>
                    <td><button class="btn btn-danger" @click="eliminarItem(comentario.id)">Delete</button></td>
                    <td><button class="btn btn-warning" @click="editarItem(comentario.id)">Editar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css'
definePageMeta({
    middleware: 'admin'
});

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
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/comentarios')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching comentario data');
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
        crearNuevoItem() {
            this.$router.push('/crud/comentarios/create');
        },
        eliminarItem(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
                fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/comentarios/${id}`, {
                    method: 'DELETE',
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al eliminar comentario');
                    }
                    this.fetchData();
                })
                .catch(error => {
                    console.error(error);
                });
            }
        },
        editarItem(id) {
            this.$router.push(`/crud/comentarios/edit/${id}`);
        }
    },
    created() {
        this.fetchData();
    }
}
</script>

<style scoped></style>
