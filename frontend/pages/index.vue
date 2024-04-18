<template>
  <div>
    <h1>Subir Fotos</h1>
    <button @click="tomarFotos">Tomar Fotos</button>
    <button @click="subirFotos">Subir Fotos</button>
  </div>
</template>

<script>
export default {
  methods: {
    async tomarFotos() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        const video = document.createElement('video');
        video.srcObject = stream;
        video.play();

        // Captura la imagen después de 3 segundos (puedes ajustar el tiempo)
        setTimeout(async () => {
          const canvas = document.createElement('canvas');
          canvas.width = video.videoWidth;
          canvas.height = video.videoHeight;
          const context = canvas.getContext('2d');
          context.drawImage(video, 0, 0, canvas.width, canvas.height);
          const fotoBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg'));

          // Guarda la imagen en el estado o en una variable para subirla después
          this.fotos = [fotoBlob];

          // Detiene el streaming de video
          stream.getTracks().forEach(track => track.stop());
        }, 3000); // 3 segundos de espera antes de tomar la foto
      } catch (error) {
        console.error('Error al acceder a la cámara:', error);
      }
    },
    async subirFotos() {
      if (this.fotos.length === 0) {
        console.error('No hay fotos para subir');
        return;
      }

      const formData = new FormData();
      this.fotos.forEach((foto, index) => {
        formData.append(`foto${index + 1}`, foto);
      });
      formData.append('id_usuari', 1); // ID del usuario, ajusta según sea necesario

      try {
        const response = await fetch('http://localhost:8000/api/bereal', {
          method: 'POST',
          body: formData
        });

        if (response.ok) {
          console.log('Fotos subidas correctamente');
        } else {
          console.error('Error al subir fotos');
        }
      } catch (error) {
        console.error('Error al enviar la solicitud:', error);
      }
    }
  },
  data() {
    return {
      fotos: []
    };
  }
}
</script>
