<template>
    <div>
        <button class="follow-btn" @click="follow(lectorId)">Seguir</button>
    </div>
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
            fetch('http://elysium.daw.inspedralbes.cat/backend/public/api/seguidores', {
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

<style scoped>
   .follow-btn {
        background-color: #48d454;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 12px;
    }
    .follow-btn:hover {
        background-color: #408a0e;
    }
</style>