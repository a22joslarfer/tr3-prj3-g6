<template>
    <div class="container mt-4">
        <h2>Editar Categoría</h2>
        <form @submit.prevent="actualizarCategoria">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" v-model="nombre" required>
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
            nombre: '',
            id: null,
        }
    },
    methods: {
        obtenerCategoria() {
            const id = this.$route.params.id;
            fetch(`http://localhost:8000/api/categorias_reviews/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch categoria');
                    }
                    return response.json();
                })
                .then(data => {
                    this.nombre = data.nombre;
                    this.id = data.id;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        actualizarCategoria() {
            fetch(`http://localhost:8000/api/categorias_reviews/${this.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    nombre: this.nombre,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update categoria');
                }
                this.$router.push('/crud/categorias/');
            })
            .catch(error => {
                console.error(error);
            });
        }
    },
    created() {
        this.obtenerCategoria();
    }
}
</script>

