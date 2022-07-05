<template>
    <div class="container mx-auto paddingYhome">
        <div class="container mx-auto paddingYhome bg-light border main-container-show">
            <div class="header" style="position:relative;">
                <div class="recipe-title">
                    <h1 class="fw-bold">{{ this.recipe.name }}</h1>
                </div>
                <img :src="'../images/recipes_images/'+this.recipe.img" alt="" class="w-100" style="z-index:1;">
                <div class="interactive-bar">
                    <div class="fw-bold title p-2 bg-light showRecipeRateBar border">
                        <span class="rate-font-dimension">Media voti: </span><i v-for="i in Math.round(this.rate)" :key="i" class="fas fa-star fa-xl text-warning rate-font-dimension"></i>
                    </div>
                    <div v-if="this.user != 'guest'" class="fw-bold title padding-like-icon bg-light showRecipeLikeBar border">
                        <a href="#" @click.prevent="addToFavorites()"><i :class="handleFavIcon"></i></a>
                    </div>
                </div>
            </div>
            <div class="container paddingY paddingYhome body bg-white border rounded">
                <h3 class="fw-bold">Ingredienti per la ricetta:</h3>
                <div class="d-flex flex-wrap">
                    <span class="fw-bold p-2 ingredient" v-for="(ingredient, index) in ingredients" :key="index"><i class="fa-solid fa-utensils me-1" style="color:orange;"></i> {{ ingredient }}</span>
                </div>
            </div>

            <div class="container paddingY paddingYhome body body">
                <h3 class="fw-bold">Preparazione:</h3>
                <p style="white-space: pre-wrap;" class="font-text">{{ this.recipe.text  }}</p>
            </div>

            <div class="container paddingY paddingYhome body body">
                <main-comments :user="this.user" :recipe="this.recipe"></main-comments>
            </div>

            <div class="container paddingY paddingYhome body body">
                <suggested :keywords="this.recipe.keywords" :user="this.user"></suggested>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: ['recipe', 'user'],
        data() {
        return {
            favorites: [],
            icon: 'fa-regular',
            rate: 0,
            goAnimate: '',
            ingredients: [],
        }
    },
    mounted() {
        this.read();
        this.getRatesAvg();
        this.handleIngredients();
    },
    computed: {
        handleFavIcon() {
            return this.icon + ' fa-heart fa-xl text-danger ' + this.animate;
        },
        animate() {
            return this.goAnimate
        }
    },
    methods: {
        async addToFavorites() {
            if (this.user != undefined) {
            await axios({
                method: 'post',
                url: '/api/favorites', 
                data: {
                user_id: this.user.id,
                recipe_id: this.recipe.id,
                }
            });
            this.read();
            this.whenClicked();
        }
        },
        async read() {
            if (this.user != undefined) {
            const data = await axios.get('/api/favorites/user/' + this.user.id);
            for (let i = 0; i < data.data.length; i++) {
                if (data.data[i].id == this.recipe.id) {
                    this.icon = 'fa-solid';
                    break;
                } else 
                    this.icon = 'fa-regular';
            }
        }
        },
        whenClicked() {
            this.goAnimate = 'likeanimate';
            setTimeout(() => {
                this.goAnimate = '';
            }, 1000);
        },
        handleIngredients() {
            this.ingredients = this.recipe.ingredients.split(',');
            this.ingredients.forEach(element => {
                element.charAt(0).toUpperCase() + element.slice(1);
            });
        },
        async getRatesAvg() {
            await axios.get('/api/rate/avg/' + this.recipe.id).then(response => {
                if (response.data) {
                    this.rate = response.data;
                } else {
                    this.rate = 5;
                }
            });
        }
        
    },
}
</script>

<style scoped>
    .font-text {
        font-size: 1.2em;
        line-height: 1.5;
        text-align: justify;
    }
    .paddingY {
        margin-top: 1em;
        padding-top:2.5rem;  
        padding-bottom: 2.5rem; 
    }
    .ingredient {
        font-size: 1.1em;
        color: rgb(11, 56, 105);
        text-transform: capitalize;
    }

    @media screen and (max-width: 577px){
        .paddingY {
        margin-top: 0;
        padding-top:1rem;  
        padding-bottom: 1rem; 
    }
    }
</style>

