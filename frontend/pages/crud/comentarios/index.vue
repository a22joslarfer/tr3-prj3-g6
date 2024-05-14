<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>id inTime</th>
                    <th>id usuari</th>
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
                    <td>{{ comentario.hora }}</td>

                    <td><button class="btn btn-primary" @click="crearNuevoItem()">Crear</button></td>
                    <td><button class="btn btn-danger" @click="eliminarItem()">Delete</button></td>
                    <td><button class="btn btn-warning" @click="editarItem()">Editar</button></td>
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
            fetch('http://localhost:8000/api/comentarios')
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
        }
    },
    created() {
        this.fetchData();
    },
    crearNuevoItem() {
        console.log('Crear nuevo item');
    },
    eliminarItem() {
        console.log('Eliminar item');
    },
    editarItem() {
        console.log('Editar item');
    }

}
</script>

<style scoped></style>
