<template>
    <div class="custom-form-container">
        <form @submit.prevent="submitForm" class="custom-form">

            <div class="form-group">
                <label for="nombre_local">Nombre del local</label>
                <input type="text" class="form-control" id="nombre_local" v-model="nombre_local">
            </div>

            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" class="form-control" id="telefono" v-model="telefono">
            </div>

            <div class="form-group">
                <label for="horario">Horario</label>
                <input type="date" class="form-control" id="horario" v-model="horario">
            </div>

            <div class="form-group">
                <label for="coordenadas">Coordenadas</label>
                <input type="text" class="form-control" id="coordenadas" v-model="coordenadas">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" v-model="descripcion">
            </div>

            <div class="form-group">
                <label for="imgUrl">imgUrl</label>
                <input type="text" class="form-control" id="imgUrl" v-model="imgUrl">
            </div>

            <button type="submit" class="btn btn-primary" @click="editar">Submit</button>

        </form>
    </div>
</template>
  

  

<script>
export default {
    data() {
        return {
            disco_id: null,
            nombre_local: '',
            telefono: '',
            horario: '',
            coordenadas: '',
            descripcion: '',
            imgUrl: ''

        };
    },

    methods: {
        async editar() {
            try {
                const response = await fetch(`http://localhost:8000/api/discotecas/${this.disco_id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        nombre_local: this.nombre_local,
                        telefono: this.telefono,
                        horario: this.horario,
                        coordenadas: this.coordenadas,
                        descripcion: this.descripcion,
                        imgUrl: this.imgUrl
                    }),
                });
                const data = await response.json();
                console.log(data);
                navigateTo('/CRUD/LOCALES/crud_discotecas');
            } catch (error) {
                console.error(error);
            }
        }
    },
    created() {
        this.disco_id = this.$route.params.id;
    }
}
</script>

<style scoped>

*{
    font-size: 25px;
}
.custom-form-container {
    max-width: 700px;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    /* Ensures the form is centered vertically */
    background-color: #3b85d3e1;
}

.custom-form {
    padding: 15px;
    min-width: 600px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    
}

input {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

.coord-group {
    display: flex;
    justify-content: space-between;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>