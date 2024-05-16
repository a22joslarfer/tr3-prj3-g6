<template>
    <div class="container mt-4">
        <form @submit.prevent="actualizarReview" class="mb-4">
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
                <input type="text" v-model="titulo" class="form-control" id="titulo" placeholder="Enter user ID">
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

            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
</template>






<script>
import 'bootstrap/dist/css/bootstrap.css'

export default {
    data() {
        return {
        
            usuario_id: '',
            disco_id: '',
            titulo: '',
            puntuacion: '',
            content: '',
            photo: '',
            id: null
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
        actualizarReview() {
            let formData = new FormData();
            formData.append('usuario_id', this.usuario_id);
            formData.append('disco_id', this.disco_id);
            formData.append('titulo', this.titulo);
            formData.append('puntuacion', this.puntuacion);
            formData.append('content', this.content);
            formData.append('photo', this.photo);
            console.log(formData);
            //id review
            console.log('ID de review:', this.$route.params.id);
            console.log('usuario_id:', this.usuario_id);
            console.log('disco_id:', this.disco_id);
            console.log('titulo:', this.titulo);
            console.log('puntuacion:', this.puntuacion);
            console.log('content:', this.content);

            fetch(`http://localhost:8000/api/reviews/${this.$route.params.id}`, {
                method: 'PUT',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error creating new item');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('New item created');
                    this.$router.push('/crud/reviews');
                })
                .catch(error => {
                    console.error('There was an error creating the new item', error);
                });
        },


      
    },
      

}
</script>

<style scoped></style>
