<template>
    <div class="container mt-4">
        <h2>Crear Nova Categoría</h2>
        <form @submit.prevent="crearCategoria">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" v-model="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
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
            nombre: '',
        }
    },
    methods: {
        crearCategoria() {
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/categorias_reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    nombre: this.nombre,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to create categoria');
                }
                this.$router.push('/crud/categorias/');
            })
            .catch(error => {
                console.error(error);
            });
        }
    }
}
</script>

