<template>
  <HeaderGeneral />
  <div class="container">
    <div class="qr-container">
      <div class="avatar">
        <img class="profile-picture" :src="profileImageUrl" alt="Profile Image">
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
  <FooterOptions />
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
      profileImageUrl: null,


    };
  },
  methods: {
    async fetchQRCode(id) {
      try {
        const response = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/generate-qr-code/${id}`);

        if (!response.ok) {
          throw new Error('Error fetching QR code');
        }

        const qrSvg = await response.text();
        this.qrImageUrl = qrSvg; // Establecer la URL del código QR

      } catch (error) {
        console.error(error);
      }
    },
    async fetchUserPhoto() {
      try {
        const store = useStore();
        const id = store.return_user_id();

        // Fetch de la imagen de perfil
        const profilePhotoResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/profile_photo/${id}`);
        const profilePhotoData = await profilePhotoResponse.json();
        console.log(profilePhotoData);
        this.profileImageUrl = profilePhotoData; // Suponiendo que la respuesta contiene la URL de la imagen de perfil

      }
      catch (error) {
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
    this.fetchUserPhoto();

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
}

.qr-container {
  width: 80%;
  max-width: 100%;
  margin-bottom: 145px;
}

.avatar {
  text-align: center;
}

.profile-picture {
  width: 100px;
  height: 100px;

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
/* media query iphone 5 */
@media only screen and (max-width: 320px) {
  .profile-picture {
    /* que no se vea */
    display: none;
  }
  .qr-card {
    padding: 1px;
  }
  .title-company {
    font-size:10px;
  }
  .qr-code {
    margin-top: 10px;
  }
}
</style>