<template>
    <div class="container mt-4">
        <form @submit.prevent="crearNuevoItem" class="mb-4">
            <div class="form-group">
                <label for="img_del">Img Delantera</label>
                <input type="text" v-model="img_del" class="form-control" id="img_del"
                    placeholder="Enter front image URL">
            </div>
            <div class="form-group">
                <label for="img_tra">Img Trasera</label>
                <input type="text" v-model="img_tra" class="form-control" id="img_tra"
                    placeholder="Enter rear image URL">
            </div>
            <div class="form-group">
                <label for="id_usuari">Id Usuari</label>
                <input type="number" v-model="id_usuari" class="form-control" id="id_usuari"
                    placeholder="Enter user ID">
            </div>
            <div class="form-group">
                <label for="hora">Hora</label>
                <input type="text" v-model="hora" class="form-control" id="hora" placeholder="Enter time">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
</template>





<script>
import 'bootstrap/dist/css/bootstrap.css'

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
            fetch('http://localhost:8000/api/inTimes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    img_del: this.img_del,
                    img_tra: this.img_tra,
                    id_usuari: this.id_usuari,
                    hora: this.hora,
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error creating new item');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('New item created');
                    this.$router.push('/crud/bereals');
                })
                .catch(error => {
                    console.error('There was an error creating the new item', error);
                });
        }
    }

}
</script>

<style scoped></style>
