<template>
    <div>
        <div class="row"><h3>Potrebbe interessarti anche:</h3>
        </div>
        <div class="row d-flex sm:flex-column">
            <articles-display class="m-4"
                v-for="suggest in suggested"
                :id="suggest.id"
                :name="suggest.name"
                :img="suggest.img"
                :key="suggest.id"
                :user="user">
                </articles-display>
        </div>
    </div>
</template>

<script>
export default {
    props: ['keywords', 'user'],
    data() {
        return{
            suggested: [],
        }
    },
    methods: {
        async read() {
            await axios.get('/api/recipes/suggested/' + this.keywords)
            .then((response) => {
                response.data.forEach(element => {
                    this.suggested.push(element);
                }); 
            });
        }
    },
    mounted() {
        this.read();
    }
}
</script>
