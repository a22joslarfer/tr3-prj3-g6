<template>
    <div id="container">
        <div>
            <header>{{ chattingWithIdName }}</header>
        </div>
        <div class="chatbox">
            <div class="message" v-for="message in messages" :key="message.id">
                <p>{{ message.text }}</p>
            </div>
            <input type="text" v-model="newMessage" @keyup.enter="sendPrivateMessage">
        </div>
    </div>
</template>
<script>
import { socket } from "../node/socket.js";
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

        console.log('mensaje: ' + text + ' de: ' + from);
        this.messages.push({ text, from });
        });
    },
    methods: {
        sendPrivateMessage() {
            if (this.newMessage.trim() !== '') {

                socket.emit('privateMessage', { from: this.userId, to: this.chattingWithId, text: this.newMessage });
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
