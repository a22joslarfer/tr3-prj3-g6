<template>
    <div class="container">

        <div class="left">
            <form @submit.prevent="login" class="form">
                <img class="background-image" src="../public/img/images.jpg" alt="Imagen de fondo">
                <img class="foreground-image" src="../public/img/3128-earth.png" alt="Imagen superpuesta">
            </form>

        </div>
        <div class="right">
            <form @submit.prevent="login" class="form">

                <div class="title">Iniciar Sesión</div>
                <div class="form">
                    <input type="text" v-model="email" class="input" placeholder="Email">
                    <input type="password" v-model="password" class="input" placeholder="Contraseña">

                    <button class="button">Iniciar Sesión</button>
                    <div class="text">¿Aún no tienes cuenta? <router-link to="/register">¡Regístrate!</router-link>

                    </div>
                    <div class="icons">
                        <div class="icon"><img src="../public/img/google.png" width="24" height="24"></div>
                        <div class="icon"><img src="../public/img/instagram.png" width="24" height="24"></div>
                        <div class="icon"><img src="../public/img/facebook.png" width="24" height="24"></div>
                    </div>
                </div>
            </form>
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
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    display: flex;
    height: 100vh;
}

.left {
    flex: 1;
    position: relative;
}

.background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    /* Coloca la imagen de fondo en el fondo */
}

.foreground-image {
    position: absolute;
    top: 50%;
    /* Ajusta la posición vertical según tus necesidades */
    left: 50%;
    /* Ajusta la posición horizontal según tus necesidades */
    transform: translate(-50%, -50%);
    z-index: 1;
    /* Coloca la imagen superpuesta encima del fondo */
}

.right {
    flex: 1;
    background-color: #f0f0f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.title {
    font-size: 36px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.form {
    width: 80%;
    max-width: 400px;
}

.input {
    width: 100%;
    height: 40px;
    border: none;
    border-bottom: 2px solid #ccc;
    margin-bottom: 20px;
    font-size: 18px;
    padding: 10px;
}

.button {
    width: 100%;
    height: 50px;
    border: none;
    border-radius: 25px;
    background-color: #0f233b;
    color: white;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    cursor: pointer;
}

.text {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
    margin-left: 71px;
}

.icons {
    display: flex;
    justify-content: space-between;
    width: 60%;
    margin-left: 71px;
}

.icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
</style>