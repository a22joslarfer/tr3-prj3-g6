<template>
  <div>
    <h1>Subir Fotos</h1>
    <input type="file" ref="image1" accept="image/*">
    <input type="file" ref="image2" accept="image/*">
    <button @click="uploadImages">Subir Fotos</button>
  </div>
</template>

<script>
export default {
  methods: {
    async uploadImages() {
      const formData = new FormData();
      formData.append('img_del', this.$refs.image1.files[0]);
      formData.append('img_tra', this.$refs.image2.files[0]);
      formData.append('id_usuari', 1);

      try {
        const response = await fetch('http://localhost:8000/api/bereal', {
          method: 'POST',
          headers: {
            'Accept': 'application/json'
          },
          body: formData
        });

        if (response.ok) {
          console.log('Fotos subidas correctamente');
        } else {
          console.error('Error al subir fotos');
        }
      } catch (error) {
        console.error('Error al enviar la solicitud:', error);
      }
    }
  }
}
</script>
