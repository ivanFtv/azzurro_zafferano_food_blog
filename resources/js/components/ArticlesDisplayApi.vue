<template>
    <div class="col article-square m-2 mb-5 articleSquareWidth">
        <div class="article bg-white border rounded d-flex justify-content-center flex-column pb-2">
            <a href="#"><img :src="this.img" alt="" class="recipe-img w-100" style="object-fit:cover;"></a>
            <a href="#" class="text-decoration-none"><h4 class="fw-bold p-3 overOrange" style="color:rgb(11, 56, 105);">{{ name }}</h4></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'name', 'img', 'user'],
        }
</script>

<style scoped>
    .articleSquareWidth {
        max-width: 280px; 
        min-width: 280px;
    }

    @media screen and (max-width: 597px) {
        .articleSquareWidth {
        max-width: 100%; 
    }
    }
</style>
