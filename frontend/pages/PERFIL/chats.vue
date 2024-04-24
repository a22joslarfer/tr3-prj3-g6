<template>
    <div id="container">
        <ul>
            <li v-for="user in this.connectedUserIds.filter(id => id !== userId)" :key="user"
                @click="storeSendingToId(user)">{{ user }}</li>
        </ul>

        <div id="chat">
            <div v-if="privateChats[receiverId]" class="privateChatBox">


                <div v-for="(message, index) in privateChats[receiverId]" :key="index">
                    <div v-if="message.senderId === userId" class="senderMessageBox">
                        <p> {{ message.text }}</p>
                    </div>
                    <div v-else class="recieverMessageBox">
                        <p><strong>DE {{ message.receiverId }} {{ message.text }}</strong></p>
                        
                    </div>
                </div>

            </div>

            <form @submit.prevent="sendPrivateMessage">
                <input v-model="newMessage" type="text" placeholder="Write your message here..." />
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
            connectedUserIds: [],
            newMessage: '',
            userId: '',
            privateChats: {},
            receiverId: '',
        };
    },
    created() {
        if (process.client) {
            this.userId = socket.id;
            socket.emit('userJoined', socket.id);

            socket.on('updateConnectedUsers', (userIds) => {
                this.connectedUserIds = userIds;
            });

            socket.on('newMessage', (message) => {
                this.messages.push(message);
            });

            socket.on('privateMessageReceived', (message, senderId) => {
                if (!this.privateChats[senderId] || !this.privateChats[senderId].some(chat => chat.text === message && chat.senderId === senderId)) {
                    if (!this.privateChats[senderId]) {
                        this.privateChats[senderId] = [];
                    }
                    this.privateChats[senderId].push({ text: message, senderId: senderId });
                }
            });

            console.log('socketid   ' + this.userId);
        }
    },
    methods: {
        storeSendingToId(id) {
            this.receiverId = id;
        },
        sendPrivateMessage() {
            if (!this.receiverId || this.newMessage.trim() === '') {
                alert('Please select a user and enter a non-empty message.');
                return;
            }

            const message = this.newMessage;

            if (!this.privateChats[this.receiverId]) {
                this.privateChats[this.receiverId] = [];
            }
            this.privateChats[this.receiverId].push({ text: message, senderId: socket.id });

            socket.emit('sendPrivateMessage', message, this.receiverId, socket.id);

            this.newMessage = '';
        }
    }
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
    max-height: calc(100vh - 200px); /* Adjust height as needed */
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
    width:100%;
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
