<template>
    <div class="body">
        <div class="container">
            <header>
                <nuxt-link to="/PERFIL/main"><h1>AJUSTES</h1></nuxt-link>

                <li class="li-search-i-holder">
                    <input type="text" placeholder="Search" class="searchbar">
                    <i class="material-icons">search</i>
                </li>

                <li @click="cambiar_tema"><i class="material-icons">contrast</i></li>

                <li><i class="material-icons">account_circle</i></li>

            </header>

            <aside>
                <ul>
                    <li @click="navigateTo_ajustes"><i class="material-icons">settings</i></li>
                    <li @click="navigateTo_favoritos"><i class="material-icons">star</i></li>
                    <li @click="navigateTo_vista"><i class="material-icons">visibility</i></li>
                    <li @click="navigateTo_info_cuenta"><i class="material-icons">person</i></li>
                    <li @click="navigateTo_chats"><i class="material-icons">chat</i></li>
                </ul>

            </aside>



            <div class="info-basica">
                <h1>Informacio Bàsica</h1>
                <p>Posa el teu nom i canvia la teva icona</p>

                <div @click="basica = !basica">
                    <button>Canviar Informació Bàsica</button>
                    <i class="material-icons">chevron_right</i>
                </div>


                <form action="" @submit.prevent v-if="basica">
                    <div>
                        <label for="nombre">Nom:</label>
                        <input type="text" id="nombre" name="nombre">
                    </div>
                    <div>
                        <label for="icona">Icona:</label>
                        <input type="file" id="icona" name="icona">
                    </div>
                    <input type="submit" value="Desa">
                </form>

            </div>

            <div class="info-contacte">
                <h1>Informació de contacte</h1>
                <p>Posa el teu email i el teu telèfon</p>

                <div @click="contacte = !contacte">
                    <button>Canviar Informació de Contacte</button>
                    <i class="material-icons">chevron_right</i>
                </div>


                <form action="" @submit.prevent v-if="contacte">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div>
                        <label for="telefono">Telèfon:</label>
                        <input type="tel" id="telefono" name="telefono">
                    </div>
                    <input type="submit" value="Desa">
                </form>



            </div>

            <div class="info-seguretat">
                <h1>Informació de seguretat</h1>
                <p>Estableix o restableix la teva contrasenya</p>

                <div @click="seguretat = !seguretat">
                    <button>Canviar Contrasenya</button>
                    <i class="material-icons">chevron_right</i>
                </div>



                <form action="" @submit.prevent v-if="seguretat">
                    <div>
                        <label for="password">Contrasenya:</label>
                        <input type="password" id="password" name="password">
                    </div>

                    <div>
                        <label for="confirm-password">Confirmar Contrasenya:</label>
                        <input type="password" id="confirm-password" name="confirm-password">
                    </div>
                    <input type="submit" value="Desa">
                </form>


            </div>




        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            nombre: '',
            email: '',
            password: '',
            confirm_password: '',
            telefono: '',
            fecha_nacimiento: '',
            contacte: false,
            basica: false,
            seguretat: false,

        }
    },
    methods: {
        async editar() {
            try {
                const response = await fetch(`http://localhost:8000/api/users/${this.user_id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        nombre: this.nombre,
                        phone: this.telefono,
                        birthdate: this.fecha_nacimiento,
                        email: this.email,
                        password: this.password,
                        password2: this.confirm_password,
                    }),
                });
                const data = await response.json();
                console.log(data);
                navigateTo('main');
            } catch (error) {
                console.error(error);
            }

        },

    }
}
</script>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/icon?family=Material+Icons');


.info-basica {
    grid-area: info-basica;

}

.info-contacte {
    grid-area: info-contacte;
}

.info-seguretat {
    grid-area: info-seguretat;
}

.info-basica h1,
.info-contacte h1,
.info-seguretat h1 {
    font-size: 40px;
    color: #dbd5d5;
}

.info-basica p,
.info-contacte p,
.info-seguretat p {
    font-size: 20px;
    margin-bottom: 5px;
    color: #c5b8b8;

}

.info-basica button,
.info-contacte button,
.info-seguretat button {

    border-radius: 16px;
    color: #000;
    font-size: 30px;

    font-weight: 700;
    border: none;
    cursor: pointer;
}


.info-contacte,
.info-basica,
.info-seguretat {
    display: grid;
    grid-template-rows: auto;
    grid-template-areas:
        "h1"
        "p"
    ;
    max-height: 500px;
    width: 70%;
  
    margin-left: auto;
    margin-right: auto;
    background-color: #383030f5;
  
    border-radius: 16px;
    margin: 10px;
    justify-items: center;
    justify-self: center;
    align-content: center;
}

.info-contacte>div,
.info-basica>div,
.info-seguretat>div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 90%;
    height: auto;
    //margin-top: 20px;
    background-color: #ddddddb0;
    border-radius: 16px;
    padding: 20px;

}

.info-contacte div:hover,
.info-basica div:hover,
.info-seguretat div:hover {
    color: #fff;
    cursor: pointer;
}

form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
    position: absolute;
    /*que ocupe toda la pantalla*/
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /*que ocupe toda la pantalla*/
    justify-content: center;
    align-items: center;
    background-color: #9b4242;
    padding: 40px;
    border-radius: 16px;
    color: #000000;
    font-size: 30px;
    font-weight: 700;
    border: 5px solid #000000;
    width: 30%;
    height: 60%;
    margin-top: auto;
    margin-bottom: auto;
    margin-left: auto;
    margin-right: auto;
}

form div {
    flex-direction: column;
    gap: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    border-radius: 16px;
    padding: 20px;
}

form input {
    padding: 20px;
    border-radius: 16px;
    border: none;
    background-color: #fcfcfcf5;
    color: black;
    font-size: 40px;
    font-weight: 700;
    margin: auto;
    width: 100%;
    text-align: center;
}

form input:focus {
    outline: none;
    border: 4px solid #000000;
}



form input[type="submit"] {
    background-color: #383030f5;
    color: rgb(99, 43, 43);
    cursor: pointer;
}

form input[type="submit"]:hover {
    color: #eb5a5af5;
}

label {
    color: black;
}


/* ESTILOS GLOBALES ------------------------------------------------------------------------------------  */



header h1 {
    font-size: 60px;
    color: #723d3d;
    font-weight: 700;
    padding-left: 30px;
}

li {
    list-style: none;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-size: 30px;
}

.body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #dbdada;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;

}

.container {
    display: grid;
    grid-template-columns: 0.33fr 1fr 1fr 1fr;
    grid-template-areas:

        "header header header header header"
        "aside info-basica info-basica info-basica info-basica"
        "aside info-contacte info-contacte info-contacte info-contacte"
        "aside info-seguretat info-seguretat info-seguretat info-seguretat";

    ;
    grid-template-rows: repeat(4, auto);


    grid-template-rows: auto auto auto auto;
    background-color: rgb(235, 225, 228);
    border-radius: 16px;
    padding: 20px;

}

.container header {
    grid-area: header;
    display: flex;
    justify-content: space-between;
    align-items: center;

    background-color: #c28383;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    border-bottom: 3px solid #4d12123d;
}

.container header * {
    margin: 10px;
}

aside {
    display: flex;
    flex-direction: column;
    background-color: #c28383;
    grid-area: aside;
}

aside li {
    padding: 10px;
    margin-top: 30px;
    background-color: #4d12123d;
    border-radius: 50%;
    height: auto;
    width: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin-left: auto;
    margin-right: auto;
}

aside li i {
    color: #723d3d;
    margin-left: auto;
    margin-right: auto;
}

aside li i:hover {
    color: #dfd9d9;

}

.searchbar {
    padding: 15px;
    border-radius: 16px;
    min-width: 700px;
    border: none;
    background-color: #fcfcfcf5;
    color: #834545;
    font-size: 40px;
    font-weight: 700;
    margin: auto;
}

.li-search-i-holder {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

}

.searchbar::placeholder {
    color: #834545;
    font-size: 40px;
    font-weight: 700;
    margin: auto;
}

.searchbar:focus {
    outline: none;
    border: 3px solid #723d3d;
}

i {
    font-size: 60px;
}

/* ESTILOS GLOBALES ------------------------------------------------------------------------------------  */
</style>