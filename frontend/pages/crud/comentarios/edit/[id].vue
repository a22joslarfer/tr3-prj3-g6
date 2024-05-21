<template>
    <div class="container mt-4">
        <h2>Editar Comentario</h2>
        <form @submit.prevent="actualizarComentario">
            <div class="form-group">
                <label for="comentario">Comentario:</label>
                <input type="text" class="form-control" id="comentario" v-model="comentario" required>
            </div>
            <div class="form-group">
                <label for="id_bereal">ID Bereal:</label>
                <input type="number" class="form-control" id="id_bereal" v-model="id_bereal" required>
            </div>
            <div class="form-group">
                <label for="id_usuari">ID Usuario:</label>
                <input type="number" class="form-control" id="id_usuari" v-model="id_usuari" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
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
            comentario: '',
            id_bereal: '',
            id_usuari: '',
            
        }
    },
    methods: {
        obtenerComentario() {
            
            fetch(`http://localhost:8000/api/comentarios/${this.$route.params.id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch comentario');
                    }
                    return response.json();
                })
                .then(data => {
                    this.comentario = data.comentario;
                    this.id_bereal = data.id_bereal;
                    this.id_usuari = data.id_usuari;
                    this.id = data.id;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        actualizarComentario() {
            fetch(`http://localhost:8000/api/comentarios/${this.$route.params.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    comentario: this.comentario,
                    id_bereal: this.id_bereal,
                    id_usuari: this.id_usuari,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update comentario');
                }
                this.$router.push('/crud/comentarios/');
            })
            .catch(error => {
                console.error(error);
            });
        }
    },
    created() {
        this.obtenerComentario();
    }
}
</script>
