
<template>
    <div class="bg-white rounded-lg py-4 paddingYhome border">
        <h3 class="fw-bold">Recensioni degli utenti:</h3>

        <comments-display v-if="this.data.length > 0"
        :rates="this.data"
        :users="this.users"
        :key="displayKey"></comments-display>

        <h5 class="mt-4" v-if="this.data.length < 1">Ancora nessuna recensione per questa ricetta...</h5>

        <add-comment v-if="this.user != 'guest'"
        :user="this.user"
        :recipe="this.recipe"
         @update="refresh"></add-comment>
    </div>
</template>


<script>
import CommentsDisplay from './CommentsDisplay.vue'
export default {
    components: {
        CommentsDisplay
    },
    props: ['user', 'recipe'],
    data() {
        return {
            data: [],
            users: [],
            displayKey: 0
        }
    },
    created() {
        this.getRecipeRates(),
        this.getUsers()
    },
    methods: {
        async getRecipeRates() {
             this.data = [];
            await axios.get('/api/rates/' + this.recipe.id).then(response => {
                response.data.forEach(element => {
                    this.data.push(element);
                });
            })
        },
        refresh() {
           this.getRecipeRates();
           this.displayKey ++;
        },
        async getUsers() {
            await axios.get('/api/users').then(response => {
               this.users = response.data;
            })
        },
    },
}
</script>
