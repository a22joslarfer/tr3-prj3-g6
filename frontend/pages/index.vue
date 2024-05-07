<template>
  <body>
    <h1>BeReal</h1>
    <div v-if="isLoggedIn" class="container">
    <input type="file" @change="handleFileChange('img_del')" accept="image/*" />
    <input type="file" @change="handleFileChange('img_tra')" accept="image/*" />
    <button @click="uploadImages" class="upload-button">Pujar Imágenes</button>
  </div>  
</body>
</template>

<script>
export default {
  data() {
    return {
      img_del: null,
      img_tra: null,
    }
  }, 
  created() {
    this.checkIfAuth();
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
        const response = await fetch('http://localhost:8000/api/bereal', {
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
    checkIfAuth() {
            const store = useStore();
            this.userId = store.return_user_id();
            if(this.userId==null){
              navigateTo('/login')
            }
        },
  },
}
</script>

<style scoped>
html, body{
  margin: 0;
  padding: 0;
  height: 100vh;
  width: 100vw;
} 
body{
  background-color: black;
}
input{
  color: red;
}
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
}
.upload-button {
  padding: 10px 20px;
  font-size: 18px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}
h1 {
  color: white;
  text-align: center;
}
.upload-button:hover {
  background-color: #45a049;
}
</style>
