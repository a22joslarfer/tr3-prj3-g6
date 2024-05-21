<template>
    <div class="container mt-4">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Editar Discoteca</div>
  
            <div class="card-body">
              <form @submit.prevent="updateDiscoteca">
                <div class="form-group">
                  <label for="coordenadas">Coordenadas</label>
                  <input type="text" class="form-control" id="coordenadas" v-model="discoteca.coordenadas">
                </div>
  
                <div class="form-group">
                  <label for="imgUrl">URL de la Imagen</label>
                  <input type="text" class="form-control" id="imgUrl" v-model="discoteca.imgUrl">
                </div>
  
                <div class="form-group">
                  <label for="minEdad">Edad Mínima</label>
                  <input type="number" class="form-control" id="minEdad" v-model="discoteca.minEdad">
                </div>
  
                <div class="form-group">
                  <label for="horario">Horario</label>
                  <input type="text" class="form-control" id="horario" v-model="discoteca.horario">
                </div>
  
                <div class="form-group">
                  <label for="nombre_local">Nombre del Local</label>
                  <input type="text" class="form-control" id="nombre_local" v-model="discoteca.nombre_local">
                </div>
  
                <div class="form-group">
                  <label for="telefono">Teléfono</label>
                  <input type="text" class="form-control" id="telefono" v-model="discoteca.telefono">
                </div>

                <div class="form-group">
                  <label for="descripcio">Descripción</label>
                  <input type="text" class="form-control" id="descripcio" v-model="discoteca.descripcio">
                </div>
  
                <button type="submit" class="btn btn-primary">Actualizar Discoteca</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import 'bootstrap/dist/css/bootstrap.css'
  definePageMeta({
    middleware: 'admin'
});

  export default {
    data() {
      return {
        discoteca: {
          coordenadas: '',
          imgUrl: '',
          minEdad: '',
          horario: '',
          nombre_local: '',
          telefono: '',
          descripcio: '',
        }
      };
    },
    head() {
      return {
        link: [
          { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css' }
        ]
      };
    },
    methods: {
      fetchDiscoteca() {
        const discotecaId = this.$route.params.id;
        fetch(`http://localhost:8000/api/discotecas/${discotecaId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Error fetching discoteca data');
            }
            return response.json();
          })
          .then(data => {
            this.discoteca = data;
          })
          .catch(error => {
            console.error(error);
          });
      },
      updateDiscoteca() {
        const discotecaId = this.$route.params.id;
        fetch(`http://localhost:8000/api/discotecas/${discotecaId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.discoteca)
        })
          .then(response => {
            if (!response.ok) {
              throw new Error('Error updating discoteca');
            }
            return response.json();
          })
          .then(data => {
            console.log('Discoteca updated:', data);
            this.$router.push('/crud/discotecas/');
          })
          .catch(error => {
            console.error(error);
          });
      }
    },
    created() {
      this.fetchDiscoteca();
    }
  };
  </script>
  
  <style scoped>
  /* Estilos específicos para este componente si es necesario */
  </style>
  