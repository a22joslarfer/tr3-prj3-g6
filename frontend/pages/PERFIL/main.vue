<template>
    <div class="body">
        <div class="container">

            <header>
                <nuxt-link to="/PERFIL/main"><h1>VIAEGIS</h1></nuxt-link>

                <li class="li-search-i-holder">
                    <input type="text" placeholder="Search" class="searchbar">
                    <i class="material-icons">search</i>
                </li>

                <li @click="cambiar_tema"><i class="material-icons">contrast</i></li>

                <li><i class="material-icons">account_circle</i></li>

            </header>

            <aside>
                <ul>
                    <li @click="navigateTo_ajustes"><i class="material-icons">settings</i></li>
                    <li @click="navigateTo_favoritos"><i class="material-icons">star</i></li>
                    <li @click="navigateTo_vista"><i class="material-icons">visibility</i></li>
                    <li @click="navigateTo_info_cuenta"><i class="material-icons">person</i></li>
                    <li @click="navigateTo_chats"><i class="material-icons">chat</i></li>
                </ul>

            </aside>

            <section class="info-panels">

                <div class="main-div-1">
                    <h4>Chats recents</h4>
                    <ul>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <i class="material-icons">arrow_downward</i>
                    </ul>
                </div>

                <div class="main-div-2">
                    <h4>Locals mes transitats</h4>
                    <ul>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <li>item1</li>
                        <!--downwards arrow material icon-->
                        <i class="material-icons">arrow_downward</i>
                    </ul>
                </div>

                <div class="main-div-3">
                    <h4>Novetat!</h4>
                    <img src="https://placehold.co/200x360" alt="">
                </div>

            </section>

            <section class="friend-list">
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>
                <li><img src="https://placehold.co/100x100" alt=""></li>

            </section>


        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            // data
        }
    },
    head() {

    },
    methods: {
        navigateTo_ajustes() {
            navigateTo('ajustes');
        },
        navigateTo_favoritos() {
             navigateTo('favoritos');
        },
        navigateTo_vista() {
             navigateTo('vista');
        },
        navigateTo_info_cuenta() {
             navigateTo('info_cuenta');
        },
        navigateTo_chats() {
             navigateTo('chats');
        },
        cambiar_tema() {

        }
    },
}
</script>


<style scoped>
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

.info-panels {
    grid-area: info-panels;
    display: grid;

    grid-template-areas:
        "div1 div2 div3"
    ;
    margin: 40px;
    padding: 10px;


    gap: 20px;
}

.main-div-1 {
    grid-area: div1;
    background-color: #c2838357;
    padding: 10px;
}

.main-div-2 {
    grid-area: div2;
    background-color: #c2838357;
    padding: 10px;
}

.main-div-1 li,
.main-div-2 li {
    margin-top: 30px;
    margin-bottom: 30px;
    background-color: #4d12123d;
    height: auto;
    border-radius: 16px;
    padding: 30px;
}


.main-div-1,
.main-div-2,
.main-div-3 {
    border-radius: 0;
    border-top-left-radius: 16px;
    border-bottom-left-radius: 16px;
    border-bottom: 2px solid #723d3d;
    border-left: 5px solid #723d3d;
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


.main-div-1,
.main-div-2 {
    overflow-y: scroll;
    max-height: 700px;
    text-align: center;
    font-size: 20px;

}

.main-div-1::-webkit-scrollbar,
.main-div-2::-webkit-scrollbar
 {
    width: 10px;
    background-color: #723d3d42;
}

.main-div-1::-webkit-scrollbar-thumb,
.main-div-2::-webkit-scrollbar-thumb {
    background-color: #df5c5c83;
    border-radius: 10px;
}

.main-div-3 {
    grid-area: div3;
    background-color: #c2838357;
    padding: 10px;
    text-align: center;
    max-height: 700px;
}

::-webkit-scrollbar {
    width: 10px;
    background-color: #723d3d42;
}	

::-webkit-scrollbar-thumb {
    background-color: #df5c5c83;
    border-radius: 10px;
}

.main-div-3 img {

    border-radius: 16px;
    border: 5px solid #1d1c1c;
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
}

.info-panels ul {
    list-style: none;
    margin: 50px;
    text-align: center;

}

i {
    font-size: 60px;
}

.info-panels ul i {

    color: #723d3d;
    margin-top: 30px;
    margin-bottom: 30px;
}

.info-panels ul i:hover {
    color: #df5c5c;
}

.friend-list {
    grid-area: friend-list;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
    margin: 20px;
    margin-top: 0;
    padding: 20px;
    justify-content: space-between;
    overflow-y: scroll;
}

.friend-list li img {
    border-radius: 50%;
    border: 3px solid #18161634;
    width: 100px;
    height: 100px;
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
}

.friend-list li img:hover {
    border: 3px solid coral;

}
</style>