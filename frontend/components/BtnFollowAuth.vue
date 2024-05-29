<template>
    <div class="container">
      <div class="header">
        <h1 class="title">Conectar con Amigos</h1>
        <p class="subtitle">Sigue a tus amigos y mantente en contacto</p>
      </div>
      <div class="button-group">
        <button class="follow-btn" @click="follow(lectorId)">Seguir</button>
        <UButton class="cancel-btn" @click="cancelarFollow()">Cancelar</UButton>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      clientId: {
        type: Number,
        required: true
      },
      lectorId: {
        type: Number,
        required: true
      }
    },
    methods: {
      follow(seguido_id) {
        fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/seguidores', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            seguidor: this.clientId,
            seguido: seguido_id,
          }),
        })
          .then(response => {
            if (!response.ok) {
              throw new Error(`Error adding friend: ${response.status} - ${response.statusText}`);
            }
            return response.json();
          })
          .then(friend => {
            alert('Amigo añadido');
          })
          .catch(error => {
            console.error('Error adding friend:', error);
            alert('Error adding friend');
          });
      },
      cancelarFollow() {
        navigateTo('/');
      }
    }
  }
  </script>
  
  <style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: #f9f9f9;
  height: 100vh;
  box-sizing: border-box;
}

.header {
  text-align: center;
  margin-bottom: 20px;
  margin-top: 40px; /* Ajuste para mover el header hacia arriba */
}

.title {
  font-size: 24px;
  color: #333;
  margin: 0;
}

.subtitle {
  font-size: 16px;
  color: #666;
  margin: 0;
}

.button-group {
  display: flex;
  gap: 10px;
  margin-top: 50px;
  margin-bottom: auto; /* Centrar los botones verticalmente */
  align-items: center; /* Asegura que los botones estén alineados */
}

.follow-btn {
  background-color: #15a710;
  color: #fff;
  border: none;
  padding: 14px 28px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
  font-weight: 600;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, transform 0.3s ease;
  cursor: pointer;
}

.follow-btn:hover {
  background-color: #2e8307;
  transform: translateY(-2px);
}

.cancel-btn {
  background-color: #e22108;
  color: #fff;
  border: none;
  padding: 14px 28px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
  font-weight: 600;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, transform 0.3s ease;
  cursor: pointer;
}

.cancel-btn:hover {
  background-color: #7e0303;
  transform: translateY(-2px);
}
  </style>
  