<template>
    <div>
        <button @click="follow(seguidoId)">Follow</button>
    </div>
</template>

<script>
export default {
    props: {
        clientId: {
            type: Number,
            required: true
        },
        seguidoId: {
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
                    seguidor: this.client_id,
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

<style scoped></style>