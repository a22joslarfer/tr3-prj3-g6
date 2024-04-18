<template>
  <div>
    <button @click="tomarFoto">Tomar Foto</button>
  </div>
</template>

<script>
export default {
  mounted() {
    this.programarNotificacion();
  },
  methods: {
    programarNotificacion() {
      const hora = 11;
      const minutos = 54;

      const now = new Date();
      const horaEspecifica = new Date(
        now.getFullYear(),
        now.getMonth(),
        now.getDate(),
        hora,
        minutos,
        0
      );
      const tiempoRestante = horaEspecifica - now;

      if (tiempoRestante > 0) {
        setTimeout(() => {
          this.enviarNotificacion();
        }, tiempoRestante);
      }
    },
    enviarNotificacion() {
      if (Notification.permission !== 'granted') {
        Notification.requestPermission().then(permission => {
          if (permission === 'granted') {
            this.mostrarAlerta();
          }
        });
      } else {
        this.mostrarAlerta();
      }
    },
    mostrarAlerta() {
      if (confirm('¡Es hora de penjar una foto! ¿Vols ferlo ara?')) {
        this.tomarFoto();
      }
    },
    tomarFoto() {
      if (!('mediaDevices' in navigator)) {
        alert('Tu navegador no soporta la captura de imágenes.');
        return;
      }

      navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
          const video = document.createElement('video');
          video.srcObject = stream;
          video.play();

          const canvas = document.createElement('canvas');
          const context = canvas.getContext('2d');

          setTimeout(() => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const fotoURL = canvas.toDataURL('image/jpeg');

            // Mostrar la foto capturada (opcional)
            const imgPreview = new Image();
            imgPreview.src = fotoURL;
            document.body.appendChild(imgPreview);

            // Guardar la foto en la base de datos
            const idUsuario = 1; // ID de usuario predeterminado
            this.guardarFotoEnBaseDeDatos(fotoURL, idUsuario);

            stream.getTracks().forEach(track => track.stop());
          }, 1000); // Esperar un segundo antes de tomar la foto
        })
        .catch(error => {
          console.error('Error al acceder a la cámara:', error);
        });
    },
    guardarFotoEnBaseDeDatos(fotoURL, idUsuario) {
      fetch('http://localhost:8000/api/bereal', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          img_del: fotoURL,
          img_tra: fotoURL,
          id_usuari: idUsuario,
        }),
      })
        .then(response => {
          if (response.ok) {
            console.log('La foto se guardó correctamente en la base de datos.');
          } else {
            throw new Error('Error al guardar la foto en la base de datos.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    },
  },
};
</script>
