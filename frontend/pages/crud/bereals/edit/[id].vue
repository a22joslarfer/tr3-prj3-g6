<template>
    <div class="container mt-4">
        <form @submit.prevent="editarItem()" class="mb-4">
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
            <button type="submit" class="btn btn-primary mt-2">Edit</button>
        </form>
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
        editarItem() {
            let formData = new FormData();
            if (this.img_del) {
                formData.append('img_del', this.img_del);
            }
            if (this.img_tra) {
                formData.append('img_tra', this.img_tra);
            }
            if (this.id_usuari) {
                formData.append('id_usuari', this.id_usuari);
            }
            if (this.hora) {
                formData.append('hora', this.hora);
            }

            // Log FormData entries
            for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }

            fetch(`http://localhost:8000/api/inTime/${this.$route.params.id}`, {
                method: 'PUT',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error updating item: ${response.status} ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Item updated successfully', data);
                    this.$router.push('/crud/inTimes');
                })
                .catch(error => {
                    console.error('There was an error updating the item', error);
                });
        }
        ,
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
