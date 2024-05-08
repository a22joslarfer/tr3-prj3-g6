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
      <img src="../public/img/google_icon.png" alt="Google Logo" class="google-logo"> Iniciar sesión con Google
    </button>
  </div>
      </div>
    </div>

    <FooterOptions />
  </div>
</template>

<script>

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
          alert('Sesión iniciada correctamente');
         
          const store = useStore();
          store.save_user_info(data.name, data.email, data.id);
         

          console.log('BBBBBBBBBBBBBBBBBBB');
          this.$router.push('/');
     
        })
        .catch(error => {
          console.error('Error al iniciar sesión:', error);
        });

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
.google-logo{
  width: 20px;
  margin-right: 10px;
}
.google-signin-button{
  border-radius: 25px;
  padding: 10px 20px;
  font-size: 16px;
  
}
</style>