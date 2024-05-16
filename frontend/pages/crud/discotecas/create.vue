<template>
    <div class="container mt-4">
        <form @submit.prevent="crearNuevoItem" class="mb-4">


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
                descripcion: '',
                imgUrl: ''
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
