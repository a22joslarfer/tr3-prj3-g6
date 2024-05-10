<template>
  <div class="container">
    <div class="qr-container">
      <div class="avatar">
        <img class="profile-picture"
          src="https://static-00.iconduck.com/assets.00/profile-circle-icon-2048x2048-cqe5466q.png"
          alt="Profile Picture">
      </div>
      <div class="qr-card">
        <h1>{{ name }}</h1>
        <div v-if="qrImageUrl" class="qr-code">
          <div v-html="qrImageUrl"></div>
        </div>
        <div v-else>
          <p>Cargando código QR...</p>
        </div>
        <h1 class="title-company">ELYSIUM 🥂</h1>

      </div>
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
      clientId: '',

    };
  },
  methods: {
    async fetchQRCode(id) {
      try {
        const response = await fetch(`http://localhost:8000/api/generate-qr-code/${id}`);

        if (!response.ok) {
          throw new Error('Error fetching QR code');
        }

        const qrSvg = await response.text();
        this.qrImageUrl = qrSvg; // Establecer la URL del código QR

      } catch (error) {
        console.error(error);
      }
    },
    checkIfAuth() {
      const store = useStore();
      const user_id = store.return_user_id();
      if (user_id == null) {
        store.set_return_path('/generarQr');
        this.$router.push('/login');

      }
      this.client_id = user_id;

    },
  },
  created() {
    this.checkIfAuth();
    const store = useStore();
    this.name = store.return_user_username();
    this.clientId = store.return_user_id();
    this.fetchQRCode(this.clientId);

  },

};
</script>







<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #ff806d;
  border-radius: 10px;
}

.qr-container {
  width: 100%;
  max-width: auto;
  margin: 10px;
  max-width: 425px;
}

.avatar {
  text-align: center;
}

.profile-picture {
  width: 150px;
  height: 150px;

  border-radius: 50%;
}

.qr-card {
  padding: 20px;
  display: flex;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  flex-direction: column;
  align-content: center;
  justify-content: center;
  align-items: center;
}

.qr-code {
  margin-top: 20px;
  text-align: center;
}

.title-company {
  margin-top: 20px;
  font-size: 24px;
  font-weight: bold;
  color: #333;
  text-align: center;
}

img {
  border: 2px solid #f5f5f5;
}

.follow-btn-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
</style>