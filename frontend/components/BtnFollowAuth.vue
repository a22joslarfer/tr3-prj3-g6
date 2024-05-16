<template>

    <button class="follow-btn" @click="follow(lectorId)">Seguir</button>

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
  background-color: #15a710;
  color: #fff;
  border: none;
  padding: 12px 24px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  font-weight: 600;
  border-radius: 8px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease;
  cursor: pointer;
}

.follow-btn:hover {
  background-color: #2e8307;
}
</style>