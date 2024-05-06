<template>
    <div id="container">
        <div class="chatbox">
            <div class="message" v-for="message in messages" :key="message.id">
                <p>{{ message.text }}</p>
            </div>
            <input type="text" v-model="newMessage" @keyup.enter="sendPrivateMessage">
        </div>
    </div>
</template>

<script>
import { socket } from "../socket.js";

export default {
    data() {
        return {
            messages: [],
            newMessage: '',
            roomId: null,
            userId: null,
            chattingWithId: null,
        };
    },
    created() {
        this.checkIfAuth();
        const store = useStore();
        this.chattingWithId = store.return_chattingWithId();
        console.log('DATA FROM PINIA, CHAT WITH ' + this.chattingWithId);
        
        socket.on('getRoomId', (roomId) => {
            this.roomId = roomId;
            console.log('ROOM ID ' + this.roomId);
        });

        this.userId = store.return_user_id();

        socket.on('privateMessageReceived', ({ text, from }) => {
            this.messages.push({ text, from });
        });

        console.log(this.userId + ' USERID  ' + socket.id + ' SOCKETID');
    },
    methods: {
        sendPrivateMessage() {
            if (this.newMessage.trim() !== '') {
                console.log(this.chattingWithId + ' is sending ' + this.newMessage + ' to ' + this.userId+ ' in room ' + this.roomId);

                socket.emit('privateMessage', { to: this.chattingWithId, text: this.newMessage });
                this.newMessage = '';
            }
            console.log('SENDING MESSAGE TO ROOM ' + this.roomId + ' ' + this.userId + ' USERID  ' + socket.id + ' SOCKETID');
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
