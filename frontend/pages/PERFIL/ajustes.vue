<template>
  <div class="container">
    <HeaderPerfil :pageTitle="pageTitle" />

    <h1 class="title">Editar perfil</h1>

    <form class="form" @submit.prevent="submitForm">

      <div class="input">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" class="user_info" v-model="username">
      </div>

      <div class="input">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" class="user_info" v-model="email" >
      </div>
      
     
      <button type="submit" class="button">Guardar cambios</button>

    </form>

    <FooterOptions />
  </div>
</template>

<script>
import { useStore } from '@/stores/index.js';

export default {
  data() {
    return {
      username: '',
      email: '',
      pageTitle: 'Ajustes de perfil'
    }
  },
  created() {
    const store = useStore();
    const userInfo = store.return_user_info(); // Obtén los datos del usuario desde tu tienda Pinia

    // Asigna los valores de usuario y correo electrónico a las variables locales
    this.username = userInfo.username;
    this.email = userInfo.email;
  },
  methods: {
    submitForm() {
      const store = useStore();
      const userId = store.return_user_id(); // Obtén el ID del usuario desde tu tienda Pinia

      // Envía los datos al servidor (API) para actualizar la base de datos
      fetch(`http://localhost:8000/users/${userId}`, {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`
    },
    body: JSON.stringify({
        username: this.username,
        email: this.email
    }),
})
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al actualizar usuario: ${response.status} - ${response.statusText}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('Usuario actualizado:', data);
        alert('Cambios guardados exitosamente');
      })
      .catch(error => {
        console.error('Error al actualizar usuario:', error);
        alert('Error al guardar cambios. Por favor, inténtalo de nuevo.');
      });
    }
  }
}
</script>

<style scoped>
.user_info {
  margin-top: 10px;
}

.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.title {
  font-size: 24px;
  margin-bottom: 20px;
}

.form {
  display: flex;
  flex-direction: column;
}

.input {
  margin-bottom: 10px;
  padding: 10px;
  font-size: 16px;
  display: grid;
  grid-template-columns: max-content;
}

.button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
}

.button:hover {
  background-color: #0056b3;
}
</style>
