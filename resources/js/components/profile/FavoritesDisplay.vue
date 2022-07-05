<template>
    <div class="col-12 col-md-6 mb-3">
        <div class="article bg-white border rounded d-flex justify-content-center flex-column pb-2">
            <img :src="image" alt="" class="recipe-img w-100" style="object-fit:cover;">
            <a :href="this.getUrl()"><h4 class="fw-bold p-3" style="color:rgb(11, 56, 105);">{{ name }}</h4></a>
            <hr style="width: 80%;" class="mx-auto">
                <div class="interactions px-3">
                    <div class="row">
                        <div class="col-8">
                            <small>Media voti: </small><i v-for="i in this.rate" :key="i" class="fas fa-star text-warning"></i>
                        </div>
                        <div class="col d-flex justify-content-end align-item-center">
                            <a href="#" class="my-auto" @click.prevent="del()"><i class="fa-solid fa-trash-can my-auto text-danger fa-xl"></i></a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'name', 'img'],
        data() {
            return {
                rate: 0
            }
        },
        computed: {
            image() {
                return '../images/recipes_images/' + this.img;
            }
        },
        methods: {
            getUrl() {
                return '/recipes/' + this.id;
            },
            async del() {
                this.$emit('delete', this.id);
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
        },
        mounted() {
            this.getRatesAvg();
        },
    }
</script>
