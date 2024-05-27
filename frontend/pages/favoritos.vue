<template>
    <div class="favorites-container">
      <h1 class="favorites-title">Tus Favoritos</h1>
      <ul class="favorites-list">
        <li v-for="favorito in favoritos" :key="favorito.id" class="favorite-item">
          {{ favorito.discoteca_id }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import { useStore } from '../stores/index';
  
  export default {
    data() {
      return {
        favoritos: []
      };
    },
    async mounted() {
      await this.getFavoritos();
    },
    methods: {
      async getFavoritos() {
        try {
          const userId = this.getUserId();
          const response = await fetch(`http://localhost:8000/api/favoritos/${userId}`);
          if (!response.ok) {
            throw new Error('No se pudo obtener los favoritos');
          }
          const data = await response.json();
          this.favoritos = data;
        } catch (error) {
          console.error('Error al obtener los favoritos:', error);
        }
      },
      getUserId() {
        const store = useStore();
        return store.return_user_id();
      }
    }
  };
  </script>
  
  <style scoped>
  .favorites-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .favorites-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
  }
  
  .favorites-list {
    list-style-type: none;
    padding: 0;
  }
  
  .favorite-item {
    background-color: #f9f9f9;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .favorite-item:hover {
    background-color: #eaeaea;
    transition: background-color 0.3s ease;
  }
  </style>
  