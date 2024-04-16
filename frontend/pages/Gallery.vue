<template>
  <div class="container mx-auto">
    <h1 class="text-4xl font-extrabold mb-8 text-center">Galería de Imágenes</h1>
    <div class="filter-section">
      <label for="city">Filtrar por ciudad:</label>
      <select id="city" v-model="selectedCity" @change="filterImages">
        <option value="">Todas</option>
        <option value="1">Barcelona</option>
        <option value="2">Zaragoza</option>
        <option value="3">Madrid</option>
        <option value="4">Bilbao</option>
        <option value="5">Ibiza</option>
        <option value="6">Huesca</option>
        <option value="7">Galicia</option>
        <option value="8">Cordoba</option>
        <option value="9">Sevilla</option>
        <option value="10">Valencia</option>
        <option value="11">Granada</option>
        <option value="12">Malaga</option>
        <option value="13">Santander</option>
        <option value="14">Salamanca</option>
        <option value="15">Alicante</option>
        <option value="16">Murcia</option>
        <option value="17">Toledo</option>
        <option value="18">Valladolid</option>
        <option value="19">Pamplona</option>
        <option value="20">A Coruña</option>
        <option value="21">Zamora</option>
        <option value="22">Almeria</option>
        <option value="23">Caceres</option>
        <option value="24">Girona</option>
        <option value="25">Jaen</option>
      </select>
    </div>
    <div class="gallery grid gap-4">
      <div v-for="(image, index) in filteredImages" :key="index" class="image-item">
        <div @click="openImage(index)" class="image-container">
          <img :src="image.url" alt="Imagen" class="image cursor-pointer" />
        </div>
      </div>
    </div>
    <div v-if="previewImage !== null" class="preview-overlay" @click="closePreview">
      <div class="preview-content">
        <img :src="filteredImages[previewImage].url" alt="Imagen" class="preview-image" />
        <button @click="closePreview" class="close-button">Cerrar</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      images: [],
      filteredImages: [],
      selectedCity: '',
      previewImage: null,
      loading: false,
    };
  },
  async created() {
    this.loading = true;
    try {
      const response = await axios.get('http://localhost:8000/api/discotecas');
      this.images = response.data.map(item => ({
        url: item.imgUrl,
        cityId: item.id_ciudad !== null ? item.id_ciudad.toString() : null
      }));
      this.filteredImages = [...this.images];
    } catch (error) {
      console.error('Error al cargar las imágenes:', error);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    openImage(index) {
      this.previewImage = index;
    },
    closePreview() {
      this.previewImage = null;
    },
    filterImages() {
      if (this.selectedCity === '') {
        this.filteredImages = [...this.images];
      } else {
        this.filteredImages = this.images.filter(image => {
          return image.cityId !== null && image.cityId.toString() === this.selectedCity.toString();
        });
      }
    },
  },
};
</script>


<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f5f5f5;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #333;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.gallery {
  margin-top: 20px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 1fr);
  gap: 4px;
}
.image-container {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  height: 100%; /* Ajuste aquí */
}

.image-container:hover .image {
  transform: scale(1.05);
}

.image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
  transition: transform 0.3s ease-in-out;
}

.preview-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.preview-content {
  position: relative;
  max-width: 80%;
  max-height: 80%;
}

.preview-image {
  width: 100%;
  height: auto;
  border-radius: 8px;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 8px;
  background-color: #fff;
  color: #333;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
}

.close-button:hover {
  background-color: #eee;
}
</style>