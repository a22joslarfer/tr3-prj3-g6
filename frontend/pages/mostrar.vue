<template>
  <div>
    <h1>Lista de Bereals</h1>
    <ul v-if="bereals.length">
      <li v-for="bereal in bereals" :key="bereal.id">
        <h2>{{ bereal.usuarioNombre }}</h2>
        <img :src="getImagenUrl(bereal.img_del)" alt="Imagen del Bereal" class="bereal-image">
        <img :src="getImagenUrl(bereal.img_tra)" alt="Imagen del Bereal" class="bereal-image">
        <br>
        <!-- Input para añadir un comentario -->
        <input type="text" v-model="nuevoComentario" placeholder="Escribe un comentario">
        <button @click="subirComentario(bereal.id)">Añadir Comentario</button>

        <!-- Lista de comentarios -->
        <ul>
          <li v-for="comentario in bereal.comentarios" :key="comentario.id">
            <p>
              {{ comentario.hora.slice(11, 19) }} - {{ comentario.usuarioNombre }}: {{ comentario.comentario }}
            </p>
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

<style>
.bereal-image {
  width: 200px;
  height: auto;
}
</style>
