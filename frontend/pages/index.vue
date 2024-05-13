    <template>

        <HeaderGeneral />
        <div class="container">
            <button class="filter-button" @click="toggleFiltro">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#5f6368">
                    <path
                        d="M440-160q-17 0-28.5-11.5T400-200v-240L168-736q-15-20-4.5-42t36.5-22h560q26 0 36.5 22t-4.5 42L560-440v240q0 17-11.5 28.5T520-160h-80Zm40-308 198-252H282l198 252Zm0 0Z" />
                </svg>
            </button>
            <div class="filter-indicator" v-if="filtroActivo">
                <select v-model="ciudadSeleccionada" @change="handleChangeCiudadSeleccionada">
                    <option disabled value="">Selecciona una ciudad</option>
                    <option v-for="(ciudad, index) in ciudades" :key="index" :value="ciudad.id">{{ ciudad.nombre }}
                    </option>
                </select>
            </div>


            <div id="buscador"></div>

            <div id="map" ref="map" style="height: 100%; width: 100%;"></div>

            <div v-if="punto_de_interes_seleccionado && pin_seleccionado" class="info-card">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ pin_seleccionado.titulo }}</h3>
                        <div class="card-closer" @click="cerrarPopUp">X</div>
                    </div>
                    <div class="card-body">
                        <img :src="pin_seleccionado.imgUrl" alt="imagen de la discoteca"
                            style="width: 100%; height: 200px; object-fit: cover;">

                        <p>Sobre el local: {{ pin_seleccionado.descripcion }}</p>
                        <p>Horario: {{ pin_seleccionado.horario }}</p>
                        <p>Telefono: {{ pin_seleccionado.telefono }}</p>
                        <p>Edad minima: {{ pin_seleccionado.minEdad }}</p>
                        <audio :src="pin_seleccionado.cancion_mp3" controls></audio>
                        <NuxtLink :to="'/' + pin_seleccionado.id" class="btn-create-review">Crear Reseña</NuxtLink>
                    </div>
                </div>
            </div>
            <FooterOptions />
        </div>

    </template>




<script>
import FooterOptions from '@/components/FooterOptions.vue';
import mapboxgl from 'mapbox-gl';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
export default {
    components: {
        FooterOptions,
    },
    head() {
        return {
            link: [
                { rel: 'stylesheet', href: 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css' },
                { rel: 'stylesheet', href: 'https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' },
            ],
            script: [
                { src: 'https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js', async: true },
                { src: 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-markercluster/v1.0.2/mapbox-gl-markercluster.js', async: true },
            ],
        };
    },
    data() {
        return {
            punto_de_interes_seleccionado: false,
            map: null,
            arr_puntos_de_interes: [],
            data: [],
            pin_seleccionado: null,
            uploadedSongUrl: null,
            icono_llevar_a_barcelona: null,
            supercluster: null,
            filtroActivo: false,
            ciudadSeleccionada: null, // Agregar ciudadSeleccionada
            ciudades: []
        };
    },
    mounted() {
        this.fetchData();
        this.fetchCiudades();
        this.initMapaDatosMapBox();

        // Notification.requestPermission().then((permission) => {
        //     if (permission === "granted") {
        //         console.log("Permisos aceptados");

        //         if ("geolocation" in navigator) {
        //             navigator.geolocation.getCurrentPosition(
        //                 (position) => {
        //                     const { latitude, longitude } = position.coords;
        //                     console.log("Ubicación del usuario:", latitude, longitude);

        //                     const coordenada1 = {
        //                         //pedralbes
        //                         latitude: 41.386181,
        //                         longitude: 2.106058,
        //                     };

        //                     const coordenada2 = {
        //                         //pacha
        //                         latitude: 41.385647,
        //                         longitude: 2.197256,
        //                     };
        //                     if (
        //                         this.personesAprop({ latitude, longitude }, coordenada1)
        //                     ) {
        //                         //pedralbes
        //                         this.programarNotificacio(9, 37);
        //                     } else if (
        //                         //pacha
        //                         this.personesAprop({ latitude, longitude }, coordenada2)
        //                     ) {
        //                         this.programarNotificacio(10, 22);
        //                     }
        //                 },
        //                 (error) => {
        //                     console.error("Error al obtener la ubicación:", error.message);
        //                 }
        //             );
        //         }
        //     }
        // });

    },

    methods: {
        handleChangeCiudadSeleccionada(event) {
            this.ciudadSeleccionada = event.target.value;

            console.log('Ciudad seleccionada:', this.ciudadSeleccionada);
            this.fetchData(); // Llamar a fetchData para obtener datos actualizados según la ciudad seleccionada
        },
        async handleFileUpload() {
            const file = this.$refs.fileInput.files[0];
            const formData = new FormData();
            formData.append('file', file);

            try {
                const response = await fetch('http://localhost:8000/api/upload', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    this.uploadedSongUrl = data.fileUrl;
                    this.pin_seleccionado.cancion_mp3 = data.fileUrl;
                } else {
                    console.error('Error al subir el archivo');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        async fetchData() {
            try {
                console.log("ahora hare un fetch")
                const response = await fetch('http://localhost:8000/api/discotecas');
                const data = await response.json();

                if (this.ciudadSeleccionada) {
                    console.log('Recuperando info de la ciudad:', this.ciudadSeleccionada);
                    console.table(data);
                    this.data = data
                        .filter(discoteca => discoteca.id_ciudad == this.ciudadSeleccionada) // Filtrar por id_ciudad
                        .map(discoteca => ({
                            id: discoteca.id,
                            titulo: discoteca.nombre_local,
                            coordenadas: JSON.parse(discoteca.coordenadas),
                            imgUrl: discoteca.imgUrl,
                            descripcion: discoteca.descripcion,
                            telefono: discoteca.telefono,
                            horario: discoteca.horario,
                            minEdad: discoteca.minEdad,
                            cancion_mp3: discoteca.canciones
                        }));
                    console.log("datos filtrados=========================");
                    console.table(this.data);

                } else {
                    this.data = data.map(discoteca => ({
                        id: discoteca.id,
                        titulo: discoteca.nombre_local,
                        coordenadas: JSON.parse(discoteca.coordenadas),
                        imgUrl: discoteca.imgUrl,
                        descripcion: discoteca.descripcion,
                        telefono: discoteca.telefono,
                        horario: discoteca.horario,
                        minEdad: discoteca.minEdad,
                        cancion_mp3: discoteca.canciones
                    }));
                }

                this.crear_mostrar_pines_discos();
                this.añadir_popup_info_de_las_discos();
            } catch (error) {
                console.error('Error al obtener los datos de las discotecas:', error);
            }
        },
        async fetchCiudades() {
            const response = await fetch('http://localhost:8000/api/ciudades');
            const data = await response.json();

            this.ciudades = data.map((ciudad) => {
                return {
                    id: ciudad.id,
                    nombre: ciudad.nombre,
                };
            });
            //console.log de la ciudad seleccionada

            console.log('Ciudades:', this.ciudades);
        },
        initMapaDatosMapBox() {
            mapboxgl.accessToken = 'pk.eyJ1IjoiaHVnb3RyaXBpYW5hIiwiYSI6ImNsczFueDBieDBiYngybG1rb2g4bGIyNW0ifQ.EECPYp9RZ_JIpjmlvyy2Hw';

            this.map = new mapboxgl.Map({
                container: this.$refs.map,
                style: 'mapbox://styles/hugotripiana/cls1o5thk00xv01pl13ze6ks0',
                center: [2.0947632393357907, 39.35567342431939],
                zoom: 0,
            });
            //hacer que los pines carguen siempre
            this.map.on('load', () => {
                this.crear_mostrar_pines_discos();
            });

            var geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl,
                marker: false
            });

            // Agregamos un listener para el evento keyup en el campo de búsqueda
            var searchBar = document.getElementById('buscador');
            searchBar.addEventListener('keyup', (event) => {
                const placeName = event.target.value.toLowerCase();
                if (placeName.includes('mya valencia')) {
                    this.mostrarMarcador([-0.3527186, 39.453452]);
                } else if (placeName.includes('sala santana')) {
                    this.mostrarMarcador([-2.8999824, 43.2502984]);
                } else if (placeName.includes('pacha')) {
                    this.mostrarMarcador([2.1971997, 41.3853718]);
                } else if (placeName.includes('fabrik')) {
                    this.mostrarMarcador([-3.8405653, 40.2653008]);
                } else if (placeName.includes('joy eslava')) {
                    this.mostrarMarcador([-3.7026, 40.4165]);
                } else if (placeName.includes('granada 10')) {
                    this.mostrarMarcador([-3.5978761, 37.1774842]);
                } else if (placeName.includes('kenbo')) {
                    this.mostrarMarcador([-0.8801567, 41.6528379]);
                } else if (placeName.includes("roca's")) {
                    this.mostrarMarcador([-3.1215182, 39.4024346]);
                } else if (placeName.includes('sala gold')) {
                    this.mostrarMarcador([-4.421322, 36.7220776]);
                } else if (placeName.includes('indara')) {
                    this.mostrarMarcador([-1.6463764, 42.8124524]);
                } else if (placeName.includes('bambu club')) {
                    this.mostrarMarcador([-4.7813695, 37.8865709]);
                } else if (placeName.includes("sithon's")) {
                    this.mostrarMarcador([-4.0217139, 39.8587244]);
                } else if (placeName.includes('sala apolo')) {
                    this.mostrarMarcador([2.1663458, 41.3714059]);
                } else if (placeName.includes("d'lio")) {
                    this.mostrarMarcador([-0.9874309, 37.601202]);
                } else if (placeName.includes('papagayo')) {
                    this.mostrarMarcador([-16.7310521, 28.0675977]);
                } else if (placeName.includes('play club')) {
                    this.mostrarMarcador([-0.3774, 39.4698]);
                } else if (placeName.includes('florida 135')) {
                    this.mostrarMarcador([0.3489, 41.5229]);
                } else if (placeName.includes('la isla')) {
                    this.mostrarMarcador([-7.8624218, 42.3362141]);
                } else if (placeName.includes('amnesia')) {
                    this.mostrarMarcador([1.3104134, 38.9944471]);
                }
            });

            this.map.addControl(geocoder);
            this.$nextTick(() => {
                var geocoderElement = document.querySelector('.mapboxgl-ctrl-geocoder');
                searchBar.appendChild(geocoderElement);
            });
        },

        mostrarMarcador(coordenadas) {
            // Redirigir al lugar específico
            this.map.flyTo({
                center: coordenadas,
                zoom: 14,
            });

            // Remover el marcador existente, si hay uno
            if (this.marker) {
                this.marker.remove();
            }

            // Agregar un nuevo marcador en las coordenadas especificadas
            this.marker = new mapboxgl.Marker()
                .setLngLat(coordenadas)
                .addTo(this.map);
        },
        crear_mostrar_pines_discos() {
            // Eliminar las capas existentes si utilizan la fuente "points"
            if (this.map.getLayer('clusters')) {
                this.map.removeLayer('clusters');
            }
            if (this.map.getLayer('cluster-count')) {
                this.map.removeLayer('cluster-count');
            }
            if (this.map.getLayer('unclustered-point')) {
                this.map.removeLayer('unclustered-point');
            }

            // Eliminar la fuente "points" si existe
            if (this.map.getSource('points')) {
                this.map.removeSource('points');
            }

            // Crear la fuente "points" y agregar las capas nuevamente
            const features = this.data.map((punto, index) => {
                const coordinates = [punto.coordenadas.lng, punto.coordenadas.lat];

                return {
                    'type': 'Feature',
                    'geometry': {
                        'type': 'Point',
                        'coordinates': coordinates,
                    },
                    'properties': {
                        'id': index,
                        'titulo': punto.titulo,
                        'horario': punto.horario,
                        'imagen': punto.imgUrl,
                        'descripcion': punto.descripcion,
                        'telefono': punto.telefono,
                        'minEdad': punto.minEdad,
                    }
                };
            });

            this.map.addSource('points', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': features
                },
                'cluster': true,
                'clusterMaxZoom': 14,
                'clusterRadius': 50
            });


            // Agregar las capas nuevamente
            this.map.addLayer({
                'id': 'clusters',
                'type': 'circle',
                'source': 'points',
                'filter': ['has', 'point_count'],
                'paint': {
                    'circle-color': [
                        'step',
                        ['get', 'point_count'],
                        '#51bbd6',
                        100,
                        '#f1f075',
                        750,
                        '#f28cb1',
                    ],
                    'circle-radius': [
                        'step',
                        ['get', 'point_count'],
                        20,
                        100,
                        30,
                        750,
                        40,
                    ],
                },
            });

            this.map.addLayer({
                'id': 'cluster-count',
                'type': 'symbol',
                'source': 'points',
                'filter': ['has', 'point_count'],
                'layout': {
                    'text-field': '{point_count_abbreviated}',
                    'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                    'text-size': 12,
                },
            });

            this.map.addLayer({
                'id': 'unclustered-point',
                'type': 'circle',
                'source': 'points',
                'filter': ['!', ['has', 'point_count']],
                'paint': {
                    'circle-color': '#11b4da',
                    'circle-radius': 8,
                    'circle-stroke-width': 1,
                    'circle-stroke-color': '#fff',
                },
            });
        },

        añadir_popup_info_de_las_discos() {
            this.map.on('click', 'clusters', (e) => {
                const features = this.map.queryRenderedFeatures(e.point, { layers: ['clusters'] });

                if (features.length > 0) {
                    const clusterId = features[0].properties.cluster_id;
                    this.map.getSource('points').getClusterExpansionZoom(clusterId, (err, zoom) => {
                        if (err) return;

                        this.map.easeTo({
                            center: features[0].geometry.coordinates,
                            zoom: zoom,
                        });
                    });
                }
            });

            this.map.on('click', 'unclustered-point', (e) => {

                if (e.features && e.features.length > 0) {
                    const id = e.features[0].properties.id;

                    if (id !== undefined && id < this.data.length) {
                        this.punto_de_interes_seleccionado = true;
                        this.pin_seleccionado = this.data[id];
                    }
                }
            });
        },
        cerrarPopUp() {
            this.punto_de_interes_seleccionado = null;
            this.pin_seleccionado = null;
        },
        clearMarkers() {
            this.arr_puntos_de_interes.forEach(marker => marker.remove());
            this.arr_puntos_de_interes = [];
        },
        personesAprop(coordenadesUsuari, coordenadaObjetiu) {
            const radiTerra = 6371;
            const lat1 = coordenadesUsuari.latitude;
            const lon1 = coordenadesUsuari.longitude;
            const lat2 = coordenadaObjetiu.latitude;
            const lon2 = coordenadaObjetiu.longitude;

            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLon = (lon2 - lon1) * (Math.PI / 180);

            //Formula per encontrar l'ubicació en coordenades
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * (Math.PI / 180)) *
                Math.cos(lat2 * (Math.PI / 180)) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distancia = radiTerra * c;

            const maxDistancia = 5; // Distancia en km
            return distancia <= maxDistancia;
        },
        // programarNotificacio(hora, minuts) {
        //     const now = new Date();
        //     const horaEspecifica = new Date(
        //         now.getFullYear(),
        //         now.getMonth(),
        //         now.getDate(),
        //         hora,
        //         minuts,
        //         0
        //     );
        //     const tempsRestant = horaEspecifica - now;

        //     if (tempsRestant > 0) {
        //         setTimeout(() => {
        //             this.enviarNotificacio();
        //         }, tempsRestant);
        //     }
        // },
        // enviarNotificacio() {
        //     const opcionesNotificacion = {
        //         body: "Es hora de publicar tu foto!",
        //     };

        //     new Notification("¡HORA DE BEREAL!", opcionesNotificacion);
        // },

        toggleFiltro() {
            // Cambiar el estado del filtro al hacer clic en el icono del mapa
            this.filtroActivo = !this.filtroActivo;
        }
    }
};
</script>



<style>
@import url('https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css');
@import url('https://fonts.googleapis.com/css2?family=Antonio:wght@700&display=swap');

.subtitle {
    font-family: "Anybody", sans-serif;
    font-size: 25px;
    font-optical-sizing: auto;
    font-weight: 800;
    /* Puedes ajustar este valor según lo necesites */
    font-style: normal;
    font-variation-settings: "wdth" 100;
    text-align: center;
    text-transform: uppercase;
    background-color: #f0f1f1
}

.filter-button {
    width: 28px;
    position: absolute;
    top: 110px;
    /* Ajusta el valor según sea necesario */
    right: 20px;
    /* Ajusta el valor según sea necesario */
    background-color: rgba(255, 255, 255, 0.7);
    /* Fondo semi-transparente para que el texto sea legible */
    border-radius: 5px;
    font-size: 16px;
    z-index: 1000;
    /* Asegura que el texto esté por encima del mapa */
}

.btn-create-review {
    background-color: var(--verde);
    display: flex;
    border-radius: 8px;
    color: var(--blanco);
    font-size: 1.5rem;
    padding: 1rem 2rem;
    text-align: center;
    width: 100%;
    justify-content: center;
    text-decoration: none;
    margin-top: 40px;
    animation: pulse 1s infinite;
}

.filter-indicator {
    position: absolute;
    left: 20px;
    /* Ajusta la posición según sea necesario */
    top: 120px;
    /* Ajusta la posición según sea necesario */
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    padding: 5px;
    border-radius: 5px;
    z-index: 1000;
}

* {
    overflow: hidden;
}

:root {
    --base: hsl(0, 5%, 16%);
    --verde: hsl(155, 81%, 46%);
    --rosa: hsl(303, 97%, 85%);
    --carne: hsl(14, 45%, 89%);
    --azul: hsl(226, 64%, 58%);
    --blanco: hsl(0, 0%, 100%);
    --base2: hsl(354, 9%, 5%);
    --verde2: hsl(0, 0%, 100%);
    --naranja: hsl(32, 85%, 76%);
    --carne2: hsl(32, 70%, 89%);
    --rojo: hsl(0, 84%, 15%);
    --azul2: hsl(213, 15%, 38%);
}

.container {
    height: 100vh;
    min-width: 100vw;
}



* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Antonio', sans-serif;
}

.navbar {
    width: 100%;
    height: 150px;
    background-color: var(--base);
}

.navbar ul {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    list-style: none;
    height: 100%;
    color: var(--blanco);
    margin-left: 10%;
}

.navbar>ul>li {
    font-size: 60px;
}

.navbar ul li {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;

}

.navbar ul li:hover,
.navbar ul li a:hover {
    color: var(--carne2);
}

.navbar ul li a {
    text-decoration: none;
    color: var(--blanco);
}

.info-card {
    position: absolute;
    top: 155px;
    right: 30px;
    z-index: 1000;
    max-width: 450px;
    background-color: var(--base);
    border-radius: 10px;
    color: var(--verde2);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.87);
    animation: fade-in 0.5s ease-in-out;
}

.card-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    animation: slideInLeft 1s ease-in-out;
}

.card-closer {
    font-size: 7vw;
    color: var(--carne2);
    transition: color 0.2s ease-in-out;
    /* align-self: flex-end; */
    position: absolute;
    /* left: 22px; */
    background-color: grey;
    border-radius: 50%;
    width: 36px;
    display: grid;
    justify-items: center;

}

.card-closer:hover {
    color: #ffffff;
}

.card-header {
    display: flex;
    background-color: var(--base2);
    border-radius: 5px 5px 0 0;
    padding: 7px;
    font-size: 6vw;
    color: var(--blanco);
    flex-direction: column;
    align-content: space-around;
    flex-wrap: wrap;
}

.audio-player {
    width: 100%;
    margin-top: 20px;
    animation: slideInRight 1s ease-in-out;
}

.card-body {
    line-height: 1.1;
    font-size: 5vw;
    display: flex;
    flex-direction: column;
    text-align: center;
}

.carousel-container {
    margin-top: 20px;
    width: 100%;
    overflow: hidden;
}

.carousel-image {
    width: 100%;
    height: auto;
}

p {
    margin: 5px;
}

.card {
    background-color: var(--base2);
    background-color: hsl(354deg 2.71% 13.94%);
    color: #fff6f6;
    border-radius: 16px;
}

.info-card {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    width: 400px;
    animation: fade-in 0.5s ease-in-out;

}

.btn-create-review {
    background-color: var(--base2);
    display: flex;
    border-radius: 8px;
    color: var(--blanco);
    font-size: 1.5rem;
    padding: 1rem 2rem;
    text-align: center;
    width: 100%;
    justify-content: center;
    text-decoration: none;
    margin-top: 40px;
}


@keyframes fade-in {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}


/* Estilos searchbar nav */
.map-container {
    height: 100%;
    width: 100%;
    animation: fadeIn 1s ease-in-out;
}

.mapboxgl-map {
    position: relative;
    width: 100%;
    height: 100%;
    top: -100px;
    background-color: #f0f1f1;
}

.mapboxgl-ctrl-geocoder {
    position: absolute;
    top: 75%;
    /* Centrar verticalmente */
    left: 50%;
    /* Centrar horizontalmente */
    transform: translate(-50%, -50%);
    /* Centrar completamente */
    z-index: 1000;
    width: 80%;
    /* Ajustar el ancho según sea necesario */
    max-width: 180px;
    /* Establecer un ancho máximo */
    height: auto;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}

.mapboxgl-ctrl-geocoder input[type="text"] {
    flex: 1;
    /* Hacer que el input ocupe todo el espacio disponible */
    background-color: rgb(255, 255, 255);
    border-radius: 30px;
    border: 1px solid rgb(101, 101, 105);
    padding: 10px;
    margin-left: 10px;
    /* Espacio entre el icono y el input */
    font-size: 16px;
    /* Tamaño de fuente ajustable */
}

.mapboxgl-ctrl-geocoder .suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    background-color: var(--verde2);
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.87);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    color: var(--base);
    width: 100%;
    /* Ancho al 100% */
    max-width: 100%;
    /* Ancho máximo al 100% */
}

.mapboxgl-ctrl-geocoder .suggestions li {
    list-style: none;
    padding: 10px;
    font-size: 16px;
    /* Tamaño de fuente */
    color: var(--verde2);
    text-justify: center;
    background-color: var(--base);
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.87);
    margin: 14px;
    border-radius: 5px;
}

.mapboxgl-ctrl-geocoder .suggestions li:hover {
    color: var(--naranja);
    cursor: pointer;
}

.mapboxgl-ctrl-geocoder .suggestions>div>a {
    color: var(--naranja);
    text-decoration: none;
    font-size: 0;
}

.mapboxgl-ctrl-geocoder--icon,
.mapboxgl-ctrl-geocoder--icon-loading {
    display: none !important;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        transform: translateX(-50px);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(50px);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.05);
    }

    100% {
        transform: scale(1);
    }
}

/* Media Queries */

@media screen and (max-width: 768px) {
    .mapboxgl-ctrl-geocoder {
        width: 90%;
        /* Reducir el ancho en pantallas más pequeñas */
    }

    .navbar {
        height: auto;
        padding: 10px;
    }

    .navbar ul {
        flex-direction: column;
        align-items: center;
    }

    .navbar ul li {
        margin: 10px 0;
    }

    .info-card {
        right: 10px;
        width: 90%;
        max-width: 90%;
    }
}

@media screen and (max-width: 480px) {
    .mapboxgl-ctrl-geocoder {
        width: 100%;
        /* Ocupar todo el ancho en pantallas muy pequeñas */
        padding: 5px;
        /* Reducir el espacio interior */
    }

    .mapboxgl-ctrl-geocoder input[type="text"] {
        font-size: 16px;
        /* Reducir el tamaño de la fuente en pantallas muy pequeñas */
    }

    .filter-button {
        top: 100px;
    }
}
</style>
