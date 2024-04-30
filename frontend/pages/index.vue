<template>
    <div class="container">

        <nav class="navbar">
            <ul>
                <li><nuxt-link to="/"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M168-114v-357l-93 72-80-109 485-379 137 107v-66h175v202l174 136-81 109-93-73v358H496v-243h-32v243H168Zm136-136h34v-233h284v233h34v-328L480-717 304-578v328Zm85-266h182q0-38-26.857-64t-64-26Q443-606 416-580t-27 64Zm-51 266v-233h284v233-233H338v233Z"/></svg></nuxt-link></li>
                <li><nuxt-link to="/explorar"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-34q-92.49 0-173.68-34.945-81.19-34.945-141.81-95.565-60.62-60.62-95.565-141.81T34-480q0-92.49 34.945-173.68 34.945-81.19 95.565-141.81 60.62-60.62 141.81-95.565T480-926q92.49 0 173.68 34.945 81.19 34.945 141.81 95.565 60.62 60.62 95.565 141.81T926-480q0 92.49-34.945 173.68-34.945 81.19-95.565 141.81-60.62 60.62-141.81 95.565T480-34Zm0-202q48.125-48.968 87-101 32-44 59-97.962 27-53.963 27-105.415Q653-613 602.5-663.5T480-714q-72 0-122.5 50.5T307-540.377q0 51.452 27 105.415Q361-381 393-337q39.438 52.032 87 101Zm0-240q-26 0-45.5-18.882-19.5-18.883-19.5-45.5Q415-567 434.5-586q19.5-19 45.5-19t45.5 19q19.5 19 19.5 45.5T525.5-495Q506-476 480-476Z"/></svg></nuxt-link></li>
                <li><nuxt-link to="/PERFIL/main"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480.159-502Q395-502 336.5-561 278-620 278-704.5T336.341-847q58.34-58 143.5-58Q565-905 623.5-847.112 682-789.225 682-704q0 84-58.341 143-58.34 59-143.5 59ZM114-86v-159q0-46.774 23.789-84.467Q161.578-367.161 201-387q66-34 136.174-51t142.541-17Q554-455 624-438t135 50q39.422 19.693 63.211 57.111Q846-293.472 846-245.055V-86H114Zm136-136h460v-18q0-10.029-4.875-17.801Q700.25-265.572 692-269q-48-24-102-37t-110.5-13q-54.5 0-110 13T268-269q-8.25 2.428-13.125 10.699Q250-250.029 250-240v18Zm229.965-416Q507-638 526.5-657.465q19.5-19.464 19.5-46.5Q546-731 526.535-750.5q-19.464-19.5-46.5-19.5Q453-770 433.5-750.319 414-730.638 414-704q0 27.05 19.465 46.525Q452.929-638 479.965-638Zm.035-66Zm0 482Z"/></svg></nuxt-link></li>
                <li><nuxt-link to="/Register"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M472-74v-136h278v-540H472v-136h278q57.125 0 96.562 39.438Q886-807.125 886-750v540q0 57.125-39.438 96.562Q807.125-74 750-74H472ZM348-217l-96-96 99-99H74v-136h277l-99-99 96-96 262 263-262 263Z"/></svg></nuxt-link></li>
            </ul>
        </nav>
       <!---<li id="buscador"></li>--> 

        <div id="map" ref="map" style="height: 100%; width: 100%;"></div>

        <div v-if="punto_de_interes_seleccionado && pin_seleccionado" class="info-card">
            <div class="card">
                <div class="card-header">
                    <h3>{{ pin_seleccionado.titulo }}</h3>
                    <div class="card-closer" @click="cerrarPopUp">X</div>
                </div>
                <div class="card-body">
                    <img :src="'https://via.placeholder.com/200'" alt="imagen de la discoteca"
                        style="width: 100%; height: 200px; object-fit: cover;">

                    <p>Sobre el local: {{ pin_seleccionado.descripcion }}</p>
                    <p>Horario: {{ pin_seleccionado.horario }}</p>
                    <p>Telefono: {{ pin_seleccionado.telefono }}</p>
                    <p>Edad minima: {{ pin_seleccionado.minEdad }}</p>
                    <NuxtLink :to="'/' + pin_seleccionado.id" class="btn-create-review">Crear Reseña</NuxtLink>
                </div>
            </div>
        </div>
        <footer>

        </footer>
    </div>
</template>

   

<script>
import mapboxgl from 'mapbox-gl';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';

export default {

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
            marker: null,
            data: [],
            icono_llevar_a_barcelona: null,
            supercluster: null,
            pin_seleccionado: null,

        };
    },
    mounted() {
        this.fetchData();
        this.initMapaDatosMapBox();

        Notification.requestPermission().then((permission) => {
            if (permission === "granted") {
                console.log("Permisos aceptados");

                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const { latitude, longitude } = position.coords;
                            console.log("Ubicación del usuario:", latitude, longitude);

                            const coordenada1 = {
                                //pedralbes
                                latitude: 41.386181,
                                longitude: 2.106058,
                            };

                            const coordenada2 = {
                                //pacha
                                latitude: 41.385647,
                                longitude: 2.197256,
                            };
                            if (
                                this.personesAprop({ latitude, longitude }, coordenada1)
                            ) {
                                //pedralbes
                                this.programarNotificacio(9, 37);
                            } else if (
                                //pacha
                                this.personesAprop({ latitude, longitude }, coordenada2)
                            ) {
                                this.programarNotificacio(10, 22);
                            }
                        },
                        (error) => {
                            console.error("Error al obtener la ubicación:", error.message);
                        }
                    );
                }
            }
        });

    },

    methods: {
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

            this.crear_mostrar_pines_discos();
            this.añadir_popup_info_de_las_discos();


        },
        initMapaDatosMapBox() {
            mapboxgl.accessToken = 'pk.eyJ1IjoiYTIyam9zbGFyZmVyIiwiYSI6ImNsczFsbmZrcjBjZ2cyaXF3ZXd6a2JqdHgifQ.cf30m6MLwvix5IxPHsF00A';

            this.map = new mapboxgl.Map({
                container: this.$refs.map,
                style: 'mapbox://styles/a22joslarfer/cls1zmqwn00h801qqeeu22coz',
                center: [2.0947632393357907, 39.35567342431939],
                zoom: 5,
            });

            var geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl
            });

            this.map.addControl(geocoder);
            this.$nextTick(() => {
                var geocoderElement = document.querySelector('.mapboxgl-ctrl-geocoder');
                var searchBar = document.getElementById('buscador');
                searchBar.appendChild(geocoderElement);
            });
        },
        crear_mostrar_pines_discos() {

            if (this.map.getSource('points')) {
                this.map.removeSource('points');
            }

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
        programarNotificacio(hora, minuts) {
            const now = new Date();
            const horaEspecifica = new Date(
                now.getFullYear(),
                now.getMonth(),
                now.getDate(),
                hora,
                minuts,
                0
            );
            const tempsRestant = horaEspecifica - now;

            if (tempsRestant > 0) {
                setTimeout(() => {
                    this.enviarNotificacio();
                }, tempsRestant);
            }
        },
        enviarNotificacio() {
            const opcionesNotificacion = {
                body: "Es hora de publicar tu foto!",
            };

            new Notification("¡HORA DE BEREAL!", opcionesNotificacion);
        },

    },
};

</script>
  


<style scoped>
@import url('https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css');
@import url('https://fonts.googleapis.com/css2?family=Antonio:wght@700&display=swap');

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
}

* {
    box-sizing: border-box;
    font-family: "Antonio", sans-serif;
    margin: 0;
    padding: 0px;
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
    --verde2: hsl(124, 9%, 32%);
    --naranja: hsl(32, 85%, 76%);
    --carne2: hsl(32, 70%, 89%);
    --rojo: hsl(0, 84%, 15%);
    --azul2: hsl(213, 15%, 38%);
}

.container {
    height: 100vh;
    min-width: 100vw;
}

footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 50px;
    background-color: #d2d2d2;
}

svg{
    width: 50px;
    height: 50px;
    fill: black;
   
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
    background-color: whitesmoke;
}

.navbar ul {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    list-style: none;
    height: 100%;
    color: var(--blanco);
    
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
    top: 0px;
    right: 5px;
    left: 5px;
    margin-left: auto;
    margin-right: auto;
    height: auto;
    z-index: 1000;
    max-width: auto;
    background-color: var(--base);
    border-radius: 10px;
    color: var(--verde2);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.87);
    animation: fade-in 0.5s ease-in-out;
   
}

.card-closer {
    cursor: pointer;
    font-size: 2vw;
    color: var(--base);
    transition: color 0.2s ease-in-out;
}

.card-closer:hover {
    color: #ffffff;
}

.card-header {
    display: flex;
    
    justify-content: center;
    background-color: var(--verde2);
    border-radius: 5px 5px 0 0;
    padding: 4px;
    font-size: 2vw;
    color: var(--base);
}

.card-body {
    text-align: justify;
    margin: 4px;
    padding: 10px;
    line-height: 1.1;
    font-size: 1.2vw;
}

@media only screen and (max-width: 768px) {
    .navbar {
        font-size: 20px;
        height: 100px;
    }

    .navbar ul li {
        font-size: 30px;
    }

    .info-card {
        top: 105px;
        right: 10px;
        max-width: 350px;
    }

    .card-header>h3 {
        font-size: 30px;
    }

    .card-body {
        font-size: 20px;
    }
}


/* Estilos searchbar nav */

.mapboxgl-ctrl-geocoder {
    position: absolute;
    top: 40px;
    left: 10px;
    z-index: 1000;
    width: auto;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.87);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;

}

.mapboxgl-ctrl-geocoder input[type="text"] {
    background-color: var(--base);
    border: none;
    color: var(--verde2);
    font-size: 1.5vw;
    padding: 10px;
}


.mapboxgl-ctrl-geocoder button {
    background-color: var(--verde2);
    font-size: .5vw;
    padding: 10px;
    border-radius: 20px;
}

.mapboxgl-ctrl-geocoder .suggestions {
    position: absolute;
    top: 100px;
    left: 10px;
    z-index: 1000;
    background-color: var(--verde2);
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.87);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    color: var(--base);

}

.mapboxgl-ctrl-geocoder .suggestions li {
    list-style: none;
    padding: 10px;
    font-size: 1.2vw;
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
</style>