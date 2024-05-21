<template>
    <HeaderGeneral />

    <div class="login-container">
        <div class="content">
            <!-- Add multi-step progress bar -->
            <div class="step-progress-content">
                <button type="button" class="boton-atras" @click="step = step > 1 ? step - 1 : 1"><svg
                        xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                    </svg></button>
                <div class="progress-bar">
                    <div class="progress" :style="{ width: (step * 33.33) + '%' }"></div>
                </div>

            </div>

            <div class="company-info">
                <img src="https://static.vecteezy.com/system/resources/previews/029/938/250/non_2x/planet-earth-globe-world-map-ai-generative-free-png.png"
                    alt="Logo de la empresa" class="company-logo">
                <div class="title_company">BIENVENIDO A ELYSIUM</div>
            </div>

            <div class="login-form">
                <div class="login-link">
                    ¿Ya tienes cuenta? <nuxt-link to="/login" class="boton_login">¡Inicia sesión!</nuxt-link>
                </div>
                <form @submit.prevent="register" class="form">
                    <div class="input-group" v-if="step === 1">
                        <input type="text" v-model.trim="name" class="input" placeholder="Nombre Completo" required />
                        <input type="file" @change="handleFileUpload" accept="image/*" />

                        <div class="botones">

                            <button type="button" class="button next-button" @click="step++">Siguiente</button>
                        </div>
                    </div>
                    <div v-if="step === 2">
                        <div class="input-group">
                            <input type="email" v-model="email" class="input" placeholder="Correo Electrónico"
                                required />
                        </div>
                        <div class="input-group">
                            <input type="password" v-model="password" class="input" placeholder="Contraseña" required />
                        </div>
                        <div class="botones">
                            <button type="button" class="button next-button" @click="step++">Siguiente</button>
                        </div>
                    </div>
                    <div v-if="step === 3">
                        <div class="input-group">
                            <input type="text" v-model="phone" class="input" placeholder="Teléfono" />
                        </div>
                        <div class="input-group">
                            <input type="date" v-model="birthday" class="input" placeholder="Fecha de Nacimiento" />
                        </div>
                        <div class="botones">
                            <button type="submit" class="button">Regístrate</button>
                        </div>
                    </div>
                </form>
                <!-- GOOGLE
                    <div class="sc-18d118e1-0 gjmkph">
                    <hr class="sc-1a86d6e9-0 doHtqb"><span class="sc-7b9b9acb-0 bMZrBT">or</span>
                    <hr class="sc-1a86d6e9-0 doHtqb">
                </div>
               <div class="login-form-container">
                    <button id="signinButton" class="google-signin-button">
                        <img src="../public/img/google_icon.png" alt="Google Logo" class="google-logo"> Iniciar sesión con
                        Google
                    </button>
                </div> -->
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
            step: 1,
            name: '',
            email: '',
            password: '',
            phone: '',
            birthday: '',
            profile_photo: null, // Cambiado de 'photo' a 'profile_photo'
            selected_photo: null // Nuevo estado para la imagen seleccionada

        };
    },
    methods: {
        handleFileUpload(event) {
            this.selected_photo = event.target.files[0];
            this.profile_photo = URL.createObjectURL(this.selected_photo);
        },
        register() {
            const formData = new FormData();
            formData.append('name', this.name.trim());
            formData.append('email', this.email.trim());
            formData.append('password', this.password.trim());
            formData.append('phone', this.phone.trim());
            formData.append('birthday', this.birthday.trim());

            if (this.selected_photo) {
                formData.append('profile_photo', this.selected_photo);
            }
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/register', {
                method: 'POST',
                body: formData,
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
                        console.error('Error:', data.error);
                        alert(data.error);
                    } else {
                        alert('Usuario registrado correctamente!');
                        const store = useStore();
                        store.save_user_info_register(data.name, data.email, data.id, data.phone, data.birthday, data.token);

                        this.$router.push('/login');
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
@import url('https://fonts.googleapis.com/css2?family=Antonio:wght@100..700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,100..900;1,100..900&display=swap');

/* Contenedor de la barra de progreso */
.progress-bar {
    width: 80%;
    margin: 0 auto;
    margin-top: 10px;
    margin-bottom: 10px;
    height: 10px;
    /* Altura de la barra de progreso */
    background-color: #ddd;
    /* Color de fondo de la barra de progreso */
    border-radius: 5px;
    /* Borde redondeado de la barra de progreso */
}

.progress {
    height: 100%;
    background-color: #ff806d;
    /* Color de la barra de progreso */
    border-radius: 5px;
    /* Borde redondeado de la barra de progreso */
    transition: width 0.3s ease;
    /* Transición suave del ancho */
}

/* Contenedor de la barra de progreso */
.step-progress-content {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
    margin-bottom: 10px;
}

.login-container {
    background-color: #eff4f3;

}

.login-form-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.content {
    width: 100%;
    height: 100vh;
    padding: 20px;
    overflow-y: visible;
    /* Cambiar de 'auto' a 'visible' */
    flex: 1;
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


.next-button {
    background-color: #f1693f;
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 18px;
    margin-top: 10px;
    padding: 10px 20px;
    margin-bottom: 10px;


}

.button[type="submit"] {
    background-color: #f1693f;
    color: white;



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

.boton-atras {
    background-color: #cbc5c5af;
    color: #333;
    border: none;
    border-radius: 26px;
    font-size: 28px;
    margin-right: 10px;
    padding: 0px 13px;
}
svg {
    fill: #333;
}
</style>