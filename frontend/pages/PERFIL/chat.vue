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
                    <audio v-if="message.audio" :src="message.audio" controls></audio>
                    <video v-if="message.video" :src="message.video" controls></video>
                </div>
            </div>
            <div class="input-container">
                <input type="text" v-model="newMessage" @keyup.enter="sendPrivateMessage" placeholder="Escribe un mensaje...">
                <button @click="sendPrivateMessage">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z" />
                    </svg>
                </button>
                <button @click="startVoiceRecording" :disabled="voiceRecording">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M480-400q-50 0-85-35t-35-85v-240q0-50 35-85t85-35q50 0 85 35t35 85v240q0 50-35 85t-85 35Zm0-240Zm-40 520v-123q-104-14-172-93t-68-184h80q0 83 58.5 141.5T480-320q83 0 141.5-58.5T680-520h80q0 105-68 184t-172 93v123h-80Zm40-360q17 0 28.5-11.5T520-520v-240q0-17-11.5-28.5T480-800q-17 0-28.5 11.5T440-760v240q0 17 11.5 28.5T480-480Z" />
                    </svg>
                </button>
                <button @click="stopVoiceRecording" :disabled="!voiceRecording">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M320-320h320v-320H320v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
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
            voiceRecording: false,
            mediaStream: null,
            mediaRecorder: null
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
        startVoiceRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    this.mediaStream = stream;
                    this.mediaRecorder = new MediaRecorder(stream);
                    this.mediaRecorder.start();
                    this.mediaRecorder.ondataavailable = e => {
                        const blob = new Blob([e.data], { type: 'audio/webm' });
                        const audioURL = window.URL.createObjectURL(blob);
                        this.messages.push({ audio: audioURL, sent: true });
                    };
                    this.voiceRecording = true;
                })
                .catch(error => {
                    console.error('Error al obtener los medios:', error);
                });
        },
        stopVoiceRecording() {
            if (this.mediaRecorder && this.voiceRecording) {
                this.mediaRecorder.stop();
                this.mediaStream.getTracks().forEach(track => track.stop());
                this.voiceRecording = false;
            }
        },
        async fetch() {
            try {
                const store = useStore();
                const chattingWithId = store.return_chattingWithId();

                // Fetch de la imagen de perfil del usuario con el que estás chateando
                const profilePhotoResponse = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/profile_photo/${chattingWithId}`);
                const profilePhotoData = await profilePhotoResponse.json();

                // Asigna la URL de la foto de perfil del usuario con el que estás chateando
                this.profileImageUrl = this.getProfilePhotoUrl(profilePhotoData.path); // Suponiendo que 'path' es la propiedad que contiene la ruta de la foto de perfil en profilePhotoData
            } catch (error) {
                console.error('Error al obtener los datos del usuario:', error);
            }
        },
        getProfilePhotoUrl(photoPath) {
            // Asegúrate de ajustar la ruta según tu estructura de backend
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
svg {
    fill: white;
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
    margin-top: 10px;
    background-color: #075e48;
    color: white;
    justify-content: flex-end;
    align-self: flex-end;
    /* Alinea los mensajes enviados a la derecha */
}

.received {
    margin-top: 10px;
    margin-left: 150px;
    background-color: #5f5f5f;
    color: rgb(255, 255, 255);
    justify-content: flex-start;
    align-self: flex-start;
    /* Alinea los mensajes recibidos a la izquierda */
}
</style>
