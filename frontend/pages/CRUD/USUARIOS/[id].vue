<template>
    <div class="custom-form-container">
        <form @submit.prevent="submitForm" class="custom-form">

            <div class="form-group">
                <label for="nombre">Nombre del usuario</label>
                <input type="text" class="form-control" id="nombre" v-model="nombre">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" v-model="phone">
            </div>

            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" v-model="birthdate">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" v-model="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="password" v-model="password">
            </div>

            <div class="form-group">
                <label for="password2">Torn a posar la contrasenya</label>
                <input type="text" class="form-control" id="password2" v-model="password2">
            </div>

            <button type="submit" class="btn btn-primary" @click="editar">Submit</button>

        </form>
    </div>
</template>
  

  

<script>
export default {
    data() {
        return {
            user_id: null,
            nombre: '',
            phone: '',
            birthdate: '',
            email: '',
            password: '',
            password2: '',
        };
    },

    methods: {
        async editar() {
            try {
                const response = await fetch(`http://localhost:8000/api/users/${this.user_id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        nombre: this.nombre,
                        phone: this.phone,
                        birthdate: this.birthdate,
                        email: this.email,
                        password: this.password,
                        password2: this.password2,
                    }),
                });
                const data = await response.json();
                console.log(data);
                navigateTo('/CRUD/USUARIOS/crud_usuarios');
            } catch (error) {
                console.error(error);
            }
        }
    },
    created() {
        this.user_id = this.$route.params.id;
    }
}
</script>

<style scoped>
* {
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