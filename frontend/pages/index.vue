<template>
    <HeaderGeneral />
    <div class="container">
        <div id="buscador"></div>

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
        })
    }
}
