<template>
    <body>
      <div class="bereals-container">
        <h1>BeReal</h1>
        <div v-if="bereals.length" class="bereals-list">
          <div v-for="bereal in bereals" :key="bereal.id" class="bereal-item">
            <h2>{{ bereal.usuarioNombre }} </h2>
            <p>{{ bereal.hora.slice(11, 19)  }}</p>
           
            <div class="bereal-images">
              <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
              <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
            </div>
            <button @click="irAComentarios(bereal.id)" class="comment-button">Afegir Comentaris</button>
          </div>
        </div>
        <p v-else>No s'ha pujat cap Bereal encara.</p>
      </div>
    </body>
  </template>
  
  
  <script>
  export default {
    data() {
      return {
        bereals: [],
      }
    },
    async mounted() {
      await this.obtenerBereals();
    },
    methods: {
      async obtenerBereals() {
        try {
          const response = await fetch('http://localhost:8000/api/bereals');
          if (!response.ok) {
            throw new Error('Error al obtener los Bereals');
          }
          const data = await response.json();
         
          for (const bereal of data) {
            // Obtener el nombre de usuario del Bereal
            const usuarioResponse = await fetch(`http://localhost:8000/api/users/${bereal.id_usuari}`);
            if (!usuarioResponse.ok) {
              throw new Error('Error al obtener el usuario');
            }
            const usuarioData = await usuarioResponse.json();
            bereal.usuarioNombre = usuarioData.data;
          }
         
          this.bereals = data;
        } catch (error) {
          console.error(error);
        }
      },
      getImagenUrl(rutaRelativaImagen) {
        return `http://localhost:8000/${rutaRelativaImagen}`;
      },
      irAComentarios(idBereal) {
        this.$router.push(`/comentarios/${idBereal}`);
      }
    }
  }
  </script>
  
  
  <style scoped>
  html, body {
    margin: 0;
    padding: 0;
    height: 100vh;
    width: 100vw;
  }
  
  
  body {
    background-color: black;
  }
  
  
  h1 {
    color: white;
    text-align: center;
  }
  
  
  h2 {
    color: white;
  }
  
  
  p{
    color: grey;
    margin-bottom: 20px;
  }
  
  
  .bereals-container {
    padding: 20px;
  }
  
  
  .bereal-item {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
  }
  
  
  .bereal-images {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  
  
  .bereal-image {
    width: 45%;
    max-width: 150px;
    height: auto;
    border-radius: 5px;
  }
  
  
  .comment-button {
    width: 100%;
    padding: 5px;
    background-color: grey;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  
  @media (min-width: 768px) {
    .bereal-item {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }
  
  
    .bereal-image {
      width: 100%;
      max-width: none;
      height: 150px;
    }
  }
  </style>
  