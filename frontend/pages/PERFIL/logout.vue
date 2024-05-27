<template>
  <HeaderPerfil :pageTitle="pageTitle" />
  <div class="logout-container">
    <div class="logout-content">
      <button @click="showConfirmation = true" class="logout-button">Cerrar Sesión</button>
    </div>
    <FooterOptions />
    <div v-if="showConfirmation" class="modal-overlay">
      <div class="modal-content">
        <p class="modal-text">¿Estás seguro de que quieres cerrar sesión?</p>
        <div class="modal-buttons">
          <button @click="confirmLogout" class="modal-button confirm">Sí</button>
          <button @click="showConfirmation = false" class="modal-button cancel">No</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useStore } from '../stores/index.js';

export default {
  data() {
    return {
      showConfirmation: false,
    };
  },
  methods: {
    confirmLogout() {
      const store = useStore();
      store.logout();
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      this.$router.push('/login');
    },
  },
};
</script>

<style scoped>
.logout-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #eff4f3;
}

.logout-content {
  text-align: center;
}

.logout-button {
  width: 200px;
  height: 50px;
  border: none;
  border-radius: 25px;
  background-color: #ff806d;
  color: white;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.logout-button:hover {
  background-color: #ff6252;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
}

.modal-text {
  font-size: 18px;
  margin-bottom: 20px;
}

.modal-buttons {
  display: flex;
  justify-content: space-around;
}

.modal-button {
  width: 100px;
  padding: 10px;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

.modal-button.confirm {
  background-color: #ff806d;
  color: white;
}

.modal-button.confirm:hover {
  background-color: #ff6252;
}

.modal-button.cancel {
  background-color: #cccccc;
}

.modal-button.cancel:hover {
  background-color: #aaaaaa;
}
</style>
