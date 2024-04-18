<template>
    <div class="container">
        <HeaderPerfil :pageTitle="pageTitle" />
        <!-- chats -->
        <div class="chat">
            <div class="avatar">
                <div class="info">
                    <h3>Nombre del amigo</h3>
                    <p>Último mensaje</p>
                    <p>Fecha del último mensaje</p>
                    <p>Estado del mensaje</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pageTitle: 'Chats', // Definir el título aquí en el objeto data
        }
    }
}
</script>


<style lang="scss" scoped></style>