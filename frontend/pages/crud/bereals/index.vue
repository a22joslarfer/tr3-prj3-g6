<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Img Delantera</th>
                    <th>Img Trasera</th>
                    <th>Id Usuari</th>
                    <th>Hora</th>
                    <th>Create</th>
                    <th>Delete</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(inTime, index) in data" :key="inTime.id">
                    <td>{{ inTime.id }}</td>
                    <td>{{ inTime.img_del }}</td>
                    <td>{{ inTime.img_tra }}</td>
                    <td>{{ inTime.id_usuari }}</td>
                    <td>{{ inTime.hora }}</td>

                    <td><button class="btn btn-primary" @click="crearNuevoItem()">Crear</button></td>
                    <td><button class="btn btn-danger" @click="eliminarItem(inTime.id)">Delete</button></td>
                    <td><button class="btn btn-warning" @click="editarItem(inTime.id)">Editar</button></td>
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
            fetch('http://localhost:8000/api/inTimes')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching inTime data');
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
            navigateTo('/crud/bereals/create');
        },
        eliminarItem(id) {
            fetch(`http://localhost:8000/api/inTime/${id}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error deleting item');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Item deleted');
                    this.fetchData();
                })
                .catch(error => {
                    console.error('There was an error deleting the item', error);
                });
        },
        editarItem(id) {
            navigateTo(`/crud/bereals/edit/${id}`);
        }
    },
    created() {
        this.fetchData();
    },

}
</script>

<style scoped></style>
