<template>
  <div>
    <div class="container">
      <div class="title">Cerrar Sesión</div>
      <button @click="logout" class="button">Cerrar Sesión</button>
    </div>
  </div>
</template>

<script>
import { useStore } from '../stores/index.js';

export default {
  mounted() {
    const store = useStore();
    console.log(store); // Verifica que la tienda se esté utilizando correctamente
  },
  methods: {
    logout() {
      const store = useStore();
      store.reset_booking_info();
      localStorage.removeItem('token');
      this.$router.push('/login');
    }
  }
};
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #eff4f3;
}

.title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.button {
  width: 200px;
  height: 50px;
  border: none;
  border-radius: 25px;
  background-color: #ff806d;
  color: white;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
}
</style>
