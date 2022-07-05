<template>
    <div class="mx-auto pb-5 container-profile">
        <div class="row px-2 padding-inside pb-4">
            <h2 class="font-montserrat text-uppercase">LE TUE RICETTE PREFERITE</h2>
            <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
        </div>
        <div class="row px-2 padding-inside">
            <div class="row paddingYhome d-flex justify-content-between">
            <favorites-display
            v-for="favorite in favorites"
            :id="favorite.id"
            :name="favorite.name"
            :img="favorite.img"
            :key="favorite.id"
            @delete="del">
            </favorites-display>
        </div>
        </div>
    </div>
</template>

<script>
import FavoritesDisplay from './FavoritesDisplay.vue';
    export default {
        components: {
            FavoritesDisplay,
        },
        props: ['user'],
        created() {
            this.read();
        },
        data() {
            return {
                favorites: [],
            }
        },
        methods : {
            async read() {
                const data = await axios.get('/api/favorites/user/' + this.user.id);
                data.data.forEach(recipe => {
                this.favorites.push(recipe);
                });
            },
            async del(id) {
                await axios.delete('/api/favorites/' + id);
                let index = this.favorites.findIndex((favorite) => favorite.id === id);
                this.favorites.splice(index, 1)
            }
        }
    }
</script>

<style scoped>
@media  screen and (max-width: 577px) {
    .container-profile {
        padding-left: 0 !important;
        padding-top: 0 !important;
    }
    .padding-inside {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
}
</style>
