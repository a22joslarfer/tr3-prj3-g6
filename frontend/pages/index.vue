<template>
  <div>
    <input type="file" @change="handleFileChange('img_del')" accept="image/*" />
    <input type="file" @change="handleFileChange('img_tra')" accept="image/*" />
    <button @click="uploadImages">Subir Imágenes</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      img_del: null,
      img_tra: null,
    }
  },
  methods: {
    handleFileChange(type) {
      this[type] = event.target.files[0];
    },
    async uploadImages() {
      const formData = new FormData();
      formData.append('img_del', this.img_del);
      formData.append('img_tra', this.img_tra);
      formData.append('id_usuari', 1);
      try {
        const response = await fetch('http://perubafoto.daw.inspedralbes.cat/backend/public/api/bereal', {
          method: 'POST',
          body: formData
        });
        if (response.ok) {
          alert('Imágenes subidas correctamente');
        } else {
          alert('Error al subir imágenes');
        }
      } catch (error) {
        console.error('Error al subir imágenes:', error);
        alert('Error al subir imágenes');
      }
    },

  },
}
</script>
