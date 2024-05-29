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
                    <td><button class="btn btn-danger" @click="eliminarItem(user.id)">Delete</button></td>
                    <td><button class="btn btn-warning" @click="editarItem(user.id)">Editar</button></td>
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
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/users')
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
                })
                .finally(() => {
                    this.loading = false; // Desactivar pantalla de carga al finalizar
                });
        },
        crearNuevoItem() {
            navigateTo('/crud/usuarios/create');
        },
        eliminarItem(id) {
            //id del usuario a eliminar
            console.log('Eliminar item');
            console.log(id);
            fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${id}`, {
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
                    console.error(error);
                });

            //pantalla de carga


        },
        editarItem(id) {
            navigateTo(`/crud/usuarios/edit/${id}`);
        },
        checkIfAdmin() {

        }
    },
    created() {
        this.fetchData();
    },


}
</script>

<style scoped></style>
