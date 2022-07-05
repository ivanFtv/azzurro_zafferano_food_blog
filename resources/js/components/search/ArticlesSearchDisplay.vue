<template>
    <div class="col article-square m-2 mb-5 articleSquareWidth">
        <div class="article bg-white border rounded d-flex justify-content-center flex-column pb-2">
            <a :href="recipeLink"><img :src="`${publicPath}/images/recipes_images/${this.img}`" alt="" class="recipe-img w-100" style="object-fit:cover;"></a>
            <a :href="recipeLink" class="text-decoration-none"><h4 class="fw-bold p-3 overOrange" style="color:rgb(11, 56, 105);">{{ name }}</h4></a>
            <hr style="width: 80%;" class="mx-auto mt-1 mb-3">
                <div class="interactions px-3">
                    <div class="row">
                        <div class="col-9">
                            <small>Media voti: </small><i v-for="i in this.rate" :key="i" class="fas fa-star text-warning"></i>
                           
                        </div>
                        <div v-if="this.user != 'guest'" class="col-3 d-flex justify-content-end align-item-center">
                           <a href="#" @click.prevent="addToFavorites()"><i :class="handleFavIcon"></i></a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'name', 'img', 'user'],
        data() {
            return {
                favorites: [],
                icon: 'fa-regular',
                goAnimate: '',
                recipeLink: '/recipes/' + this.id,
                rate: 0,
                publicPath: window.location.origin
            }
        },
        mounted() {
            this.read();
            this.getRatesAvg();
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
                if (this.user != null) {
                await axios({
                    method: 'post',
                    url: '/api/favorites', 
                    data: {
                    user_id: this.user.id,
                    recipe_id: this.id,
                    }
                });
                this.read();
                this.whenClicked();
                }
            },
            async read() {
                if (this.user != null) {
                const data = await axios.get('/api/favorites/user/' + this.user.id);
                for (let i = 0; i < data.data.length; i++) {
                    if (data.data[i].id == this.id) {
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
            async getRatesAvg() {
            await axios.get('/api/rate/avg/' + this.id).then(response => {
                if (response.data) {
                    this.rate = response.data;
                } else {
                    this.rate = 5;
                }
            });
        }
        }
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