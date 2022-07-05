<template>
    <div class="container mt-5">
        <div v-show="this.display == 'block' ? true : false">
        <h5><p>Ancora nessuna recensione da mostrare...</p></h5>
        </div>
        <div v-for="(rate, index) in rates" :key="index" class="single-rate paddingYhome mb-5 p-4 border">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column align-items-start">
                    <span class="fw-bold" style="font-size: 1.2em;">{{ returnUserName(rate.user_id) }} </span>
                    <small>( Recensione del: {{ moment(rate.created_at).format('DD/MM/YYYY') }} )</small>
                </div>
                <div>
                    <i v-for="i in rate.rate_id" :key="i" class="fas fa-star text-warning"></i>
                </div>
            </div>
            <hr>
            <p class="me-5" style="font-size:1.1em;">{{ rate.comment }}</p>
        </div>

    </div>
</template>

<script>
import moment from 'moment';
export default {
    props: ['rates', 'users'],
    data() {
        return {
            display: '',
            moment: moment,
        }
    },
    methods: {
        hanldeDivDisplay() {
            if (!this.rates) {
                this.display = 'block';
            } else {
                this.display = 'none';
            }
        },
        returnUserName(id) {
            for (let i = 0; i < this.users.length; i++) {
                if (this.users[i].id == id) {
                    return this.users[i].name;
                }
            }
        }
    },
    computed: {
        getName() {
            return this.name;
        },
    },

    created() {
        this.hanldeDivDisplay();
    },
}
</script>

<style scoped>
@media screen and (max-width: 577px){
    .fa-star {
        font-size: .7em;
    }
}
</style>
