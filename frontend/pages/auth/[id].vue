<template>
  <HeaderGeneral />
  <div class="container" v-if="!hasAuthenticated && !skipAuth">
    <div class="form-container">
      <p>🥂</p>
      <header class="header"> Elysium Auth </header>
      <form @submit.prevent="auth">
        <div class="form-group">
          <label class="label" for="email">Email</label>
          <input class="input-field" type="email" name="email" id="email" v-model="email">
        </div>

        <div class="form-group">
          <label class="label" for="password">Password</label>
          <input class="input-field" type="password" name="password" id="password" v-model="password">
        </div>

        <button class="submit-btn" type="submit">Login</button>
      </form>
    </div>

  </div>
  <div v-else class="else-container">
    <BtnFollowAuth :clientId="clientId" :lectorId="lectorId" />
    
  </div>
  <FooterOptions />
</template>


<script>
import { useStore } from '../../stores/index';


export default {
  data() {
    return {
      email: '',
      password: '',
      hasAuthenticated: false,
      clientId: this.$route.params.id,
      lectorId: null,
      skipAuth: false,
    };
  },
  methods: {
    auth() {
      fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/auth`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          email: this.email,
          password: this.password
        })
      })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          if (data.message = 'success') {
            this.lectorId = data.user.id;
            console.log('lector id ' + this.lectorId);
            console.log('cliente id ' + this.clientId);
            this.followBack();
            this.hasAuthenticated = true;
          }
          else {
            alert('Error');
          }
        })
        .catch(error => {
          console.error(error);
        });
    },
    followBack() {
      fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/seguidores', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          seguidor: this.lectorId,
          seguido: this.clientId,
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
    checkIfAuth() {

      const store = useStore();
      
      this.lectorId =  store.return_user_id();
      if(this.lectorId != null){
        this.skipAuth = true;
      }
      
    }

  },
  created() {
    this.checkIfAuth();
    if(this.hasAuthenticated){
      this.followBack();
    }
  }
}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
}
.form-container {
  width: 300px;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.header {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 20px;
  text-align: center;
}
.form-group {
  margin-bottom: 20px;
}
.label {
  font-size: 16px;
  font-weight: 500;
  margin-bottom: 5px;
}
.input-field {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.submit-btn {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.submit-btn:hover {
  background-color: #0056b3;
}
.else-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
}

</style>