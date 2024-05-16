<template>
    <div id="container">

        <div v-for="amigo in amigos" :key="amigo.id" @click="startChatWith(amigo.id, amigo.name)">
            {{ amigo.name }}
        </div>


    </div>
</template>

<script>
import { socket } from "../../socket.js";



export default {
    data() {
        return {
            amigos: [],
            clientId: null,

        };
    },
    mounted() {
        this.checkIfAuth();
        this.getAmigos(this.clientId);
        socket.emit('userJoined', this.clientId);
    },

    methods: {
        startChatWith(chattingWithId, chattingWithIdName) {
            const store = useStore();
            store.set_chattingWithId(chattingWithId);
            store.set_chattingWithIdName(chattingWithIdName);

            console.log('guardando chattingWithId ' + chattingWithId + ' en store ' + store.return_chattingWithId());
            socket.emit('joinRoomWith', chattingWithId, this.clientId);

            this.$router.push(`/perfil/chat`);
        },
        checkIfAuth() {
            const store = useStore();
            this.clientId = store.return_user_id();
            store.set_return_path('/perfil/amigos');
            if (this.clientId === undefined || this.clientId === null) {
                alert('Necesitas  logueado para chatear con tus amigos');
                this.$router.push('/login');
            }

        },
        getAmigos(id) {
            fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/amigos/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching amigos');
                    }
                    return response.json();

                })
                .then(data => {
                    this.amigos = data;
                    if (data.length == 0) {
                        alert('No tienes amigos');
                    }
                })

                .catch(error => {
                    console.error('Error fetching amigos:', error);
                    alert('Error fetching amigos catch error');
                });

        }

    },
}
</script>
<style scoped>
#container {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

div {
    margin: 10px;
    padding: 10px;
    border: 1px solid black;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}
</style>
