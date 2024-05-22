<template>
    <div id="container">
        <div class="header">
            <header>{{ chattingWithIdName }}</header>
        </div>
        <div class="chatbox">
            <div class="messages">
                <div :class="['message', { 'sent': message.sent, 'received': !message.sent }]"
                    v-for="message in messages" :key="message.id">
                    <img :src="profileImageUrl" alt="Profile Image" class="profile-image">

                    <p>{{ message.text }}</p>
                </div>
            </div>
            <div class="input-container">
                <input type="text" v-model="newMessage" @keyup.enter="sendPrivateMessage"
                    placeholder="Escribe un mensaje...">
                <button @click="sendPrivateMessage">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                        <path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/>
                    </svg>
                </button>
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
        socket.on('privateMessageReceived', ({ text, from, fromProfilePhoto }) => {
            if (from != this.userId) {
                this.messages.push({ text, from, fromProfilePhoto, sent: false });

            }
        });
    },
    mounted() {
    this.fetch();
    },
    methods: {
        async fetch() {
          try {
            const store = useStore();
            const id = store.return_user_id();

            // Fetch de la imagen de perfil
            const profilePhotoResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/profile_photo/${id}`);
            const profilePhotoData = await profilePhotoResponse.json();
            console.log(profilePhotoData);
            this.profileImageUrl = profilePhotoData; // Suponiendo que la respuesta contiene la URL de la imagen de perfil
          } catch (error) {
            console.error('Error al obtener los datos del usuario:', error);
          }
        },
        getProfilePhotoUrl(photoPath) {
          return `http://elysium.daw.inspedralbes.cat/backend/public/${photoPath}`;
        },
        sendPrivateMessage() {
            if (this.newMessage.trim() !== '') {
                socket.emit('privateMessage', { from: this.userId, to: this.chattingWithId, text: this.newMessage });
                this.messages.push({ text: this.newMessage, from: this.userId, fromProfilePhoto: this.profileImageUrl, sent: true }); // Sent message
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
svg{
    fill:white;
}
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
}

.message {
    display: flex;
    align-items: center;
    margin: 5px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
}

.message p {
    margin: 0;
    margin-left: 10px;
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

.profile-image {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
}

.sent {
    background-color: #007bff;
    color: white;
    justify-content: flex-end;
}

.received {
    background-color: #f0f0f0;
    color: black;
    justify-content: flex-start;
}
</style>
