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
    <CancelarFollow />
  </div>
  <FooterOptions />
</template>


<script>


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
  overflow: hidden;
}





.container {
  display: grid;
  place-items: center;
  height: 100vh;
  background-color: #fff;
  border-radius: 16px;
}

.else-container {
  display: grid;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #fff;
  border-radius: 16px;



}

p {
  font-size: 3rem;
  margin: 10px;
}


.form-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 3rem;
  padding-top: 2rem;
  background-color: #f5f5f5;

  border-radius: 2.5rem;
  height: auto;
  width: auto;
  margin: auto;
  box-shadow: 0px 0px 100px 10px #ff806d;

}

input::content {
  border-radius: 4px;

}

.header {

  font-size: 2rem;
  font-weight: 600;
  margin-bottom: 1rem;
  text-align: center;
}

.form-group {

  margin-bottom: 1rem;
}

.label {
  display: block;
  font-size: 1rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.input-field {
  padding: 0.5rem;
  border-radius: 4px;
  border: 1px solid #cccccc3b;
  background-color: #fff;
}

.submit-btn {
  padding: 0.5rem;
  width: 100%;
  border-radius: 4px;
  border: none;
  background-color: #ff806d;
  color: #fff;
  font-weight: 500;
  cursor: pointer;
}

.submit-btn:hover {
  background-color: #f3634d;
}

input:focus {
  outline: none;
}

button:focus {
  outline: none;
}
</style>