<template>
    <div>

    </div>
</template>

<script>
    export default {
        
    }
</script>


<style lang="scss" scoped>

/* ESTILOS GLOBALES ------------------------------------------------------------------------------------  */

@import url('https://fonts.googleapis.com/icon?family=Material+Icons');

header h1 {
    font-size: 60px;
    color: #723d3d;
    font-weight: 700;
    padding-left: 30px;
}


li {
    list-style: none;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-size: 30px;
}

.body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #dbdada;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;

}

.container {
    display: grid;
    grid-template-columns: 0.33fr 1fr 1fr 1fr 1fr;
    grid-template-areas:

        "header header header header header"
        "aside info-panels info-panels info-panels info-panels"
        "aside friend-list friend-list friend-list friend-list"
    ;
    grid-template-rows: auto 3fr 1fr;
    background-color: rgb(235, 225, 228);
    border-radius: 16px;
    padding: 20px;

}

.container header {
    grid-area: header;
    display: flex;
    justify-content: space-between;
    align-items: center;

    background-color: #c28383;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    border-bottom: 3px solid #4d12123d;
}

.container header * {
    margin: 10px;
}



aside {
    display: flex;
    flex-direction: column;
    background-color: #c28383;
    grid-area: aside;
}

aside li {
    padding: 10px;
    margin-top: 30px;
    background-color: #4d12123d;
    border-radius: 50%;
    height: auto;
    width: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin-left: auto;
    margin-right: auto;
}

aside li i {
    color: #723d3d;
    margin-left: auto;
    margin-right: auto;
}

aside li i:hover {
    color: #dfd9d9;

}


.searchbar {
    padding: 15px;
    border-radius: 16px;
    min-width: 700px;
    border: none;
    background-color: #fcfcfcf5;
    color: #834545;
    font-size: 40px;
    font-weight: 700;
    margin: auto;
}

.li-search-i-holder {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

}

.searchbar::placeholder {
    color: #834545;
    font-size: 40px;
    font-weight: 700;
    margin: auto;
}

.searchbar:focus {
    outline: none;
    border: 3px solid #723d3d;
}

i {
    font-size: 60px;
}

/* ESTILOS GLOBALES ------------------------------------------------------------------------------------  */


</style>