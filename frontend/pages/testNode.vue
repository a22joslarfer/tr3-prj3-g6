<template>
    
    <div>
        2
        {{socket.id}}
    </div>
</template>

<script>
import { socket } from "../../socket.js";

export default {
    data() {
        return {
            socket: socket,
            id: socket.id
        };
    },
}

console.log('socket' + socket);
console.log('id' + socket.id);


</script>

<style lang="scss" scoped></style>