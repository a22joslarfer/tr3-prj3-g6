<template>
  <div class="user-profile">
    <HeaderPerfil />
    <div class="content">
      <h1>User Profile</h1>
      <div v-if="user" class="user-info">
        <div class="update-form">
          <label for="name">Usuario:</label>
          <input type="text" id="name" v-model="newName">
          <label for="email">Correo electrónico:</label>
          <input type="email" id="email" v-model="newEmail">
          <label for="phone">Teléfono:</label>
          <input type="text" id="phone" v-model="newPhone">
          <label for="birthday">Fecha de nacimiento:</label>
          <input type="date" id="birthday" v-model="newBirthday">
          <!-- contraseña anterior -->
          <label for="currentPassword">Contraseña actual:</label>
          <input type="password" id="currentPassword" v-model="currentPassword">
          <!-- nueva contraseña -->
          <label for="password">Nueva contraseña:</label>
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
import HeaderPerfil from '~/components/HeaderPerfil.vue';
import FooterOptions from '~/components/FooterOptions.vue';
import { useStore } from '../stores/index.js';

export default {
  components: {
    HeaderPerfil,
    FooterOptions
  },
  data() {
    return {
      newName: '',
      newEmail: '',
      user: null,
      userId: null,
      newPhone: '',
      newBirthday: '',
      newPassword: '',
      currentPassword: ''
    };
  },
  async mounted() {
    const store = useStore();
    this.user = store.return_user_info_register();
    this.newName = this.user.username;
    this.newEmail = this.user.email;
    this.userId = this.user.user_id;
    this.newPhone = this.user.phone;
    this.newBirthday = this.user.birthday;
  },
  methods: {
    async updateUser() {
      console.log('Updating user...');
      const store = useStore();
      const userId = this.user ? this.user.user_id : null;

      if (!this.currentPassword) {
        console.error('Debe proporcionar la contraseña actual.');
        return;
      }

      // Enviar los datos al backend
      try {
        const response = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${userId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            name: this.newName,
            email: this.newEmail,
            phone: this.newPhone,
            birthday: this.newBirthday,
            old_password: this.currentPassword, // Enviar la contraseña actual al backend
            new_password: this.newPassword // Enviar la nueva contraseña al backend
          })
        });
        const data = await response.json();
        console.log('Response from server:', data);
      } catch (error) {
        console.error('Error updating user:', error);
      }
    },
    checkIfAuth() {
      const store = useStore();
      const user_id = store.return_user_id();
      if (user_id == null) {
        store.set_return_path('/reviews');
        this.$router.push('/login');

      }
      this.client_id = user_id;

    },
  },
  created() {
    this.checkIfAuth();
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
  max-height: calc(100vh - 110px);
  /* Restar la altura del pie de página */
  overflow-y: auto;
  /* Permite el desplazamiento vertical */
}

h1 {
  font-size: 2rem;
  position: relative;
  top: -25px;
  margin-bottom: -11px;
}

.user-info {
  width: 100%;
  max-width: 600px;
  overflow-y: auto;
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