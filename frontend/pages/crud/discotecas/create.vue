<template>
    <div class="container mt-4">
        <form @submit.prevent="crearNuevoItem" class="mb-4">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="lat">Latitude</label>
                        <input type="number" step="any" class="form-control" id="lat" v-model="nuevoItem.lat" required>
                    </div>
                    <div class="form-group">
                        <label for="minEdad">Minimum Age</label>
                        <input type="number" class="form-control" id="minEdad" v-model="nuevoItem.minEdad" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lng">Longitude</label>
                        <input type="number" step="any" class="form-control" id="lng" v-model="nuevoItem.lng" required>
                    </div>
                    <div class="form-group">
                        <label for="horario">Schedule</label>
                        <input type="text" class="form-control" id="horario" v-model="nuevoItem.horario" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_local">Name</label>
                        <input type="text" class="form-control" id="nombre_local" v-model="nuevoItem.nombre_local"
                            required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="telefono">Phone Number</label>
                <input type="tel" class="form-control" id="telefono" v-model="nuevoItem.telefono" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Description</label>
                <textarea class="form-control" id="descripcion" rows="3" v-model="nuevoItem.descripcion"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
</template>







<script>
import 'bootstrap/dist/css/bootstrap.css'

export default {
    data() {
        return {

            nuevoItem: {
                lat: null,
                lng: null,
                minEdad: '',
                horario: '',
                nombre_local: '',
                telefono: '',
                descripcion: ''
            }

        };

    },
    head() {
        return {
            link: [
                { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css' }
            ]
        }
    },
    methods: {
        crearNuevoItem() {
            console.log(this.nuevoItem)
            fetch('http://localhost:8000/api/discotecas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    lat: this.nuevoItem.lat,
                    lng: this.nuevoItem.lng,
                    minEdad: this.nuevoItem.minEdad,
                    horario: this.nuevoItem.horario,
                    nombre_local: this.nuevoItem.nombre_local,
                    telefono: this.nuevoItem.telefono,
                    descripcion: this.nuevoItem.descripcion
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error creating new item');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('New item created');
                    this.$router.push('/crud/discotecas');
                })
                .catch(error => {
                    console.error('There was an error creating the new item', error);
                });
        }
    }

}
</script>

<style scoped></style>
