<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Coordenadas</th>
                    <th>Edad Min</th>
                    <th>Horario</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Crear</th>
                    <th>Delete</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="discoteca in data" :key="discoteca.id">
                    <td>{{ discoteca.id }}</td>
                    <td>{{ discoteca.coordenadas }}</td>
                    <td>{{ discoteca.minEdad }}</td>
                    <td>{{ discoteca.horario }}</td>
                    <td>{{ discoteca.nombre_local }}</td>
                    <td>{{ discoteca.telefono }}</td>
                    <td>{{ discoteca.descripcion }}</td>

                    <td>
                        <img :src="discoteca.imgUrl" alt="Profile Photo" class="img-fluid rounded-circle" />
                    </td>
                    <td><button class="btn btn-primary" @click="crearNuevoItem()">Crear</button></td>
                    <td><button class="btn btn-danger" @click="eliminarItem(discoteca.id)">Delete</button></td>
                    <td><button class="btn btn-warning" @click="editarItem(discoteca.id)">Editar</button></td>
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
            fetch('http://localhost:8000/api/discotecas')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching discoteca data');
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
            navigateTo('/crud/discotecas/create');
        },
        eliminarItem(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
                fetch(`http://localhost:8000/api/discotecas/${id}`, {
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
            this.$router.push(`/crud/discotecas/edit/${id}`);
        }

    },


    created() {
        this.fetchData();
    },



}
</script>

<style scoped>
img {
    width: 200px;
    height: 100px;
    object-fit: cover;

}
</style>
