<template>
    <div>
<HeaderPerfil :pageTitle="pageTitle"/>
<!-- alert -->
<div v-if="showAlert" class="alert">
      <p>{{ alertMessage }}</p>
      <button @click="hideAlert">Cerrar</button>
    </div>
    </div>
</template>

<script>
    export default {
      data() {
        return {
          pageTitle: 'Cerrar Sesión', // Definir el título aquí en el objeto data
          showAlert: false,
          alertMessage: 'Este es un mensaje de alerta.'
        }
      },
      methods: {
        showCustomAlert(message) {
      this.alertMessage = message;
      this.showAlert = true;
    },
    hideAlert() {
      this.showAlert = false;
    }
  }
}
</script>


<style lang="scss" scoped>

.alert {
  background-color: #f8d7da;
  color: #721c24;
  padding: 10px;
  margin: 20px 0;
  border: 1px solid #f5c6cb;
  border-radius: 5px;
}

.alert p {
  margin: 0;
}

.alert button {
  margin-top: 5px;
  padding: 5px 10px;
  background-color: #dc3545;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.alert button:hover {
  background-color: #c82333;
}
</style>