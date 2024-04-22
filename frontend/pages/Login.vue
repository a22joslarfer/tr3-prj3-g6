<template>
    <div class="container">
       

        <form @submit.prevent="fetchLogin" id="form">

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
      isLoading: false,
      csrf: null
    };
  },
  methods: {
    login() {
      this.isLoading = true;

      fetch('http://localhost:8000/api/csrf-token')
        .then(response => response.text())
        .then(text => {
          try {
            const data = JSON.parse(text);
            this.csrf = data.token;
            console.log('New CSRF token:', this.csrf);

            return fetch('http://localhost:8000/api/login', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrf,
              },
              body: JSON.stringify({
                email: this.email.trim(),
                password: this.password.trim(),

              }),
            });
          } catch (error) {
            console.error('Failed to parse CSRF token response as JSON:', error);
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
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
          console.error('There has been a problem with your fetch operation:', error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>

<style scoped>

</style>