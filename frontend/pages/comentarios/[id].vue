<template>
  <HeaderGeneral />
  <div class="bereals-container">
    <h1>BEREAL</h1>
    <div class="bereal-item">
     
      <div class="bereal-images">
        <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
        <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
      </div>
    </div>
    <div class="comentarios-container">
      <div class="agregar-comentario">
        <input type="text" v-model="nuevoComentario" placeholder="Escriu un comentari" class="comment-input">
        <button @click="agregarComentario" class="comment-button">Afegir Comentari</button>
      </div>
      <div class="comentarios-list">
        <div class="comentario-item" v-for="comentario in comentarios" :key="comentario.id">
          <p>{{ comentario.hora.slice(11, 19) }} - {{ comentario.autor }}: {{ comentario.comentario }}</p>
        </div>
      </div>
    </div>
  </div>
  <FooterOptions />
</template>

<script>
import { useStore } from '../../stores/index';

export default {
  data() {
    return {
      bereal: {},
      comentarios: [],
      nuevoComentario: "",
      loading: true,
      clientId: null,
      nom: null
    };
  },
  async created() {
    this.checkIfAuth();
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
        const data = await response.json();
        const usuarioResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${data.id_usuari}`);
        if (!usuarioResponse.ok) {
          throw new Error('Error al obtener el usuario');
        }
        const usuarioData = await usuarioResponse.json();
        data.usuarioNombre = usuarioData.data;
        this.bereal = data;
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
        const data = await response.json();
        this.comentarios = data;
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
            autor: this.nom,
          })
        });
        if (!response.ok) {
          throw new Error('Error al subir el comentario');
        }
        this.nuevoComentario = "";
        await this.obtenerComentarios();
      } catch (error) {
        console.error(error);
      }
    },
    getImagenUrl(rutaRelativaImagen) {
      return `http://elysium.daw.inspedralbes.cat/backend/storage/app/public${rutaRelativaImagen}`.replace(/storage(?!.*storage)/, '');
    },
    checkIfAuth() {
      const store = useStore();
      const user_id = store.return_user_id();
      if (user_id == null) {
        store.set_return_path('/comentarios' + this.$route.params.id);
        this.$router.push('/login');
      }
      this.clientId = user_id;
      this.nom = store.return_user_username();
      console.log(this.clientId, this.nom);
    },
  }
};
</script>

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

.comentarios-list {
  max-height: 300px;
  overflow-y: auto;
  margin-top: 20px;
  padding-right: 10px; /* to avoid content width change when scrollbar appears */
}

.comentario-item {
  margin-bottom: 10px;
}

.comentario-item p {
  margin: 0;
}

.agregar-comentario {
  display: flex;
  align-items: center;
  background-color: #e9e6e5;
  padding: 10px;
  border-bottom: 1px solid black;
  position: -webkit-sticky; /* For Safari */
  position: sticky;
  top: 0;
  z-index: 100;
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
