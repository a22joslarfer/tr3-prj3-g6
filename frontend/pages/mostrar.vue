<template>
  <div>
    <h1>Lista de Bereals</h1>
    <ul v-if="bereals.length">
      <li v-for="bereal in bereals" :key="bereal.id">
        <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
        <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
        <p>ID de Usuario: {{ bereal.id_usuari }}</p>

        <input type="text" v-model="nuevoComentario" placeholder="Escribe un comentario">
        <button @click="subirComentario(bereal.id)">Enviar</button>
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
        this.bereals = data;
      } catch (error) {
        console.error(error);
      }
    },
    // Método para construir la URL completa de la imagen
    getImagenUrl(rutaRelativaImagen) {
      // Reemplazar solo la segunda aparición de 'storage' con una cadena vacía
      return `http://localhost:8000/${rutaRelativaImagen}`;
    },
    async subirComentario(idBereal){
      try{
        const response = await fetch('http://localhost:8000/api/comentarios',{
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            comentario: this.nuevoComentario,
            id_bereal: idBereal
          })
        });
        if(!response.ok){
          throw new Error('Error al penjar el comentari');
        }
        this.nuevoComentario = "";
        this.obtenerBereals();
      }catch(error) {
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