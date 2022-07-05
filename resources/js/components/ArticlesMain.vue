<template>
    <div class="container pb-5">
        <div class="row paddingYhome">
            <h2 class="font-montserrat text-uppercase">{{ title }}</h2>
            <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
        </div>
        <div v-if="this.recipes.length > this.perPage && this.direction == 'orizontal'" class="row" style="margin-top:-40px;">
            <nav aria-label="Page navigation example" class="d-flex justify-content-end pagination-padding-desktop">
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link rounded-circle" href="#" ref="prevpage" @click.prevent="prevPage" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item">
                    <a class="page-link rounded-circle" href="#"  ref="nextpage" @click.prevent="nextPage" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row paddingYhome">
            <articles-display
            v-for="recipe in showRecipes"
            :id="recipe.id"
            :name="recipe.name"
            :img="recipe.img"
            :key="recipe.id"
            :user="user">
            </articles-display>
        </div>
    </div>
</template>
 
<script>
import ArticlesDisplay from './ArticlesDisplay.vue';
    export default {
        components: {
            ArticlesDisplay,
        },
        props: ['title', 'category', 'user', 'direction'],
        data() {
            return {
                recipes: [],
                showRecipes: [],
                perPage: 4,
                actPage: 1
            }
        },
        methods : {
            async read() {
                await axios.get('/api/recipes/cat/' + this.category)
                .then((response) => {
                    response.data.forEach(recipe => {
                    this.recipes.push(recipe);
                    });
                });
                this.pagination();
            },
            nextPage() {
                this.actPage++;
                this.recipes.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
                this.pagination();
            },
            prevPage() {
                this.actPage--;
                this.recipes.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
                this.pagination();
            },
            checkLength(length) {
                if (this.recipes.length > length) {
                    return length
                } else {
                    return this.recipes.length
                }
            },
            pagination() {
			this.showRecipes = [];
            if (this.direction == 'orizontal') {
                for (let i = (this.actPage - 1) * this.perPage; i < (this.actPage * this.perPage) && i < this.recipes.length; i++) {
                    this.showRecipes.push(this.recipes[i]);
                }
            } else {
                this.showRecipes = this.recipes;
            }
			if (this.recipes.length > this.perPage && this.direction == 'orizontal') {
				if (this.actPage == 1) this.$refs.prevpage.style.visibility = 'hidden';
				else this.$refs.prevpage.style.visibility = 'visible';
				if (this.recipes.length <= (this.perPage * this.actPage)) this.$refs.nextpage.style.visibility = 'hidden';
				else this.$refs.nextpage.style.visibility = 'visible';
			}
        }
    },
    mounted() {
        this.read();
    },
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
            padding-left: 0.5rem !important;
        }
    }
</style> 
