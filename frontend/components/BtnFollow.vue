<template>
    <div>
        <button class="follow-btn" @click="follow(lectorId)">Follow</button>
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
    background-color: #ff806d;
    color: #fff;
    padding: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    

}

.follow-btn:hover {
    background-color: #f3634d;
}
</style>