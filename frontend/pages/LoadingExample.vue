<template>
    <div>
      <h1>Ejemplo de carga</h1>
      <LoadingDots :isLoading="isLoading" />
    </div>
  </template>
  
  <script>
  import LoadingDots from "@/components/LoadingDots.vue";
  
  export default {
    components: {
      LoadingDots
    },
    data() {
      return {
        isLoading: true
      };
    },
    // mounted() {
    //   setTimeout(() => {
    //     this.isLoading = false;
    //   }, 3000); // Simulamos una carga de 3 segundos
    // }
  };
  </script>
  