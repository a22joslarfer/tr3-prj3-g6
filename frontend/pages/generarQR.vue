<template>
  <div class="container"> 
    <div class="avatar">
        <img class="profile-picture" src="https://static-00.iconduck.com/assets.00/profile-circle-icon-2048x2048-cqe5466q.png" alt="Profile Picture">
      </div>
    <div class="qr-card">
     
      <!-- name user -->
      <h1>{{name}}</h1>
      <div v-if="qrImageUrl" class="qr-code">
        <div v-html="qrImageUrl"></div>
      </div>
      <div v-else>
        <p>Cargando código QR...</p>
      </div>
      <!-- titulo -->
      <h1 class="title_company">🥂 ELYSIUM</h1>
    </div>
  </div>
</template>



<script>
import { useStore } from "../stores/index";

export default {
  data() {
    return {
      qrImageUrl: '',
      userId: '',
      name: '',
      avatar: '',
    };
  },
  methods: {
    async fetchQRCode() {
      try {
        const store = useStore(); // Acceder al almacenamiento Vuex usando this.$store
        const id = store.return_user_id(); // Suponiendo que tienes un estado llamado 'user' que contiene el ID del usuario
        console.log(id);
        console.log("hola");
        const response = await fetch(`http://localhost:8000/api/generate-qr-code/${id}`);
        //console del usuario
        console.log(id);
        this.userId = id;
        //console de nombre de usuario
        if (!response.ok) {
          throw new Error('Error fetching QR code');
        }

        const qrSvg = await response.text();
        this.qrImageUrl = qrSvg; // Establecer la URL del código QR

      } catch (error) {
        console.error(error);
      }
    }
  },
  created() {
    this.fetchQRCode();
    const store=useStore();
  this.name = store.return_user_username();
    console.log(this.name);
  },

};
</script>
<style scoped>

.title_company{
  font-size: 20px;
  color: #000;
  font-weight: bold;
  margin-top: 20px;
  margin-bottom: 20px;


}
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #ebe5e4;
}
.qr-card {
  max-width: 500px;
  margin: 0 auto;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgb(0 0 0 / 26%);
  background-color: #ffffff;
  text-align: center;
  width: 80%;
}

.qr-card h1 {
  font-size: 28px;
  margin-bottom: 20px;
}

.qr-code {
  max-width: 300px;
  margin: 0 auto;
  margin-top: 30px;
}

.qr-code img {
  max-width: 100%;
  height: auto;
}

.follow-button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #ff806d;
  color: #ffffff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 20px;
}

.follow-button:hover {
  background-color: #45a049;
}
.user-profile {
  position: absolute;
  top: -50px; /* Desplazamiento negativo para que la mitad de la imagen sobresalga */
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 100px;
  overflow: hidden;
}

.profile-picture {
  width: 100%;
  height: auto;
  border-radius: 50%;
  border: 2px solid #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>