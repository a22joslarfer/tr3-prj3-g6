<template>
  <div>
    <button @click="programarNotificacion">Programar Notificación</button>
  </div>
</template>

<script>
export default {
  methods: {
    programarNotificacion() {
      const hora = 10;
      const minutos = 55;

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
      const urlImagen = 'https://ichef.bbci.co.uk/ace/ws/640/amz/worldservice/live/assets/images/2014/08/07/140807115216_macaco2_624x351_caters.jpg';
      const idUsuario = 1;

      console.log('URL de la imagen:', urlImagen, 'ID de usuario:', idUsuario);

      fetch('api/bereals', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          foto: urlImagen,
          idUsuario: idUsuario,
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
