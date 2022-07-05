<template>
    <div class="container pb-5">
        <div class="row paddingYhome">
            <h2 class="font-montserrat text-uppercase">{{ title }}</h2>
            <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
        </div>
        <div class="row paddingYhome d-flex flex-wrap">
            <articles-display-api
            v-for="recipe in recipes"
            :id="recipe.id"
            :name="recipe.strDrink"
            :img="recipe.strDrinkThumb"
            :key="recipe.id">
            </articles-display-api>
        </div>
    </div>
</template>

<script>
import ArticlesDisplayApi from './ArticlesDisplayApi.vue';
    export default {
        components: {
            ArticlesDisplayApi,
        },
        props: ['title', 'apisrc', 'category'],
        created() {
            this.read();
        },
        data() {
            return {
                recipes: []
            }
        },
        methods : {
            async read() {
                const options = {
                    method: 'GET',
                    url: 'https://the-cocktail-db.p.rapidapi.com/filter.php',
                    params: {i: 'Gin'},
                    headers: {
                        'X-RapidAPI-Key': '0d58d0e4famsh39a33c62dadd356p14bbd4jsn07dc8d557a7f',
                        'X-RapidAPI-Host': 'the-cocktail-db.p.rapidapi.com'
                    }
                };
                let data = await axios.request(options);
                for (let i=0; i<=7; i++) {
                    this.recipes.push(data.data.drinks[i])
                }
            }
        }
    }
</script>

<style scoped>
    .paddingYhome {
        padding-left: 3rem;
        padding-right: 3rem;
    }
    .pagination-padding-desktop {
        padding-right:7em !important;
    }

    @media screen and (max-width: 597px) {
        .paddingYhome {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .pagination-padding-desktop {
            padding-right: 0.5rem !important;
        }
    }
</style>
