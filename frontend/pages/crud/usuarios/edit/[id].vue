<template>
    <div class="container mt-4">
        <form @submit.prevent="actualizarUsuario" class="mb-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" v-model="email" class="form-control" id="email" placeholder="Enter email">
            </div>
           
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" v-model="phone" class="form-control" id="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="text" v-model="birthday" class="form-control" id="birthday" placeholder="Enter birthday">
            </div>
           
            <button type="submit" class="btn btn-primary mt-2">Update</button>
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
            phone: '',
            birthday: '',
            id: null
        }
    },
    methods: {
        async actualizarUsuario() {
            console.log('Actualizando usuario...');
            console.log('ID de usuario:', this.id);
            console.log('Nombre:', this.name);
            console.log('Email:', this.email);
            console.log('Teléfono:', this.phone);
            console.log('Fecha de nacimiento:', this.birthday);
            
            try {
                const response = await fetch(`http://localhost:8000/api/update/users/${this.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: this.name,
                        email: this.email,
                        phone: this.phone,
                        birthday: this.birthday
                    })
                });
                
                if (!response.ok) {
                    throw new Error('Error updating user');
                }
                
                const data = await response.json();
                console.log('User updated successfully:', data);
            } catch (error) {
                console.error('Error updating user:', error);
            }
        }
    },
    created() {
        // Aquí obtienes el ID de las propiedades de ruta de Vue Router
        this.id = this.$route.params.id;
        console.log('ID de usuario obtenido:', this.id);
        
    }
}
</script>

<style scoped></style>
