<template>
  <HeaderPerfil :pageTitle="pageTitle" />
  <div class="logout-container">
    <div class="logout-content">
      <button @click="logout" class="logout-button">Cerrar Sesión</button>
      <!--crea un aviso para preguntar si realmente quiere cerrar sesion -->

    </div>
    <FooterOptions />
  </div>
</template>

<script>
import { useStore } from '../stores/index.js';

export default {
  methods: {
    logout() {
      const store = useStore();
      store.logout(); 
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      // Eliminar información de usuario en local storage
      
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

.logout-title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
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
</style>
