<template>
    <div>
        <ul>
            <li v-for="userId in connectedUserIds" :key="userId">{{ userId }}</li>
        </ul>
    </div>
</template>

<script>
import { socket } from "../socket.js";

export default {
    data() {
        return {
            connectedUserIds: [],
        };
    },
    created() {
        if (process.client) {
            // Generate a unique userId for this tab
            const userId = Math.random().toString(36).substring(2);

            // Emit the 'userJoined' event with the userId
            socket.emit('userJoined', userId);

            this.updateConnectedUsers();
        }
    },
    methods: {
        updateConnectedUsers() {
            socket.on('updateConnectedUsers', (userIds) => {
                this.connectedUserIds = userIds;
            });
        }
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>