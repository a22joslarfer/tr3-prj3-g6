<template>
    <div class="container">
      <ul class='carrusel'>
        <li v-for="discoteca in data" :key="discoteca.id" class='elemento' :style="{ backgroundImage: 'url(' + discoteca.imgUrl + ')' }">
          
            <div class='contenido' @click="redirigir">
              <button @click="redirigir"  class='titulo'>{{ discoteca.titulo }}</button>
            </div>
        
        </li>
      </ul>
      <nav class='navegacion'>
        <button class='boton anterior' @click="prevElement">&lt;</button>
        <button class='boton siguiente' @click="nextElement">&gt;</button>
      </nav>
    </div>
  </template>
  
<script>

export default {
    data() {
        return {
            data: [],
            imageOptions: ['dance1.jpg', 'dance2.jpg', 'dance3.jpg']
        };
    },
    head() {
        return {
            link: [
                {
                    rel: 'stylesheet',
                    href: 'https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap'
                },
                {
                    src: 'https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js',
                    type: 'module'
                },
                {
                    src: 'https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js',
                    nomodule: true
                },

            ]
        };
    },
    methods: {
        redirigir(){
            navigateTo('/Gallery');
        },
        addEventListeners() {
            this.carrusel = this.$el.querySelector('.carrusel');

            function activar(e) {
                const elementos = document.querySelectorAll('.elemento');
                if (elementos.length > 0) {
                    e.target.matches('.siguiente') && this.carrusel.append(elementos[0]);
                    e.target.matches('.anterior') && this.carrusel.prepend(elementos[elementos.length - 1]);
                } else {
                    // Handle empty carousel (e.g., show default content or reset to the first element)
                    // For now, let's just fetch data again and render it
                    this.fetchData();
                }
            }

            document.addEventListener('click', activar.bind(this), false);
        },
        async fetchData() {

            const response = await fetch('http://localhost:8000/api/discotecas');

            const data = await response.json();

            this.data = data.map((discoteca) => {

                return {
                    id: discoteca.id,
                    titulo: discoteca.nombre_local,
                    coordenadas: JSON.parse(discoteca.coordenadas),
                    imgUrl: discoteca.imgUrl,
                    descripcion: discoteca.descripcion,
                    telefono: discoteca.telefono,
                    horario: discoteca.horario,
                    minEdad: discoteca.minEdad,
                };

            });


        },
        getRandomImage() {
            const randomIndex = Math.floor(Math.random() * this.imageOptions.length);
            const randomImage = this.imageOptions[randomIndex];
            return `url('${randomImage}')`;
        },
        prevElement() {
            const elementos = document.querySelectorAll('.elemento');
            if (elementos.length > 0) {
                this.carrusel.prepend(elementos[elementos.length - 1]);
            } else {
                // Handle empty carousel (e.g., show default content or reset to the first element)
                // For now, let's just fetch data again and render it
                this.fetchData();
            }
        },
        nextElement() {
            const elementos = document.querySelectorAll('.elemento');
            if (elementos.length > 0) {
                this.carrusel.append(elementos[0]);
            } else {
                // Handle empty carousel (e.g., show default content or reset to the first element)
                // For now, let's just fetch data again and render it
                this.fetchData();
            }
        },

    },
    mounted() {
        console.log('Component mounted. Data:', this.data);
        this.fetchData();
        this.addEventListeners();
    },
};
</script>


  
  
<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap');

:root {
    --base: hsl(0, 5%, 16%);
    --verde: hsl(155, 81%, 46%);
    --rosa: hsl(303, 97%, 85%);
    --carne: hsl(14, 45%, 89%);
    --azul: hsl(226, 64%, 58%);
    --blanco: hsl(0, 0%, 100%);
    --base2: hsl(354, 9%, 5%);
    --verde2: hsl(124, 9%, 32%);
    --naranja: hsl(32, 85%, 76%);
    --carne2: hsl(32, 70%, 89%);
    --rojo: hsl(0, 84%, 15%);
    --azul2: hsl(213, 15%, 38%);
}



* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {

    height: 100vh;
    display: grid;
    place-items: center;
    overflow: hidden;
    position: relative;
    z-index: 2;
}


.titulo {
    font-size: 48px; /* Larger font size for impact */
    font-weight: 700; /* Bolder font weight for emphasis */
    color: #ffffff; /* White text color */
    background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent black background */
    padding: 25px; /* Increased padding for a more substantial appearance */
    border-radius: 12px; /* Slightly rounded corners for a softer look */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Enhanced text shadow for visibility */
    margin-bottom: 25px; /* Adjusted margin for better spacing */
    letter-spacing: 1.5px; /* Increased letter spacing for a modern touch */
    text-align: center; /* Center-align the text */
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
}

.titulo:hover {
    background-color: rgba(0, 0, 0, 0.9); /* Darken the background on hover */
    transform: scale(1.05); /* Slightly scale up on hover for an interactive effect */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4); /* Increased shadow on hover */
}



.elemento {
    width: 300px;
    height: 550px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: -1;
    background-position: center;
    background-size: cover;
    border-radius: 1000px;
    box-shadow: -2px 4px 10px 4px #0000005d;
    scale: 1.1;
    transition: 0.1s;

}

.elemento:nth-child(1),
.elemento:nth-child(2) {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    transform: none;
    border-radius: 0;
    box-shadow: none;
    opacity: 1;
}

.elemento:nth-child(3) {
    left: 45%;
}

.elemento:nth-child(4) {
    left: calc(50% + 260px);
}

.elemento:nth-child(5) {
    left: calc(50% + 615px);
}

.elemento:nth-child(6) {
    left: calc(50% + 1060px);
    opacity: 0;
}

.elemento:nth-child(n + 7) {
    display: none;
    opacity: 0;
}

.contenido {
    width: min(30vw, 400px);
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10rem;
    opacity: 0;
    display: none;
    z-index: 1;
}   


.elemento:nth-of-type(2) .contenido {
    display: block;
    animation: mostrar 0.5s ease-in-out 0.5s forwards;
}

@keyframes mostrar {
    0% {
        filter: blur(5px);
        transform: translateY(-50%);
    }



    100% {
        opacity: 1;
        filter: blur(0);
    }
}

li::marker {
    color: #59726f00;

}

.navegacion {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);

}

.navegacion .boton {
    background-color: #2a2b2a9f; /* Green button color */
    border: none; /* Remove the border for a cleaner appearance */
    margin: 0 20px; /* Adjusted margin for better spacing */
    padding: 20px 40px; /* Increased padding for a larger size */
    border-radius: 80px; /* Larger border radius for a rounded look */
    cursor: pointer;
    color: #ffffff; /* White text color */
    font-size: 30px; /* Increased font size for better visibility */
    font-weight: 700; /* Medium font weight for balance */
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
}

.navegacion .boton:hover {
    background-color: #000000; /* Darker green button color on hover */
    box-shadow: 0 12px 24px rgba(255, 255, 255, 0.4); /* Subtle shadow on hover */
    transform: scale(1.08); /* Slightly scale up on hover for an interactive effect */
}
</style>
  