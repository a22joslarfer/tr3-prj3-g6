<template>
  <HeaderGeneral />

  <div class="login-container">

    <div class="content">
      <div class="company-info">
        <img
          src="https://static.vecteezy.com/system/resources/previews/029/938/250/non_2x/planet-earth-globe-world-map-ai-generative-free-png.png"
          alt="Logo de la empresa" class="company-logo">
        <div class="title_company">BIENVENIDO A VIAEGIS</div>
      </div>

      <div class="login-form">
        <div class="login-link">
          ¿Aún no tienes cuenta? <nuxt-link to="/register" class="boton_login">¡Regístrate!</nuxt-link>
        </div>
        <form @submit.prevent="login" class="form">
          <div class="input-group">
            <input type="text" v-model.trim="email" class="input" placeholder="Correo Electrónico" required />
          </div>
          <div class="input-group">
            <input type="password" v-model.trim="password" class="input" placeholder="Contraseña" required />
          </div>
          <button type="submit" class="button">Iniciar Sesión</button>
        </form>
        <div class="sc-18d118e1-0 gjmkph">
          <hr class="sc-1a86d6e9-0 doHtqb"><span class="sc-7b9b9acb-0 bMZrBT">or</span>
          <hr class="sc-1a86d6e9-0 doHtqb">
        </div>
        <div>
    <button id="signinButton" class="google-signin-button">
      <img src="../public/google_icon.png" alt="Google Logo" class="google-logo"> Iniciar sesión con Google
    </button>
  </div>
      </div>
    </div>

    <FooterOptions />
  </div>
</template>

<script>
import { useStore } from '../stores/index.js';
export default {
  data() {
    return {
      email: '',
      password: '',

    };
  },
  methods: {
    login() {
      fetch('http://localhost:8000/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: this.email.trim(),
          password: this.password.trim(),

        }),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error al iniciar sesión: ${response.status} - ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Success:', data);

          if (data.status === 1) {
            localStorage.setItem('authToken', data.access_token);
            console.log(data.access_token);
            navigateTo('/');
          } else {
            alert('Inicio de sesión fallido. Verifica tus credenciales.');
          }
        })
        .catch(error => {
          console.error('Error al iniciar sesión:', error);
        });

    },
  },
  }

</script>

<style scoped>

</style>