<template>
    <div class="container pb-5">
        <div class="row paddingYhome">
            <h2 class="font-montserrat text-uppercase">Risultati per: {{ this.searched }}</h2>
            <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
        </div>
        <div class="row paddingYhome">
            <articles-search-display
            v-for="recipe in recipes"
            :id="recipe.id"
            :name="recipe.name"
            :img="recipe.img"
            :key="recipe.id"
            :user="user">
            </articles-search-display>
        </div>
    </div>
</template>
 
<script>
import ArticlesSearchDisplay from './ArticlesSearchDisplay.vue';
    export default {
        props: ['searched', 'recipes', 'user'],
        components: {
            ArticlesSearchDisplay,
        },
        data() {
            return {
               
            }
        },
    }
</script>
