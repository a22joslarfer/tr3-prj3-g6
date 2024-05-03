<template>
  <div class="bereals-container">
    <h1>BEREALS</h1>
    <div v-if="bereals.length" class="bereals-list">
      <div v-for="bereal in bereals" :key="bereal.id" class="bereal-item">
        <h2>{{ bereal.usuarioNombre }}</h2>
        <div class="bereal-images">
          <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
          <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
        </div>
        <div class="comment-section">
          <!-- Input para añadir un comentario -->
          <input type="text" v-model="nuevoComentario" placeholder="Escribe un comentario" class="comment-input">
          <button @click="subirComentario(bereal.id)" class="comment-button">Añadir Comentario</button>

          <!-- Lista de comentarios -->
          <div class="comment-list">
            <div v-for="comentario in bereal.comentarios" :key="comentario.id" class="comment-item">
              <p>
                {{ comentario.hora.slice(11, 19) }} - {{ comentario.usuarioNombre }}: {{ comentario.comentario }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p v-else>No se encontraron Bereals.</p>
  </div>
</template>


<script>
export default {
  data() {
    return {
      bereals: [],
      nuevoComentario: "",
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
          const comentariosResponse = await fetch(`http://localhost:8000/api/comentarios/${bereal.id}`);
          if (!comentariosResponse.ok) {
            throw new Error('Error al obtener los comentarios');
          }
          const comentariosData = await comentariosResponse.json();
          bereal.comentarios = comentariosData;

          // Recuperar el nombre del usuario para cada comentario
          for (const comentario of comentariosData) {
            const usuarioResponse = await fetch(`http://localhost:8000/api/users/${comentario.id_usuari}`);
            if (!usuarioResponse.ok) {
              throw new Error('Error al obtener el usuario');
            }
            const usuarioData = await usuarioResponse.json();
            comentario.usuarioNombre = usuarioData.data; 
          }

          // Recuperar el nombre del usuario que creó el Bereal
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
    // Método para construir la URL completa de la imagen
    getImagenUrl(rutaRelativaImagen) {
      return `http://localhost:8000/${rutaRelativaImagen}`;
    },
    async subirComentario(idBereal) {
      try {
        const response = await fetch('http://localhost:8000/api/comentarios', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            comentario: this.nuevoComentario,
            id_bereal: idBereal,
            id_usuari: 1, // Aquí debes proporcionar el id del usuario actualmente autenticado
          })
        });
        if (!response.ok) {
          throw new Error('Error al subir el comentario');
        }
        this.nuevoComentario = "";
        this.obtenerBereals();
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>


<style scoped>
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

.comment-section {
  margin-top: 10px;
}

.comment-input {
  width: calc(100% - 90px);
  padding: 5px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 5px;
}

.comment-button {
  width: 80px;
  padding: 5px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.comment-list {
  list-style: none;
  padding-left: 0;
}

.comment-item {
  border-bottom: 1px solid #ddd;
  padding: 5px 0;
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
