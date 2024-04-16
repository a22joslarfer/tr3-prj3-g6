<template>
    <div class="custom-form-container">
        <form @submit.prevent="submitForm" class="custom-form">
            <input type="hidden" v-model="review_id" />
            <input type="hidden" v-model="disco_id" />

            <div class="form-group">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" v-model="titulo" placeholder="Ingrese el título" />
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Comentario</label>
                <textarea class="form-control" id="content" v-model="content"
                    placeholder="Ingrese su comentario"></textarea>
            </div>

            <div class="form-group">
                <label for="puntuacion" class="form-label">Valoración</label>
                <input type="number" class="form-control" id="puntuacion" v-model="puntuacion" min="0" max="5"
                    placeholder="Valoración del 0 al 5" />
            </div>

            <button type="submit" class="btn btn-primary">Editar</button>
        </form>
    </div>
</template>
  
  
<script>
export default {
    data() {
        return {
            review_id: null,
            disco_id: null,
            usuario_id: 1,
            titulo: "",
            content: "",
            puntuacion: 0,
        };
    },

    methods: {
        async submitForm() {
            try {
                const response = await fetch(
                    `http://localhost:8000/api/reviews/${this.review_id}`,
                    {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                        body: JSON.stringify({
                            usuario_id: this.usuario_id,
                            disco_id: this.disco_id,
                            titulo: this.titulo,
                            content: this.content,
                            puntuacion: this.puntuacion,
                        }),
                    }
                );
                const data = await response.json();
                console.log(data);
                navigateTo(`../crud_reviews`);
            } catch (error) {
                console.error(error);
            }
        },
    },
    created() {
        this.review_id = this.$route.params.id;
        this.disco_id = this.$route.params.disco_id;
    },
};
</script>
  
<style scoped>
.custom-form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.custom-form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.btn {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #007bff;
    color: #fff;
}

.btn:hover {
    background-color: #0056b3;
}
</style>