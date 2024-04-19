<template>
  <header class="header">
    <div class="container">
      <div class="logo">
        <!-- Aquí puedes colocar tu logo -->
        <img src="../public/copas.png" alt="Logo">
      </div>
      <nav class="nav">
        <ul>
          <li><a href="/">Inicio</a></li>
          <li><a href="/productos">Productos</a></li>
          <li><a href="/login">Login/Register</a></li>
          <!-- Puedes añadir más elementos de menú según sea necesario -->
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header'
}
</script>

<style scoped>
.header {
  background-color: #eff4f3;
  color: #000000;
  padding: 20px 0;
}

.container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  height: 25px;
}

.logo img {
  height: 40px;
  position: absolute;
  left: 2px;
  transform: translateY(-20%); 

}

.nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav ul li {
  display: inline-block;
  margin-right: 20px;
}

.nav ul li:last-child {
  margin-right: 0;
}

.nav ul li a {
  color: #000000;
  text-decoration: none;
  font-size: 16px;
}

.nav ul li a:hover {
  color: #ccc;
}
</style>
