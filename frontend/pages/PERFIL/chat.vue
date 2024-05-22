<template>
    <div id="container">
        <div class="header">
            <header>{{ chattingWithIdName }}</header>
        </div>
        <div class="chatbox">
            <div class="messages">
                <div :class="['message', { 'sent': message.sent, 'received': !message.sent }]"
                    v-for="message in messages" :key="message.id">
                    <p>{{ message.text }}</p>
                </div>
            </div>
            <div class="input-container">
                <input type="text" v-model="newMessage" @keyup.enter="sendPrivateMessage"
                    placeholder="Type a message...">
                <button @click="sendPrivateMessage">Send</button>
            </div>
        </div>
    </div>
</template>

<script>
import { socket } from "../../socket.js";
import { useStore } from "../../stores/index.js";

export default {
    data() {
        return {
            messages: [],
            newMessage: '',
            userId: null,
            chattingWithId: null,
            chattingWithIdName: null,
        };
    },
    created() {
        this.checkIfAuth();
        const store = useStore();
        this.chattingWithId = store.return_chattingWithId();
        this.chattingWithIdName = store.return_chattingWithIdName();
        console.log('HABLANDO CON ' + this.chattingWithId + ' SOY ' + this.userId + ' ' + socket.id);

        this.userId = store.return_user_id();
        socket.on('privateMessageReceived', ({ text, from }) => {
            if (from != this.userId) {
                this.messages.push({ text, from, sent: false });

            }
        });
    },
    methods: {
        sendPrivateMessage() {
            if (this.newMessage.trim() !== '') {
                socket.emit('privateMessage', { from: this.userId, to: this.chattingWithId, text: this.newMessage });
                this.messages.push({ text: this.newMessage, from: this.userId, sent: true }); // Sent message
                this.newMessage = '';
            }
        },
        checkIfAuth() {
            const store = useStore();
            this.userId = store.return_user_id();

            if (this.userId === null) {
                alert('Necesitas estar logueado para chatear con tus amigos');
                store.set_return_path('/perfil/amigos');
            }
        },
    },
};
</script>


<style scoped>
#container {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.header {
    background-color: #075E54;
    color: #ffffff;
    padding: 10px 0;
    text-align: center;
}

.chatbox {
    flex: 1;
    overflow-y: auto;
}

.messages {
    margin-bottom: 60px;
    /* Adjust as necessary to accommodate input */
}

.message {
    background-color: #DCF8C6;
    border-radius: 10px;
    padding: 8px 12px;
    margin: 5px;
    max-width: 70%;
}

.message p {
    margin: 0;
}

.input-container {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #f0f0f0;
    display: flex;
    align-items: center;
    padding: 10px;
}

.input-container input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 20px;
    margin-right: 10px;
    outline: none;
}

.input-container button {
    background-color: #128C7E;
    color: #ffffff;
    border: none;
    border-radius: 20px;
    padding: 10px 20px;
    cursor: pointer;
    outline: none;
}

.input-container button:hover {
    background-color: #075E54;
}

.message {
    margin: 5px;
    padding: 10px;
    border-radius: 10px;
}

.sent {
    background-color: #007bff;
    color: white;
    text-align: right;
}

.received {
    background-color: #f0f0f0;
    color: black;
    text-align: left;
}
</style>
