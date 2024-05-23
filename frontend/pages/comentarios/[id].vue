<template>

  <body>
    <div class="bereals-container">
      <h1>BEREAL</h1>
      <div class="bereal-item">
        <h2>{{ bereal.usuarioNombre }}</h2>
        <div class="bereal-images">
          <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
          <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
        </div>
      </div>
      <div class="comentarios-container">
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

<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.loading-gif {
  width: 100px;
  height: 100px;
}

.bereals-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  text-align: center;
  color: #f1693f;
}

.bereal-item {
  margin-bottom: 20px;
}

.bereal-images {
  display: flex;
  justify-content: center;
}

.bereal-image {
  max-width: 300px;
  max-height: 300px;
  border-radius: 5px;
  margin-right: 10px;
}

.comentarios-container {
  background-color: #e9e6e5;
  padding: 20px;
  border-radius: 5px;
}

.comentario-item {
  margin-bottom: 10px;
}

.comentario-item p {
  margin: 0;
}

.agregar-comentario {
  margin-top: 20px;
  display: flex;
  align-items: center;
}

.comment-input {
  flex: 1;
  padding: 8px;
  border-radius: 5px;
  border: 1px solid #ddd;
}

.comment-button {
  background-color: #f1693f;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 8px 15px;
  cursor: pointer;
  margin-left: 10px;
}

.comment-button:hover {
  background-color: #a34427;
}
</style>


<script>
export default {
  data() {
    return {
      bereal: {},
      comentarios: [],
      nuevoComentario: "",
      loading: true,
      clientId: null,
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
        const response = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/inTime/${this.$route.params.id}`);
        if (!response.ok) {
          throw new Error('Error al obtener el Bereal');
        }
        this.bereal = await response.json();
        // Obtener el nombre de usuario asociado al Bereal
        const usuarioResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${this.bereal.id_usuari}`);
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
        const response = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/comentarios/${this.$route.params.id}`);
        if (!response.ok) {
          throw new Error('Error al obtener los comentarios');
        }
        this.comentarios = await response.json();


        // Obtener el nombre de usuario asociado a cada comentario
        for (const comentario of this.comentarios) {
          const usuarioResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${comentario.id_usuari}`);
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
        const response = await fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/comentarios', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            comentario: this.nuevoComentario,
            id_bereal: this.$route.params.id,
            id_usuari: this.clientId,
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
      return `http://elysium.daw.inspedralbes.cat/${rutaRelativaImagen}`;
    },
    checkIfAuth() {
      const store = useStore();
      const user_id = store.return_user_id();
      if (user_id == null) {
        store.set_return_path('/comentarios'+ this.$route.params.id);
        this.$router.push('/login');

      }
      this.clientId = user_id;

    },
  },
  mounted(){
    this.checkIfAuth();
  }
}
</script>
