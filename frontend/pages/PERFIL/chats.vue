<template>
    <div id="container">
        <ul>
            <li v-for="user in this.usuariosConectadosSocketIds.filter(id => id !== userId)" :key="user"
                @click="storeSendingToId(user)">
                {{ user }}

            </li>
        </ul>

        <ol>
            <h1>AMIGOS</h1>
            <li v-for="amigo in amigos" :key="amigo.id">
                {{ amigo.id }}
            </li>
        </ol>

        <div id="chat">
            <div v-if="chatPrivado[recibidor_id]" class="privateChatBox">


                <div v-for="(message, index) in chatPrivado[recibidor_id]" :key="index">
                    <div v-if="message.senderId === userId" class="senderMessageBox">
                        <p> {{ message.text }}</p>
                    </div>
                    <div v-else class="recieverMessageBox">
                        <p><strong>DE {{ message.recibidor_id }} {{ message.text }}</strong></p>

                    </div>
                </div>

            </div>

            <form @submit.prevent="sendPrivateMessage">
                <input v-model="nuevoMensaje" type="text" placeholder="Write your message here..." />
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</template>

<script>
import { socket } from "../socket.js";

export default {
    data() {
        return {
            usuariosConectadosSocketIds: [],
            nuevoMensaje: '',
            userId: '',
            chatPrivado: {},
            recibidor_id: '',
        };
    },
    created() {
        if (process.client) {
            this.userId = socket.id;
            socket.emit('userJoined', socket.id);

            socket.on('updateConnectedUsers', (userIds) => {
                this.usuariosConectadosSocketIds = userIds;
            });

            socket.on('nuevoMensaje', (message) => {
                this.messages.push(message);
            });

            socket.on('privateMessageReceived', (message, senderId) => {
                if (!this.chatPrivado[senderId] || !this.chatPrivado[senderId].some(chat => chat.text === message && chat.senderId === senderId)) {
                    if (!this.chatPrivado[senderId]) {
                        this.chatPrivado[senderId] = [];
                    }
                    this.chatPrivado[senderId].push({ text: message, senderId: senderId });
                }
            });

            console.log('socketid   ' + this.userId);
        }
    },
    methods: {
        storeSendingToId(id) {
            this.recibidor_id = id;
        },
        sendPrivateMessage() {
            if (!this.recibidor_id || this.nuevoMensaje.trim() === '') {
                alert('Please select a user and enter a non-empty message.');
                return;
            }

            const message = this.nuevoMensaje;

            if (!this.chatPrivado[this.recibidor_id]) {
                this.chatPrivado[this.recibidor_id] = [];
            }
            this.chatPrivado[this.recibidor_id].push({ text: message, senderId: socket.id });

            socket.emit('sendPrivateMessage', message, this.recibidor_id, socket.id);

            this.nuevoMensaje = '';
        },
        fetchAmigos(id) {
            fetch(`http://localhost:8000/api/amigos/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching amigos');
                    }
                    return response.json();
                })
                .then(data => {
                    this.amigos = data;
                })
                .catch(error => {
                    alert('Error fetching amigos: ' + error.message)
                });
        },
        checkIfAuth() {
            const store = useStore();
            const user_id = store.return_user_id();
            console.log('user_id', user_id);
            console.log('asdsadasdsad');
            if (user_id === null) {
                alert('Necesitas estar logueado para chatear con tus amigos');
                store.set_return_path('/perfil/chats');
                this.$router.push('/login');
                localStorage.setItem('return_path', '/perfil/chats');
            }
        }
    },
    computed() {
        this.checkIfAuth();
    },
    mounted() {
        this.fetchAmigos(this.userId);
    },
    beforeMount() {
        this.checkIfAuth();
    },
};
</script>





<style scoped>
#container {
    display: flex;
    flex-direction: column;
    height: 100%;
}

#chat {
    flex: 1;
    padding: 4px;
}

.privateChatBox {
    overflow-y: auto;
    max-height: calc(100vh - 200px);
    /* Adjust height as needed */
}

.senderMessageBox,
.recieverMessageBox {
    max-width: 100%;
    padding: 4px;
    justify-content: center;

    margin: 10px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.senderMessageBox {
    background-color: #ccccccd7;
    color: black;


}

.recieverMessageBox {
    background-color: #cccccc46;
    align-self: flex-end;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 20px;
    margin-bottom: 10px;
}

button[type="submit"] {
    width: 100%;
    height: 40px;
    background-color: #25D366;
    color: #fff;
    border: none;
    border-radius: 20px;
    cursor: pointer;
}

ul li {
    padding: 10px;

    cursor: pointer;
    list-style: none;
    text-align: left;
}
</style>