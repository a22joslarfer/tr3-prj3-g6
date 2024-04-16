<template>
    <div class="container">
        <div class="btn-create-holder"><button class="btn-create" @click="crear" >Crear</button></div>



        <table class="disco-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre Local</th>
                    <th>Telefono</th>
                    <th>Horario</th>
                    <th>Coordenadas</th>
                    <th>Descripcion</th>
                    <th>imgUrl</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="disco in discos" :key="disco.id" class="disco-table-item">
                    <td>{{ disco.id }}</td>
                    <td>{{ disco.nombre_local }}</td>
                    <td>{{ disco.telefono }}</td>
                    <td>{{ disco.horario }}</td>
                    <td>{{ disco.coordenadas }}</td>
                    <td>{{ disco.descripcion }}</td>
                    <td>{{ disco.imgUrl }}</td>

                    <td>
                        <div class="btn-holder">
                            <button @click="eliminar(disco.id)" class="btn-delete">Delete</button>
                            <button @click="editar_disco(disco.id)" class="btn-edit">Editar</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            discos: [],
        };
    },
    methods: {
        async fetchData() {
            try {
                const response = await fetch('http://localhost:8000/api/discotecas');
                const data = await response.json();

                if (Array.isArray(data)) {
                    this.discos = data.map((disco) => ({
                        id: disco.id,
                        nombre_local: disco.nombre_local,
                        telefono: disco.telefono,
                        horario: disco.horario,
                        coordenadas: JSON.parse(disco.coordenadas),
                        descripcion: disco.descripcion,
                        imgUrl: disco.imgUrl,
                    }));
                } else {
                    console.error('Data is not an array:', data);
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }

        },
        async eliminar(id) {
            try {
                const response = await fetch(`http://localhost:8000/api/discotecas/${id}`, {
                    method: 'DELETE',
                });
                const data = await response.json();

                if (data.status === 1) {
                    this.fetchData();
                    console.log('Usuario con id ' + id + ' eliminado', data.msg);
                } else {
                    console.error('Error deleting disco:', data.msg);
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        editar_disco(id) {
            navigateTo(`/CRUD/LOCALES/${id}`);
        },
        crear(){
            navigateTo('/CRUD/LOCALES/crear');
        }
    },
    mounted() {
        this.fetchData();
    }
};
</script>

<style lang="scss" scoped>

.btn-create:hover{
    color: whitesmoke;
}
.form-create {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 10%;
    background-color: #191a16b0;
    color: white;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-size: 20px;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow-y: scroll;
}

::-webkit-scrollbar {
    background-color: rgba(0, 0, 0, 0.034);
    width: 20px;
}

::-webkit-scrollbar-button {
    background-color: rgba(0, 0, 0, 0.034);
    width: 40px;
}

::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.247);
    width: 40px;
}

::-webkit-scrollbar-track {
    background-color: rgb(231, 221, 221);
    width: 40px;
}

.disco-table {

    background-color: #f2f2f2;
    width: 90%;
    border-collapse: collapse;
    margin-top: 15%;
}

.disco-table-item:nth-child(even) {
    background-color: #dfdfdf;
}

.disco-table-item:nth-child(odd) {
    background-color: #fff;
}

.disco-table th {
    border: 3px solid #191a16;
    padding: 20px;
    text-align: left;
}

.disco-table td {
    border: 1px solid #191a16;
    padding: 14px;
    text-align: left;
}

.btn-holder {
    display: flex;
    justify-content: space-around;

}


.btn-create-holder {
    background-color: #a0cc1c;
    position: sticky;
    top: 0;
    padding: 50px 0px;
    display: flex;
    justify-content: center;
    align-items: center;

    width: 100%;
}

.btn-create-holder>button {
    font-size: 50px;
}


.btn-delete {
    background-color: #191a16;
    color: floralwhite;
    padding: 8px 40px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;

}

.btn-edit {
    background-color: #191a16;
    color: floralwhite;
    padding: 8px 40px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}

.btn-delete:hover {

    background-color: #e60303;
}

.btn-edit:hover {

    background-color: #088ce4;
}
</style>
