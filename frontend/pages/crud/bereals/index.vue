<template>
    <div class="container mt-4">
        <!-- Agrega un formulario para cambiar la hora de notificación -->
        <form @submit.prevent="guardarNuevaHora">
            <label for="nueva-hora">Nueva hora de notificación:</label>
            <input type="time" id="nueva-hora" v-model="nuevaHoraNotificacion">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

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
    <FooterOptions />
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
            nuevaHoraNotificacion: '', // Agrega una variable para almacenar la nueva hora de notificación
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
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/inTimes')
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
            navigateTo('/crud/inTimes/create');
        },
        eliminarItem(id) {
            fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/inTime/${id}`, {
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
            navigateTo(`/crud/inTimes/edit/${id}`);
        },
        guardarNuevaHora() {
            const store = useStore();
            store.guardarNuevaHora(this.nuevaHoraNotificacion);

            alert('Nueva hora de notificación guardada correctamente.');
        },
    },
    created() {
        this.fetchData();
    },

}
</script>

<style scoped></style>
