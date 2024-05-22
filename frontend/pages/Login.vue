<template>
  <HeaderGeneral />

  <div class="login-container">

    <div class="content">
      <div class="company-info">
        <img
          src="https://static.vecteezy.com/system/resources/previews/029/938/250/non_2x/planet-earth-globe-world-map-ai-generative-free-png.png"
          alt="Logo de la empresa" class="company-logo">
        <div class="title_company">BIENVENIDO A ELYSIUM</div>
      </div>

      <div class="login-form">
        <div class="login-link">
          ¿Aún no tienes cuenta? <nuxt-link to="/register" class="boton_login">¡Regístrate!</nuxt-link>
        </div>
        <form @submit.prevent="login" class="form">
          <div class="input-group">
            <input type="text" v-model="email" class="input" placeholder="Correo Electrónico" required />
            <!-- mensaje de error -->
            <span v-if="!validEmail" class="error-message">Por favor, introduce un correo electrónico válido.</span>
          </div>
          <div class="input-group">
            <input type="password" v-model="password" class="input" placeholder="Contraseña" required />
            <!-- mensaje de error -->
            <span v-if="password.length < 8" class="error-message">La contraseña debe tener al menos 8 caracteres.</span>
          </div>
          <button type="submit" class="button">Iniciar Sesión</button>
        </form>

      </div>
    </div>

    <FooterOptions />
  </div>
</template>

<script>

import { useStore } from '../stores/index'

export default {
  data() {
    return {
      email: '',
      password: '',

    };
  },
  methods: {
    login() {
      fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: this.email,
          password: this.password,

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

          const store = useStore();
          store.save_user_info(data.name, data.email, data.id);

          if (data.rol === 'admin') {
            store.set_user_rol('admin');
          }

          navigateTo('/');


        })
        .catch(error => {
          console.error('Error al iniciar sesión:', error);
        });

    },
  },
  computed: {
    validEmail() {
      return this.email.includes('@');
    },
  },
}

</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Antonio:wght@100..700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,100..900;1,100..900&display=swap');

.login-container {
  display: flex;
  min-height: 100vh;
  background-color: #eff4f3;

}

.content {
  width: 100%;
  max-width: 600px;
  /* Controla el ancho máximo del contenido */
  padding: 20px;
}

.company-info {
  text-align: center;
  margin-bottom: 15px;
}

.company-logo {
  max-width: 100px;
  width: 80px;
}

.title_company {
  font-family: "Anybody", sans-serif;
  font-optical-sizing: auto;
  font-weight: 800;
  font-style: normal;
  font-size: 20px;
}

.login-form {
  text-align: center;
}

.title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 20px;
}

.form {
  width: 100%;
  margin-top: 50px;
}

.input-group {
  margin-bottom: 20px;
}

.input {
  width: 100%;
  height: 8vh;
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
  width: 47%;
  height: 50px;
  border: none;
  border-radius: 25px;
  background-color: #ff806d;
  color: white;
  font-size: 18px;
}

.login-link {
  font-size: 16px;
  color: #333;
  margin-bottom: 20px;
}

.login-link a {
  color: #f1693f;
  text-decoration: underline;
}

.login-link a:hover {
  text-decoration: underline;
  color: #a34427;
}

.gjmkph {
  display: flex;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
}

.doHtqb {
  border-top: 0.5px solid rgb(205, 214, 223);
  border-bottom: 0.5px solid rgb(205, 214, 223);
  width: 64px;
}

.bMZrBT {
  display: block;
  text-transform: uppercase;
  margin: 0px 12px;
  color: rgb(105, 119, 134);
  padding: 24px 12px;
  font-size: 0.75rem;
  letter-spacing: 0px;
  line-height: 1.5;
  font-weight: 600;
}

.google-logo {
  width: 20px;
  margin-right: 10px;
}

.google-signin-button {
  border-radius: 25px;
  padding: 10px 20px;
  font-size: 16px;

}
.error-message {
  color: red;
  font-size: 14px;
  margin-top: 5px;
}
/* media query ordenador para ponerlo en el centro */
@media (min-width: 768px) {
  .login-container {
    justify-content: center;
  }
  .content {
    padding: 40px;
  }
  .company-info {
    margin-bottom: 30px;
  }
  .company-logo {
    max-width: 150px;
    width: 100px;
  }
  .title_company {
    font-size: 30px;
  }
  .login-form {
    text-align: left;
  }
  .title {
    font-size: 32px;
  }
  .form {
    margin-top: 70px;
  }
  .input {
    height: 60px;
    font-size: 20px;
  }
  .button {
    height: 60px;
    font-size: 24px;
  }
  .login-link {
    font-size: 20px;
    margin-bottom: 30px;
  }
  .login-link a {
    font-size: 20px;
  }
  .gjmkph {
    margin-bottom: 30px;
  }
  .doHtqb {
    width: 100px;
  }
  .bMZrBT {
    font-size: 1rem;
    padding: 30px 12px;
  }
  .google-logo {
    width: 30px;
  }
  .google-signin-button {
    padding: 15px 30px;
    font-size: 20px;
  }
} 

</style>