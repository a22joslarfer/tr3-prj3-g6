<template>
    <div class="container">
        <div class="btn-create-holder"><button class="btn-create" @click="crear">Crear</button></div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" class="user-table-item">
                    <td>{{ user.id }}</td>
                    <td>{{ user.nombre }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.birthdate }}</td>
                    <td>
                        <div class="btn-holder">
                            <button @click="eliminar(user.id)" class="btn-delete">Delete</button>
                            <button @click="editar(user.id)" class="btn-edit">Editar</button>
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
            users: []
        };
    },
    methods: {
        async fetchData() {
            try {
                const response = await fetch('http://localhost:8000/api/users');
                const data = await response.json();

                if (Array.isArray(data)) {
                    this.users = data.map((usuario) => ({
                        id: usuario.id,
                        nombre: usuario.nombre,
                        email: usuario.email,
                        phone: usuario.phone,
                        birthdate: usuario.birthdate,
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
                const response = await fetch(`http://localhost:8000/api/users/${id}`, {
                    method: 'DELETE',
                });
                const data = await response.json();

                if (data.status === 1) {
                    this.fetchData();
                    console.log('Usuario con id ' + id + ' eliminado', data.msg);
                } else {
                    console.error('Error deleting user:', data.msg);
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        editar(id) {
            navigateTo(`/CRUD/USUARIOS/${id}`);
        },
        crear() {
            navigateTo('/CRUD/USUARIOS/crear');
        }
    },
    mounted() {
        this.fetchData(); // You can call fetchData on component mount
    }
};
</script>

<style lang="scss" scoped>
.btn-create-holder {
    background-color: #a0cc1c;
    position: sticky;
    top: 0px;
    padding: 50px 0px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.btn-create-holder>button {
    font-size: 50px;
}

.btn-create:hover {
    color: #fff;
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

.user-table {
    background-color: #f2f2f2;
    width: 90%;
    border-collapse: collapse;
    margin-top: 20px;
}

.user-table-item:nth-child(even) {
    background-color: #dfdfdf;
}

.user-table-item:nth-child(odd) {
    background-color: #fff;
}

.user-table th {
    border: 3px solid #191a16;
    padding: 20px;
    text-align: left;
}

.user-table td {
    border: 1px solid #191a16;
    padding: 14px;
    text-align: left;
}

.btn-holder {
    display: flex;
    justify-content: space-around;

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
