<template>
  <div class="container">
    <div class="wrapper">
      <h1>BeReal</h1>
      <div v-if="bereals.length" class="bereals-list" id="bereals-list">
        <div v-for="bereal in bereals" :key="bereal.id" class="bereal-item">
          <div class="user-info">
            <h2>{{ bereal.usuarioNombre }}</h2>
            <p>{{ bereal.hora.slice(11, 19) }}</p>
          </div>
          <div class="bereal-images">
            <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
            <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
          </div>
          <button @click="irAComentarios(bereal.id)" class="comment-button">Afegir Comentaris</button>
        </div>
      </div>
      <p v-else class="no-bereals-message">No s'ha pujat cap Bereal encara.</p>
    </div>
  </div>
</template>

<style>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  
}

.wrapper {
  border: 1px solid #a34427;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #f1693f;
}

.bereals-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  grid-gap: 20px;
}

.bereal-item {
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 15px;
}

.user-info {
  margin-bottom: 10px;
}

.user-info h2 {
  font-size: 18px;
  margin: 0;
}

.user-info p {
  font-size: 14px;
  color: #777;
  margin: 0;
}

.bereal-images {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.bereal-image {
  max-width: 100px;
  max-height: 100px;
  border-radius: 5px;
  object-fit: cover;
}

.comment-button {
  background-color: #f1693f;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 8px 15px;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  margin-top: 10px;
  margin-left: auto;
  margin-right: auto;
}

.comment-button:hover {
  background-color: #a34427;
}

.no-bereals-message {
  text-align: center;
  margin-top: 20px;
  color: #777;
}
</style>




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
        const response = await fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/inTimes');
        if (!response.ok) {
          throw new Error('Error al obtener los Bereals');
        }
        const data = await response.json();
       
        for (const bereal of data) {
          // Obtener el nombre de usuario del Bereal
          const usuarioResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${bereal.id_usuari}`);
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
      // Reemplazar solo la segunda aparición de 'storage' con una cadena vacía
      return `http://elysium.daw.inspedralbes.cat/backend/storage/app/public${rutaRelativaImagen}`.replace(/storage(?!.*storage)/, '');
    },
    irAComentarios(idBereal) {
      this.$router.push(`/comentarios/${idBereal}`);
    }
  }
}
</script>


