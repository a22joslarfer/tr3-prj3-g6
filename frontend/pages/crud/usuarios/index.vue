<template>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Birthday</th>
                    <th>Profile Photo</th>
                    <th>Crear</th>
                    <th>Delete</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.birthday }}</td>
                    <td>
                        <img :src="user.profile_photo" alt="Profile Photo" class="img-fluid rounded-circle" />
                    </td>
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
            fetch('http://localhost:8000/api/users')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching user data');
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
