
import FooterOptions from '~/components/FooterOptions.vue';
<template>
    <div class="social-profile">
      <div class="profile-header">
        <div class="profile-image">
          <div class="bordered-image">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-GjJceC84m1AjZSUzAWP5bXixhKWr9HfUC4hkka5l5oAeLEnI1UtUNa45yyr46sldxyE&usqp=CAU">
          </div>
        </div>
        <div class="profile-info">
          <h1 class="username">Lionel Messi</h1>
          <p class="bio">¡Bienvenido al mundo de las redes sociales! Conéctate, comparte y descubre.</p>
        </div>
      </div>
      <div class="user-stats">
        <div class="stat">
          <span class="stat-label">Publicaciones</span>
          <span class="stat-value">10</span>
        </div>
        <div class="stat">
          <span class="stat-label">Seguidores</span>
          <span class="stat-value">500M</span>
        </div>
        <div class="stat">
          <span class="stat-label">Siguiendo</span>
          <span class="stat-value">300</span>
        </div>
      </div>
      <div class="edit-profile">
        <button>Editar perfil</button>
      </div>
      <div class="instagram-stories">
  <div class="story" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_zqXfEtVU1TPQeQX4MgJ4wjqBDLEVH2okT5Vbgs5ZsJ869wAmvk1MWJsWX4WqG4j-W1w&usqp=CAU');">
    <span class="story-username">Story 1</span>
  </div>
  <div class="story" style="background-image: url('https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2018/05/08/15257737585365.jpg');">
    <span class="story-username">Story 2</span>
  </div>
  <div class="story" style="background-image: url('https://e00-marca.uecdn.es/blogs/alacontra/imagenes_posts/2010/09/15/messi_570x420.jpg');">
    <span class="story-username">Story 3</span>
  </div>
  <div class="story" style="background-image: url('https://e00-marca.uecdn.es/blogs/alacontra/imagenes_posts/2010/09/15/messi_570x420.jpg');">
    <span class="story-username">Story 3</span>
    </div>
    
    </div>
    <div class="icons">
    <div class="icon">
        <img src="../public/img/camara.png" alt="Cámara">
    </div>
    <div class="icon">
        <img src="../public/img/video.png" alt="Video">
    </div>
    <div class="icon">
        <img src=".../public/img/bola-de-discoteca.png" alt="Bola de discoteca">
    </div>
</div>
<FooterOptions  />
    </div>
  </template>
  
  <style>
  
   .instagram-stories {
    display: flex;
    overflow-x: auto;
    padding: 10px 0;
  }
  
  .story {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-right: 10px;
    position: relative;
    background-size: cover;
    background-position: center;
    border: 2px solid #ffc40000;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .story-username {
    position: absolute;
    bottom: -20px;
    width: 100%;
    text-align: center;
    font-size: 12px;
    color: #555;
  }
    .social-profile {
      background-color: #f9f9f9;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
  
    .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
  
    .bordered-image {
      position: relative;
      overflow: hidden;
      border-radius: 50%;
      animation: border-pulse 2s infinite alternate;
    }
  
    .bordered-image img {
      width: 100px;
      height: 100px;
      object-fit: cover;
    }
  
    .profile-info {
      flex: 1;
    }
  
    .username {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
      margin-left:24px;
    }
  
    .bio {
      font-size: 14px;
      color: #777;
    }
  
    .user-stats {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
  
    .stat {
      text-align: center;
    }
  
    .stat-label {
      font-size: 14px;
      color: #555;
    }
  
    .stat-value {
      font-size: 18px;
      font-weight: bold;
    }
  
    .edit-profile button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
    }
  
    @keyframes border-pulse {
      0% {
        border: 2px solid #ffc400;
      }
      100% {
        border: 2px solid #555;
      }
    }
  </style>
  