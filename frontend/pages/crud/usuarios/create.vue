<template>
    <div class="container mt-4">
        <form @submit.prevent="crearNuevoItem" class="mb-4">
            <div class="form-group">
                <label for="name">name</label>
                <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="text" v-model="email" class="form-control" id="Email" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="password">password</label>
                <input type="text" v-model="password" class="form-control" id="password" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="phone">phone</label>
                <input type="text" v-model="phone" class="form-control" id="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="birthday">birthday</label>
                <input type="text" v-model="birthday" class="form-control" id="birthday" placeholder="Enter birthday">
            </div>
            <div class="form-group">
                <label for="profile_photo">profile_photo</label>
                <input type="file" @change="handleFileChange" class="form-control" id="profile_photo" placeholder="Enter profile_photo">
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
            name: '',
            email: '',
            password: '',
            phone: '',
            birthday: '',
            profile_photo: ''
        }
    },
    methods: {
        crearNuevoItem() {
            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('phone', this.phone);
            formData.append('birthday', this.birthday);
            formData.append('profile_photo', this.profile_photo);

            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/register', {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error creating new user');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('New user created');
                    // Puedes hacer algo aquí después de crear el usuario, como redirigir a otra página
                })
                .catch(error => {
                    console.error('There was an error creating the new user', error);
                });
        }
    }
}
</script>

<style scoped></style>
