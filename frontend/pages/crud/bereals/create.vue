<template>
    <div class="container mt-4">
        <form @submit.prevent="crearNuevoItem" class="mb-4">
            <div class="form-group">
                <label for="img_del">Img Delantera</label>
                <input type="file" v-on:change="handleFrontImageUpload" class="form-control" id="img_del">
            </div>
            <div class="form-group">
                <label for="img_tra">Img Trasera</label>
                <input type="file" v-on:change="handleRearImageUpload" class="form-control" id="img_tra">
            </div>
            <div class="form-group">
                <label for="id_usuari">Id Usuari</label>
                <input type="number" v-model="id_usuari" class="form-control" id="id_usuari"
                    placeholder="Enter user ID">
            </div>
            <div class="form-group">
                <label for="hora">Hora</label>
                <input type="datetime-local" v-model="hora" class="form-control" id="hora">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
</template>





<script>
import { useStore } from "../../../stores/index";
import 'bootstrap/dist/css/bootstrap.css'
definePageMeta({
    middleware: 'admin'
});
export default {
    data() {
        return {
            img_del: '',
            img_tra: '',
            id_usuari: '',
            hora: '',
        }

    },
    head() {
        return {
            link: [
                { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css' }
            ]
        }
    },
    methods: {
        crearNuevoItem() {
            let formData = new FormData();
            formData.append('img_del', this.img_del);
            formData.append('img_tra', this.img_tra);
            formData.append('id_usuari', this.id_usuari);
            formData.append('hora', this.hora);

            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/inTime', {
                method: 'POST',
                body: formData,

            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error creating new item');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('New item created');
                    this.$router.push('/crud/inTimes');
                })
                .catch(error => {
                    console.error('There was an error creating the new item', error);
                });
        },
        handleFrontImageUpload(event) {
            this.img_del = event.target.files[0];
        },
        handleRearImageUpload(event) {
            this.img_tra = event.target.files[0];
        },


    }

}
</script>

<style scoped></style>
