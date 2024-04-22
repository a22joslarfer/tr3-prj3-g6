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
  background-color: #f0f1f1;
;
  color: #fff;
  padding: 20px 0;
  margin-left:1px;
}

.container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  height: 25px;
  margin-left:20px;
}

.logo img {
  height: 60px;
  position: absolute;
  left: 5px;
  transform: translateY(-25%); 

}

.nav ul {
  list-style: none;
  margin: 5px;
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
  margin-left:10px;
  color: #000000;
  text-decoration: none;
  font-size: 16px;
}

.nav ul li a:hover {
  color: #ccc;
}
</style>
