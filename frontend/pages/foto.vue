<template>
  <div>
    <button @click="programarNotificacion">Programar Notificación</button>
  </div>
</template>

<script>
export default {
  methods: {
    programarNotificacion() {
      const hora = 9;
      const minutos = 37;

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
          this.mostrarAlerta();
        }, tiempoRestante);
      }
    },
    enviarNotificacion() {
      if (Notification.permission !== 'granted') {
        Notification.requestPermission().then(permission => {
          if (permission === 'granted') {
            new Notification('¡HORA DE BEREAL!', {
              body: '¡Es hora de publicar tu foto!',
            });
          }
        });
      } else {
        new Notification('¡HORA DE BEREAL!', {
          body: '¡Es hora de publicar tu foto!',
        });
      }
    },
    mostrarAlerta() {
      if (confirm('¡Es hora de penjar una foto! ¿Vols ferlo ara?')) {
        this.tomarFoto();
      }
    },
    tomarFoto() {
      navigator.mediaDevices
        .getUserMedia({ video: true })
        .then(stream => {
          const video = document.createElement('video');
          video.srcObject = stream;
          document.body.appendChild(video);
          video.play();

          setTimeout(() => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const foto = canvas.toDataURL('image/png');

            // Aquí deberías enviar la foto a tu servidor para almacenarla en la base de datos.
            console.log('Foto tomada:', foto);

            stream.getTracks().forEach(track => track.stop());
            document.body.removeChild(video);
          }, 5000); // Tiempo suficiente para que el usuario pueda posar
        })
        .catch(error => {
          console.error('Error al acceder a las cámaras:', error);
        });
    },
  },
};
</script>
