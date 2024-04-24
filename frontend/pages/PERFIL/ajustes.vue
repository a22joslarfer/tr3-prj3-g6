<template>
    <div class="container">
      <HeaderPerfil :pageTitle="pageTitle" />
  
      <h1 class="title">Editar perfil</h1>
  
      <form class="form" @submit.prevent="submitForm">
  
        <div class="input">
          <label for="username">Nombre de usuario:</label>
          <input type="text" id="username" class="user_info" v-model="username" placeholder="HugoTripiana03">
        </div>
  
        <div class="input">
          <label for="email">Correo electrónico:</label>
          <input type="email" id="email" class="user_info" v-model="email" placeholder="hugo@gmail.com">
        </div>
        
        <div class="input">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" class="user_info" v-model="password" placeholder="********">
        </div>
  
        <div class="input">
          <label for="birthdate">Fecha de nacimiento:</label>
          <input type="date" id="birthdate" class="user_info" v-model="birthdate">
        </div>
  
        <div class="input">
          <label for="phone">Número de teléfono:</label>
          <input type="tel" id="phone" class="user_info" v-model="phone" placeholder="123456789">
        </div>
  
        <button type="submit" class="button">Guardar cambios</button>
  
      </form>
  
      <FooterOptions />
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        pageTitle: 'Configuración de Perfil',
        username: '',
        email: '',
        password: '',
        birthdate: '',
        phone: '',
        // Agrega más datos de configuración según sea necesario
      }
    },
    methods: {
      submitForm() {
        console.log('Datos del formulario:', this.username, this.email);
        alert('Cambios guardados exitosamente');
      }
    }
  }
  </script>
  
  <style scoped>
  .user_info{
    margin-top:10px;
    
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
  