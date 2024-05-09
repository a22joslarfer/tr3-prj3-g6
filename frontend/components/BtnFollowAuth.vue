<template>

    <button class="follow-btn" @click="follow(lectorId)">Follow</button>

</template>

<script>
export default {
    props: {
        clientId: {
            type: Number,
            required: true
        },
        lectorId: {
            type: Number,
            required: true
        }
    },
    methods: {
        follow(seguido_id) {
            fetch('http://localhost:8000/api/seguidores', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    seguidor: this.clientId,
                    seguido: seguido_id,
                }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error adding friend: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(friend => {
                    alert('Amigo añadido');
                })
                .catch(error => {
                    console.error('Error adding friend:', error);
                    alert('Error adding friend');
                });
        },
    }
}
</script>

<style scoped>
.follow-btn {
    background-color: #ccc;
    color: #1c1c1c;
    height: 10vh;
    font-size: 4rem;
    width: 100vw;
    cursor: pointer;
    transition: background-color 0.3s;
    border: none;
}


.follow-btn:hover {
    background-color: #549419;
  
}
</style>