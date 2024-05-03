<template>
  <HeaderPerfil />
  <div>
    <h1>User Profile</h1>
    <div v-if="user">
      <p><strong>Name:</strong> {{ user.username }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>ID:</strong> {{ user.user_id }}</p>
      <label for="name">New Name:</label>
      <input type="text" id="name" v-model="newName">
      <label for="email">New Email:</label>
      <input type="email" id="email" v-model="newEmail">
      <button @click="updateUser">Update</button>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>
  </div>
  <FooterOptions />
</template>

<script>
import FooterOptions from '~/components/FooterOptions.vue';
import { useStore } from '../stores/index.js';

export default {
  data() {
    return {
      newName: '',
      newEmail: '',
      user: null,
      userId: null
    };
  },
  async mounted() {
    const store = useStore();
    this.user = store.return_user_info();
    console.log('User data:', this.user);
    this.newName = this.user.username;
    this.newEmail = this.user.email;
  },
  methods: {
    async updateUser() {
      console.log('Updating user...');
      const store = useStore();
      // Actualizar el usuario en el store
      store.save_user_info(this.newName, this.newEmail);
      console.log('New user data:', store.return_user_info());

      // Lógica para enviar la actualización al backend
      this.sendUpdateToBackend();
    },
    async sendUpdateToBackend() {
console.log('Sending update to backend...');

const store = useStore();
const userId = this.user ? this.user.user_id : null;// Obtener el ID del usuario

if (userId) { // Verificar si userId es null o no
  try {
    const response = await fetch(`http://localhost:8000/api/users/${userId}`, {
      method: 'PUT', // Utilizar el método PUT para actualizar el usuario
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        name: this.newName, // Enviar el nuevo nombre
        email: this.newEmail // Enviar el nuevo email
      })
    });
    const data = await response.json();
    console.log('Response from server:', data);
  } catch (error) {
    console.error('Error updating user:', error);
  }
} else {
  console.error('User ID is null. Cannot send update request.');
}
}
  }
};
</script>

<style scoped>
h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}
input {
  margin-bottom: 1rem;
}
button {
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
</style>
