<template>
    <div class="container">
        <div class="content">
            <div class="title">Únete a Viaegis</div>
            <form @submit.prevent="register" class="form">
                <div class="input-group">

                    <input type="text" v-model.trim="nombre" class="input" placeholder="Nombre Completo" required />
                </div>
                <div class="input-group">
                    <input type="email" v-model.trim="email" class="input" placeholder="Correo Electrónico"
                        title="Por favor, introduce un correo electrónico válido" />
                </div>
                <div class="input-group">
                    <input type="password" v-model.trim="password" class="input" placeholder="Contraseña" />
                    <img src="https://cdn-icons-png.freepik.com/512/2889/2889676.png" class="icon" alt="Lock Icon">
                </div>
                <div class="input-group">
                    <input type="password" v-model.trim="password2" class="input" placeholder="Repetir Contraseña" />
                </div>
                <div class="input-group">
                    <input type="date" v-model.trim="birthdate" class="input" placeholder="Fecha de Nacimiento"
                        required />
                </div>
                <div class="input-group">
                    <input type="tel" v-model.trim="phone" class="input" placeholder="Número de Teléfono" required
                        pattern="\d{9}" title="El número de teléfono debe tener 9 dígitos" />
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="terms" v-model="acceptTerms" required />
                    <label for="terms">Acepto las condiciones y términos</label>
                </div>
                <button type="submit" class="button">Regístrate</button>
            </form>
            <div class="login-link">
                ¿Ya tienes cuenta? <a href="/login" class="boton_login">¡Inicia sesión!</a>
            </div>
        </div>
    </div>
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

.icon{
    width: 21px;
    position: fixed;
    margin-top: 15px;
    margin-left: -28px;
}

.input {
    width: 100%;
    height: 40px;
    border: none;
    border-bottom: 1px solid #ccc;
    /* Cambio clave: borde inferior en lugar de borde completo */
    background-color: transparent;
    /* Hacemos el fondo transparente para que el borde inferior sea visible */
    font-size: 16px;
    padding: 10px;
    box-sizing: border-box;
    /* Asegura que el padding no aumente el tamaño total del campo de entrada */
}

.checkbox {
    margin-bottom: 20px;
    color: #333;
}

.checkbox input {
    margin-right: 10px;
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