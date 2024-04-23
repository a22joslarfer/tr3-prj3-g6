<template>
  <div>
    <h1>Lista de Bereals</h1>
    <ul v-if="bereals.length">
      <li v-for="bereal in bereals" :key="bereal.id">
        <img :src="bereal.img_del" alt="Imagen del Bereal">
        <img :src="bereal.img_tra" alt="Imagen del Bereal">
        <p>ID de Usuario: {{ bereal.id_usuari }}</p>
      </li>
    </ul>
    <p v-else>No se encontraron Bereals.</p>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      bereals: []
    }
  },
  async mounted() {
    await this.fetchBereals();
  },
  methods: {
    async fetchBereals() {
      try {
        const response = await fetch('http://perubafoto.daw.inspedralbes.cat/backend/public/api/bereals');
        if (!response.ok) {
          throw new Error('Error al obtener los Bereals');
        }
        const data = await response.json();
        this.bereals = data;
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
