<template>
    <div>
<HeaderPerfil :pageTitle="pageTitle"/>
<div class="container">
    <aside>
        <li>
            <i class="material-icons">search</i>
        </li>
        <input type="text" class="searchbar" placeholder="Buscar amigos">
    </aside>
</div>
    </div>
</template>

<script>
    export default {
        data() {
    return {
      pageTitle: 'Amigos', // Definir el título aquí en el objeto data
    }
  }
    }
</script>


<style lang="scss" scoped>


</style>