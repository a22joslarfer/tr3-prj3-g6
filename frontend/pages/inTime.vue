<template>
  <div class="container">
    <div class="wrapper">
      <h1>inTime</h1>
      <div class="form">
        <label for="img_del" class="custom-file-input">
          <span v-if="!img_del">Seleccionar Imagen de Delante</span>
          <span v-else>{{ img_del.name }}</span>
        </label>
        <input id="img_del" type="file" @change="handleFileChange('img_del', $event)" accept="image/*" />

        <label for="img_tra" class="custom-file-input">
          <span v-if="!img_tra">Seleccionar Imagen de Trasera</span>
          <span v-else>{{ img_tra.name }}</span>
        </label>
        <input id="img_tra" type="file" @change="handleFileChange('img_tra', $event)" accept="image/*" />
      </div>
      <button @click="uploadImages" class="upload-button">Subir Imágenes</button>
    </div>
  </div>

</template>

<script>
export default {
  data() {
    return {
      img_del: null,
      img_tra: null,
      clientId: null,
    }
  },
  created() {
    this.checkIfAuth();
  },
  methods: {
    handleFileChange(type, event) {
      this[type] = event.target.files[0];
    },
    async uploadImages() {
 

      const formData = new FormData();
      formData.append('img_del', this.img_del);
      formData.append('img_tra', this.img_tra);
      formData.append('id_usuari', this.clientId);
      try {
        const response = await fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/inTime', {
          method: 'POST',
          body: formData,
        });
        if (response.ok) {
          alert('Imágenes subidas correctamente');
          navigateTo('inTimes')
        } else {
          alert('Error al subir imágenes');
        }
      } catch (error) {
        console.error('Error al subir imágenes:', error);
        alert('Error al subir imágenes');
      }
    },
    checkIfAuth() {
      const store = useStore();
      this.userId = store.return_user_id();
      if (this.userId == null) {
        navigateTo('/login')
      }
      this.clientId = store.return_user_id();
    },
  },
}
</script>


<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.wrapper {
  width: 100%;
  max-width: 400px;
  padding: 20px;
  box-shadow: 0 0 10px #e9e6e5;
  border-radius: 8px;
}

h1 {
  color: #f1693f;
  margin: 20px 0;
  text-align: center;
}

.form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

input[type="file"] {
  display: none;
}

.custom-file-input {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 50px;
  margin-bottom: 15px;
  border: 2px dashed #f1693f;
  border-radius: 4px;
  color: #f1693f;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.custom-file-input:hover {
  background-color: #f1693f;
  color: white;
}

.upload-button {
  background-color: #f1693f;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  margin-top: 20px;
}

.upload-button:hover {
  background-color: #a34427;
}
</style>
