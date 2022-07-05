<template>
    <div class="pb-5">
        <div class="row px-2">
            <h2 class="font-montserrat text-uppercase">VALUTAZIONI LASCIATE</h2>
            <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
        </div>
        <div class="d-flex">
            <div class="d-flex flex-column">
                <div class="px-2 py-2 d-flex justify-content-between" v-for="rate in rates" :key="rate.id">
                    <span class="p-2 border-end fw-bold">{{ moment(rate.created_at).format('DD/MM/YY') }}</span>
                </div>
            </div>
            
            <div class="d-flex flex-column w-20">
                <div class="px-2 py-2 d-flex justify-content-between" v-for="recipe in recipes" :key="recipe.id">
                    <span class="p-2 fw-bold">{{ recipe.name }}</span>
                    
                </div>
            </div>

            <div class="d-flex flex-column">
                <div class="px-2 py-2 d-flex justify-content-between" style="min-width:500px;" v-for="rate in rates" :key="rate.id">
                    <span class="p-2 border-start">{{ rate.comment }}</span>
                    <a :href="recipeLink(rate.recipe_id)"><span class="btn btn-sm btn-outline-success ms-auto" style="width:100px;">Vai alla ricetta</span></a>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
import moment from 'moment';
    export default {
        props: ['user'],
        data() {
            return {
                rates: [],
                recipes: [],
                moment: moment,
            }
        },
        created() {
            this.read();
        },
        methods : {
            async read() {
                const data = await axios.get('/api/user/comments/' + this.user.id);
                data.data.rates.forEach(rate => {
                this.rates.push(rate);
                });
                data.data.recipes.forEach(recipe => {
                this.recipes.push(recipe);
                });
            },

            recipeLink(id) {
                return'/recipes/' + id;
             }
        }
    }
</script>
