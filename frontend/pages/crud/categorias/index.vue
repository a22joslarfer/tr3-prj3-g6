<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Crear</th>
                    <th>Eliminar</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(categoria, index) in data" :key="categoria.id">
                    <td>{{ categoria.id }}</td>
                    <td>{{ categoria.nombre }}</td>
                    <td><button class="btn btn-primary" @click="crearNuevoItem()">Crear</button></td>
                    <td><button class="btn btn-danger" @click="eliminarItem(categoria.id)">Eliminar</button></td>
                    <td><button class="btn btn-warning" @click="editarItem(categoria.id)">Editar</button></td>
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
        }
    },
    methods: {
        fetchData() {
            fetch('http://localhost:8000/api/categorias_reviews')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching categoria data');
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
            this.$router.push('/crud/categorias/create');
        },
        eliminarItem(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
                fetch(`http://localhost:8000/api/categorias_reviews/${id}`, {
                    method: 'DELETE',
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al crear categoria');
                    }
                    this.fetchData();
                })
                .catch(error => {
                    console.error(error);
                });
            }
        },
        editarItem(id) {
            this.$router.push(`/crud/categorias/edit/${id}`);
        }
    },
    created() {
        this.fetchData();
    },
}
</script>

