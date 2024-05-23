<template>
  <div>
    <HeaderGeneral />
    <div v-if="notificacionesPendientes.length > 0" class="notificaciones-container">
      <h2>Notificacions Pendents:</h2>
      <ul>
        <li v-for="(notificacion, index) in notificacionesPendientes" :key="index" @click="irABereal(notificacion)">
          <span>{{ notificacion.titulo }}</span>
        </li>
      </ul>
    </div>
    <div v-else>
      <p>No hi ha notificacions pendents.</p>
    </div>
    <FooterOptions />
  </div>
</template>
  
<script>
import { reactive } from 'vue';

export default {
  setup() {
    const state = reactive({
      notificacionesPendientes: []
    });

    const obtenerNotificacionesPendientes = () => {
      const notificacion = JSON.parse(localStorage.getItem('notificacionPendiente'));
      if (notificacion) {
        state.notificacionesPendientes.push(notificacion);
      }
    };

    const irABereal = (notificacion) => {
      if (!notificacion.eliminadaPorX) {
        localStorage.removeItem('notificacionPendiente');
        window.location.href = '/inTime';
      } else {
        window.location.href = '/PERFIL/notificaciones';
      }
    };

    obtenerNotificacionesPendientes();

    return {
      ...state,
      irABereal,
    };
  },
};
</script>
  
<style lang="css" scoped>
.notificaciones-container {
  margin-top: 20px;
}

h2 {
  margin-bottom: 20px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
  