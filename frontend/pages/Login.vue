<template>
  <div>
    <HeaderGeneral />

    <div class="container">
      <img src="https://static.vecteezy.com/system/resources/previews/029/938/250/non_2x/planet-earth-globe-world-map-ai-generative-free-png.png" alt="Logo de la empresa" class="company-logo">

      <div class="title_company">BIENVENIDO A VIAEGIS</div>
      

      <div class="content">
        <div class="login-link">
        ¿Aún no tienes cuenta? <nuxt-link to="/register" class="boton_login">¡Regístrate!</nuxt-link>
      </div>
        <div class="title">Iniciar Sesión</div>
        <form @submit.prevent="login" class="form">
          <div class="input-group">
            <input type="text" v-model.trim="email" class="input" placeholder="Correo Electrónico" required />
          </div>
          <div class="input-group">
            <input type="password" v-model.trim="password" class="input" placeholder="Contraseña" required />
          </div>
          <button type="submit" class="button">Iniciar Sesión</button>
        </form>
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
          console.log('Sesión iniciada correctamente:', data);
          localStorage.setItem('token', data.token);
          const store = useStore();
          store.save_user_info(data.name, data.email, data.id);
          console.log('Usuari:', store.return_user_username());
          console.log('Email:', store.return_user_email());
          console.log('Id:', store.return_user_id());
          this.$router.push('/');
        })
        .catch(error => {
          console.error('Error al iniciar sesión:', error);
        });

    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Antonio:wght@100..700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,100..900;1,100..900&display=swap');

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #eff4f3;
  position: relative;
}

.content {
  width: 300px;
  margin-top: -66%;
  margin-left: auto;
  margin-right: auto;
  position: relative;
}

.title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
  font-family: "Antonio", sans-serif;
}

.title_company {
  font-family: "Anybody", sans-serif;
  font-optical-sizing: auto;
  font-weight: 800;
  font-style: normal;
  position: absolute;
  font-size: 20px;
  top: 15%;
}

.company-logo {
  max-width: 100px;
  width: 80px;
  position: absolute;
  top: 5%;
}

.form {
  width: 100%;
}

.input-group {
  margin-bottom: 20px;
}

.input {
  width: 100%;
  height: 40px;
  border: 1px solid rgb(101, 101, 105);
  border-radius: 12px;
  font-size: 16px;
  padding: 10px;
}

.input:focus {
  border: 2px solid #f3634d;
  outline: none;
}

.button {
  width: 100%;
  height: 50px;
  border: none;
  border-radius: 25px;
  background-color: #ff806d;
  color: white;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
}

.login-link {
  text-align: center;
  font-size: 16px;
  color: #333;
  margin-bottom: 32%;
    margin-top: 60px;
}

.login-link a {
  color: #053cf1;
  text-decoration: none;
}

.login-link a:hover {
  text-decoration: underline;
  color: #062897;
}
</style>