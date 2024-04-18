<template>
    <footer>
        <div class="container">
        <div class="row">
            <div class="col-md-6">
            <p>&copy; 2021 - All rights reserved</p>
            </div>
            <div class="col-md-6">
            <p class="text-right">Designed by <a href="https://www.learncodeweb.com">LearnCodeWeb</a></p>  
            </div>
        </div>
        </div>
    </footer>
</template>
<script>
export default {
    name: "Footer"
}
</script>
<style scoped>
footer {
    background: #f8f9fa;
    padding: 20px 0;
    margin-top: 20px;
}
footer p {
    margin: 0;
}
footer a {
    color: #007bff;
    text-decoration: none;
}
footer a:hover {
    text-decoration: underline;
}
</style>