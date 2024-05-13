<template>
    <div>

        <div>
            <img :src="profile_photo" alt="">
        </div>


        <div>
            <header>{{ username }}</header>
        </div>

        <div>
            <span>{{ email }}</span>
        </div>

        
        <div>
            <span>{{ birthday }}</span>
        </div>

        <div>
            <span>{{ seguidores }}</span>
        </div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            id: null,
            username: null,
            email: null,
            phone: null,
            birthday: null,
            profile_photo: null,
            seguidores: null,
        };
    },
    created() {
        this.id = this.$route.params.id;
        this.getUserData();
    },
    methods: {
        async getUserData() {
            const response = await fetch(`http://elysium.daw.inspedralbes.cat/backend/public/api/users/${this.id}`);
            const data = await response.json();
            this.username = data.username;
            this.email = data.email;
           
            this.birthday = data.birthday;
            this.profile_photo = data.profile_photo;
            this.seguidores = data.seguidores;
        },

    },
};
</script>

<style scoped>

    img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    div {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    header {
        font-size: 1.5rem;
    }

    span {
        font-size: 1rem;
    }

    div {
        margin: 10px;
    }

    

</style>