<template>
    <div class="dots-container" v-if="isLoading">
      <div class="dots"></div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      isLoading: {
        type: Boolean,
        required: true
      }
    }
  };
  </script>
  
  <style scoped>
  .dots-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }
  
  .dots {
    width: 56px;
    height: 26.9px;
    background: radial-gradient(circle closest-side, #474bff 90%, #0000) 0% 50%,
      radial-gradient(circle closest-side, #474bff 90%, #0000) 50% 50%,
      radial-gradient(circle closest-side, #474bff 90%, #0000) 100% 50%;
    background-size: calc(100% / 3) 13.4px;
    background-repeat: no-repeat;
    animation: dots-7ar3yq 1s infinite linear;
  }
  
  @keyframes dots-7ar3yq {
    20% {
      background-position: 0% 0%, 50% 50%, 100% 50%;
    }
    40% {
      background-position: 0% 100%, 50% 0%, 100% 50%;
    }
    60% {
      background-position: 0% 50%, 50% 100%, 100% 0%;
    }
    80% {
      background-position: 0% 50%, 50% 50%, 100% 100%;
    }
  }
  </style>
  
