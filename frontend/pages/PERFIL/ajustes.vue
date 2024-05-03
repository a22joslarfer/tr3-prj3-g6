<template>
  <div class="user-profile">
    <HeaderPerfil />
    <div class="content">
      <h1>User Profile</h1>
      <div v-if="user" class="user-info">
        <div class="update-form">
          <label for="name">Usuario:</label>
          <input type="text" id="name" v-model="newName">
          <label for="email">Correo electronico:</label>
          <input type="email" id="email" v-model="newEmail">
          <label for="phone">Teléfono:</label>
          <input type="text" id="phone" v-model="newPhone">
          <label for="birthday">Fecha de nacimiento:</label>
          <input type="date" id="birthday" v-model="newBirthday">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" v-model="newPassword">
          <button @click="updateUser">Actualizar datos</button>
        </div>
      </div>
      <div v-else>
        <p>Loading...</p>
      </div>
    </div>
    <FooterOptions />
  </div>
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
      userId: null,
      newPhone: '',
      newBirthday: '',
      newPassword: ''
    };
  },
  async mounted() {
    const store = useStore();
    this.user = store.return_user_info_register();
    console.log('User data:', this.user);
    this.newName = this.user.username;
    this.newEmail = this.user.email;
    this.userId = this.user.user_id;
    this.newPhone = this.user.phone;
    this.newBirthday = this.user.birthday;
    this.newPassword = this.user.password;
  },
  methods: {
    async updateUser() {
      console.log('Updating user...');
      const store = useStore();
      // Actualizar el usuario en el store
      store.save_user_info_register(this.newName, this.newEmail, this.userId, this.newPhone, this.newBirthday, this.newPassword);
      console.log('New user data:', store.return_user_info_register());

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
              email: this.newEmail, // Enviar el nuevo email
              password: this.newPassword, // Enviar la nueva contraseña
              phone: this.newPhone,
              birthday: this.newBirthday
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
.user-profile {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: aliceblue;
}

.content {
  flex: 1;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  max-height: calc(100vh - 110px); /* Restar la altura del pie de página */
  overflow-y: auto; /* Permite el desplazamiento vertical */
}

h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.user-info {
  width: 100%;
  max-width: 600px;
  overflow-y: auto  ;
}

.user-info-item {
  margin-bottom: 10px;
}

.update-form {
  width: 100%;
  max-width: 400px;
  margin-top: 20px;
  background-color: #ffffff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.update-form h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.update-form label {
  display: block;
  margin-bottom: 5px;
}

.update-form input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.update-form button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  
}

.update-form button:hover {
  background-color: #0056b3;
}
</style>