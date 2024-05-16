<template>
    <div class="container mt-4">
        <form @submit.prevent="crearNuevoItem" class="mb-4">
            <div class="form-group">
                <label for="usuario_id">usuario_id</label>
                <input type="text" v-model="usuario_id" class="form-control" id="usuario_id"
                    placeholder="Enter front image URL">
            </div>
            <div class="form-group">
                <label for="disco_id">disco_id</label>
                <input type="text" v-model="disco_id" class="form-control" id="disco_id"
                    placeholder="Enter rear image URL">
            </div>
            <div class="form-group">
                <label for="titulo">titulo</label>
                <input type="text" v-model="titulo" class="form-control" id="titulo"
                    placeholder="Enter user ID">
            </div>
            <div class="form-group">
                <label for="content">content</label>
                <input type="text" v-model="content" class="form-control" id="content" placeholder="Enter time">
            </div>
            <div class="form-group">
                <label for="puntuacion">puntuacion</label>
                <input type="text" v-model="puntuacion" class="form-control" id="puntuacion"
                    placeholder="Enter user ID">
            </div>
            <div class="form-group">
                <label for="photo">photo</label>
                <input type="file" @change="handleFileChange" class="form-control" id="photo" placeholder="Enter time">
            </div>
            <div class="form-group">
                <label for="categoria">categoria</label>
                <input type="text" v-model="categoria" class="form-control" id="categoria" placeholder="Enter time">
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
           categoria: '',
              usuario_id: '',
                disco_id: '',
                titulo: '',
                puntuacion: '',
                content: '',
                photo: '',

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
        crearNuevoItem() {
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    categoria: this.categoria,
                    usuario_id: this.usuario_id,
                    disco_id: this.disco_id,
                    titulo: this.titulo,
                    puntuacion: this.puntuacion,
                    content: this.content,
                    photo: this.photo
                   
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error creating new item');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('New review created');
                    this.$router.push('/crud/reviews');
                })
                .catch(error => {
                    console.error('There was an error creating the new item', error);
                });
        }
    }

}
</script>

<style scoped></style>
