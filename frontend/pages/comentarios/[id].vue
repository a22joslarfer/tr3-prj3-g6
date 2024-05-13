<template>
    <body>
     
  
  
    <div v-if="loading" class="bereals-container">
      <img src="../../public/img/carga.gif" alt="Loading GIF" class="loading-gif">
    </div>
    <div v-else class="bereals-container">
    <h1>BEREAL</h1>
    <div class="bereal-item">
      <h2>{{ bereal.usuarioNombre }}</h2>
      <div class="bereal-images">
        <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
        <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
      </div>
    </div>
    <div class="comentarios-container">
      <h1>Comentaris</h1>
      <div class="comentario-item" v-for="comentario in comentarios" :key="comentario.id">
        <p>{{ comentario.hora.slice(11, 19) }} - {{ comentario.usuarioNombre }}: {{ comentario.comentario }}</p>
      </div>
      <div class="agregar-comentario">
        <input type="text" v-model="nuevoComentario" placeholder="Escriu un comentari" class="comment-input">
        <button @click="agregarComentario" class="comment-button">Afegir Comentari</button>
      </div>
  
  
    </div>
  </div>
  </body>
  </template>
   
  <script>
  export default {
    data() {
      return {
        bereal: {},
        comentarios: [],
        nuevoComentario: "",
        loading: true
      };
    },
    async mounted() {
      await this.obtenerBereal();
      await this.obtenerComentarios();
      this.loading = false;
    },
    methods: {
      async obtenerBereal() {
        try {
          const response = await fetch(`http://localhost:8000/api/bereals/${this.$route.params.id}`);
          if (!response.ok) {
            throw new Error('Error al obtener el Bereal');
          }
          this.bereal = await response.json();
          // Obtener el nombre de usuario asociado al Bereal
          const usuarioResponse = await fetch(`http://localhost:8000/api/users/${this.bereal.id_usuari}`);
          if (!usuarioResponse.ok) {
            throw new Error('Error al obtener el usuario');
          }
          const usuarioData = await usuarioResponse.json();
          this.bereal.usuarioNombre = usuarioData.data;
        } catch (error) {
          console.error(error);
        }
      },
      async obtenerComentarios() {
        try {
          const response = await fetch(`http://localhost:8000/api/comentarios/${this.$route.params.id}`);
          if (!response.ok) {
            throw new Error('Error al obtener los comentarios');
          }
          this.comentarios = await response.json();
  
  
          // Obtener el nombre de usuario asociado a cada comentario
          for (const comentario of this.comentarios) {
            const usuarioResponse = await fetch(`http://localhost:8000/api/users/${comentario.id_usuari}`);
            if (!usuarioResponse.ok) {
              throw new Error('Error al obtener el usuario');
            }
            const usuarioData = await usuarioResponse.json();
            comentario.usuarioNombre = usuarioData.data;
          }
        } catch (error) {
          console.error(error);
        }
      },
      async agregarComentario() {
        try {
          const response = await fetch('http://localhost:8000/api/comentarios', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              comentario: this.nuevoComentario,
              id_bereal: this.$route.params.id,
              id_usuari: 23, //aqui hay que poner el id del usuario / pinia /////////////////////////////////////////////////////////
            })
          });
          if (!response.ok) {
            throw new Error('Error al subir el comentario');
          }
          this.nuevoComentario = "";
          this.obtenerComentarios();
        } catch (error) {
          console.error(error);
        }
      },
      getImagenUrl(rutaRelativaImagen) {
        return `http://localhost:8000/${rutaRelativaImagen}`;
      }
    }
  }
  </script>
   
  <style scoped>
  body{
    background-color: black;
    height: 100vh;
    width: 100vw;
  }
  .loading-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  
  
  .loading-gif {
    width: 200px;
    height: 200px;
    margin-top: 200px;
  }
  
  
  .bereals-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
  }
  
  
  h1 {
    color: white;
    text-align: center;
  }
  
  
  h2,
  p {
    color: white;
  }
  
  
  
  
  .bereal-item {
    margin-bottom: 20px;
  }
  
  
  .bereal-images {
    display: flex;
    justify-content: center;
  }
  
  
  .bereal-image {
    width: 150px;
    height: auto;
    margin-right: 10px;
    border-radius: 5px;
  }
  
  
  .comentarios-container {
    margin-top: 20px;
    width: 100%;
  }
  
  
  .comentario-item {
    margin-bottom: 10px;
  }
  
  
  .agregar-comentario {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
  }
  
  
  .comment-input {
    width: 300px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-right: 10px;
  }
  
  
  .comment-button {
    padding: 5px 10px;
    background-color: black;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  </style>
  