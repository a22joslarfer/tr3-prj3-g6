<template>
    <body>
        <div class="container">
            <div class="left">
                <form @submit.prevent="register" class="form">
                    <img class="background-image" src="../public/img/images.jpg " alt="Imagen de fondo" />
                    <img class="foreground-image" src="../public/img/3128-earth.png" alt="Imagen superpuesta" />
                </form>
            </div>
            <div class="right">
                <div class="title">Regístrate en Viaegis</div>
                <form @submit.prevent="register" class="form">
                    <input type="text" v-model.trim="nombre" class="input" placeholder="Nombre Completo" required />
                    <input type="email" v-model.trim="email" class="input" placeholder="Correo Electrónico"
                        title="Por favor, introduce un correo electrónico válido" />
                    <input type="password" v-model.trim="password" class="input" placeholder="Contraseña" />
                    <input type="password" v-model.trim="password2" class="input" placeholder="Repetir Contraseña" />
                    <input type="date" v-model.trim="birthdate" class="input" placeholder="Fecha de Nacimiento" required />
                    <input type="tel" v-model.trim="phone" class="input" placeholder="Número de Teléfono" required
                        pattern="\d{9}" title="El número de teléfono debe tener 9 dígitos" />
                    <div class="checkbox">
                        <input type="checkbox" id="terms" v-model="acceptTerms" required />
                        <label for="terms">Acepto las condiciones y términos</label>
                    </div>
                    <button type="submit" class="button">Regístrate</button>
                    <div class="text">¿Ya tienes cuenta? ¡Inicia sesión!</div>
                </form>
            </div>
        </div>
    </body>
</template>
  
  
<script>
export default {
    name: 'RegisterScreen',
    data() {
        return {
            nombre: '',
            email: '',
            password: '',
            password2: '', // Add this line
            birthdate: '', // Add this line
            phone: '', // Add this line
            acceptTerms: false, // Add this line
        };
    },

    methods: {
        register() {
            fetch('http://localhost:8000/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    nombre: this.nombre.trim(),
                    email: this.email.trim(),
                    password: this.password.trim(),
                    birthdate: this.birthdate, // Include birthdate
                    phone: this.phone, // Include phone
                    password2: this.password2, // Include password2
                }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (error) {
                        console.error('Could not parse JSON:', text);
                        throw error;
                    }
                })
                .then(data => {

                    if (data.error) {
                        localStorage.setItem('authToken', data.access_token);
                        // Almacena solo la información necesaria del usuario
                        localStorage.setItem('user', JSON.stringify({
                            nombre: data.user.nombre,
                            email: data.user.email,
                            token: data.access_token,
                            
                        }));

                        alert(data.error);
                    } else {
                        alert('Usuario registrado correctamente!');
                        // Almacena solo la información necesaria del usuario
                        localStorage.setItem('user', JSON.stringify({
                            nombre: this.nombre.trim(),
                            email: this.email.trim(),
                            token: data.access_token,
                        }));
                        navigateTo('/login');
                    }
                })

                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    }
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

.checkbox {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.checkbox input {
    width: 20px;
    height: 20px;
    margin-right: 10px;
}

.checkbox label {
    font-size: 16px;
    color: #333;
}
</style>