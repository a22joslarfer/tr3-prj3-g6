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

    name: 'RegisterScreen',
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
  background-color: #eff4f3;
  position: relative;
}

.content {
    width: 300px;
    padding: 20px;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-top:45%;
    overflow-y: auto;
    max-height: 100%;
}

.title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
  font-family: "Antonio", sans-serif;
}
.title_company {
 /* arriba del todo en la pagina */
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
  font-family: "Antonio", sans-serif;
   position: absolute;
    top: 15%;

}
.company-logo {
  max-width: 100px; /* ajusta el ancho según sea necesario */
  margin: 0 auto; /* centrar la imagen */
  display: block; /* asegurar que la imagen sea un bloque */
  position: fixed;
  top: 32%;
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
  background-color: #ff806d;
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