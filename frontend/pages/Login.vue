<template>
    <div class="container">
      <div class="content">
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
        <div class="login-link">
          ¿Aún no tienes cuenta? <a href="/register" class="boton_login">¡Regístrate!</a>
        </div>
      </div>
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
    /*
    
    created() {
        fetch('http://localhost:8000/api/csrf-token')
            .then(response => response.text())  // Get the response text
            .then(text => {
                console.log('Response text:', text);  // Log the response text

                // Try to parse the response text as JSON
                try {
                    const data = JSON.parse(text);
                    this.csrf = data.token;
                    console.log(this.csrf);
                } catch (error) {
                    console.error('Failed to parse response as JSON:', error);
                }
            });
    },
    
    */
    methods: {
        login() {
            this.isLoading = true;

            // Fetch a new CSRF token
            fetch('http://localhost:8000/api/csrf-token')
                .then(response => response.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        this.csrf = data.token;
                        console.log('New CSRF token:', this.csrf);

                        // Perform the login request with the new CSRF token
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
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: url('https://i.pinimg.com/originals/8e/2d/79/8e2d79c7abf858ae412c74a25726d950.jpg') center/cover;
}

.content {
  width: 300px;
  padding: 20px;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
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
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 16px;
  padding: 10px;
}

.button {
  width: 100%;
  height: 50px;
  border: none;
  border-radius: 25px;
  background-color: #062b25;
  color: white;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
}

.login-link {
  text-align: center;
  font-size: 16px;
  color: #333;
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