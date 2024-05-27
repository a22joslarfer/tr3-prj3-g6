<template>
    <div>
      <h1>Tus Favoritos</h1>
      <ul>
        <li v-for="favorito in favoritos" :key="favorito.id">
          {{ favorito.discoteca_id }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import { useStore } from '../stores/index'; // Importa la tienda Pinia
  
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
        const store = useStore(); // Obtén la instancia de tu tienda Pinia
        return store.return_user_id(); // Retorna la ID del usuario desde la tienda
      }
    }
  };
  </script>
  