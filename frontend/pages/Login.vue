<template>
  <div class="container">


    <form @submit.prevent="login" id="form">

      <label for="email">Email</label>
      <input type="text" id="email" v-model="email" placeholder="exemple@gmail.com">

      <label for="password">Contrasenya</label>
      <input type="password" id="password" v-model="password" placeholder="contrasenya actual">

      <nuxt-link to="/register" class="nuxt-link">No tens compte? Registra't</nuxt-link>

      <button type="submit">Login</button>

    </form>


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

<style scoped></style>