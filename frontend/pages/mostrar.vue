<template>
  <div>
    <h1>Lista de Bereals</h1>
    <ul v-if="bereals.length">
      <li v-for="bereal in bereals" :key="bereal.id">
        <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
        <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
        <p>ID de Usuario: {{ bereal.id_usuari }}</p>
        
        <input type="text" v-model="nuevoComentario" placeholder="Escribeix un comentari">
        <button @click="subirComentario(bereal.id)">Penja</button>
        
        <ul>
          <li v-for="comentario in bereal.comentarios" :key="comentario.id">
            {{ comentario.comentario }}
          </li>
        </ul>

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
      nuevoComentario: ""
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
        // Obtindre comentaris per cada Bereal
        for (const bereal of data) {
          const comentariosResponse = await fetch(`http://localhost:8000/api/comentarios/${bereal.id}`);
          if (!comentariosResponse.ok) {
            throw new Error('Error al obtener los comentarios');
          }
          const comentariosData = await comentariosResponse.json();
          bereal.comentarios = comentariosData;
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
            id_bereal: idBereal
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

<style>
.bereal-image {
  width: 200px;
  height: auto;
}
</style>