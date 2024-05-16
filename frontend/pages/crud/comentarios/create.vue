<template>
    <div class="container mt-4">
        <h2>Crear Nuevo Comentario</h2>
        <form @submit.prevent="crearNuevoComentario" class="mb-4">
            <div class="form-group">
                <label for="comentario">Comentario</label>
                <input type="text" v-model="comentario" class="form-control" id="comentario"
                    placeholder="Introduce el comentario">
            </div>
            <div class="form-group">
                <label for="id_bereal">ID Bereal</label>
                <input type="number" v-model="id_bereal" class="form-control" id="id_bereal"
                    placeholder="Introduce el ID Bereal">
            </div>
            <div class="form-group">
                <label for="id_usuari">ID Usuario</label>
                <input type="number" v-model="id_usuari" class="form-control" id="id_usuari"
                    placeholder="Introduce el ID Usuario">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Crear</button>
        </form>
    </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css'

export default {
    data() {
        return {
            comentario: '',
            id_bereal: '',
            id_usuari: '',
        }
    },
    methods: {
        crearNuevoComentario() {
            fetch('http://localhost:8000/api/comentarios', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    comentario: this.comentario,
                    id_bereal: this.id_bereal,
                    id_usuari: this.id_usuari
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al crear el comentario');
                    }
                    console.log('Comentario creado exitosamente');
                    this.$router.push('/crud/comentarios');
                })
                .catch(error => {
                    console.error('Hubo un error al crear el comentario', error);
                });
        }
    }
}
</script>

