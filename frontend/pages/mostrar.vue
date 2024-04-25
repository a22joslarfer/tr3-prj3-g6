<template>
  <div>
    <h1>Lista de Bereals</h1>
    <ul v-if="bereals.length">
      <li v-for="bereal in bereals" :key="bereal.id">
        <div class="bereal-container">
          <div class="bereal-image-container">
            <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
            <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
          </div>
          <p>ID de Usuario: {{ bereal.id_usuari }}</p>
          <!-- Mostrar comentarios -->
          <div class="comentarios-container">
            <div v-for="comentario in bereal.comentarios" :key="comentario.id" class="comentario">
              <p>{{ comentario.texto }}</p>
            </div>
            <!-- Input para agregar comentario -->
            <input type="text" v-model="nuevoComentario" placeholder="Escribe un comentario...">
            <button @click="agregarComentario(bereal.id)">Agregar</button>
          </div>
        </div>
      </li>
    </ul>
    <p v-else>No se encontraron Bereals.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      bereals: [],
      nuevoComentario: ''
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
        this.bereals = data;
      } catch (error) {
        console.error(error);
      }
    },
    getImagenUrl(rutaRelativaImagen) {
      return `http://localhost:8000/${rutaRelativaImagen}`;
    },
    async agregarComentario(berealId) {
      try {
        const response = await fetch(`http://localhost:8000/api/bereals/${berealId}/comment`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            comentario: this.nuevoComentario
          })
        });
        if (!response.ok) {
          throw new Error('Error al agregar el comentario');
        }
        const nuevoComentario = await response.json();
        // Agregar el nuevo comentario al arreglo de comentarios del Bereal correspondiente
        const berealIndex = this.bereals.findIndex(b => b.id === berealId);
        if (berealIndex !== -1) {
          this.bereals[berealIndex].comentarios.push(nuevoComentario);
        }
        // Limpiar el campo de texto del nuevo comentario
        this.nuevoComentario = '';
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>

<style>
.bereal-container {
  margin-bottom: 20px;
}

.bereal-image-container {
  display: flex;
  justify-content: center;
  margin-bottom: 10px;
}

.bereal-image {
  width: 200px;
  height: auto;
}

.comentarios-container {
  margin-top: 10px;
}

.comentario {
  margin-bottom: 5px;
}
</style>
