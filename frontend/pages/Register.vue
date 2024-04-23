<template>
    <div>
    

        <div class="container">
            <div class="title_company">VIAEGIS</div>
            <div class="content">
                <div class="title">Únete a Viaegis</div>
                <form @submit.prevent="register" class="form">
                    <div class="input-group">

                        <input type="text" v-model.trim="name" class="input" placeholder="Nombre Completo" required />
                    </div>
                    <div class="input-group">
                        <input type="email" v-model.trim="email" class="input" placeholder="Correo Electrónico"
                            title="Por favor, introduce un correo electrónico válido" />
                    </div>
                    <div class="input-group">
                        <input type="password" v-model.trim="password" class="input" placeholder="Contraseña" />
                        <img src="" class="icon" alt="Lock Icon">
                    </div>
                  
                    <button type="submit" class="button">Regístrate</button>
                </form>
                <div class="login-link">
                    ¿Ya tienes cuenta? <a href="/login" class="boton_login">¡Inicia sesión!</a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
       
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
                    name: this.name.trim(),
                    email: this.email.trim(),
                    password: this.password.trim(),
                   
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