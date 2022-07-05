<template>
    <div class="bg-white rounded-lg shadow p-3 border mx-auto mt-5 add-review-container">
        <h4 class="fw-bold">Dicci anche il tuo parere:</h4>
        <div class="container p-2">
            <form>
                <div class="mb-3">
                    <div class="mb-3">
                    <span :class="showTextColor">{{ this.userMessage }}</span>
                    <fieldset>
                        <span class="star-cb-group" :style="{'pointer-events':(pointerEvents)}">
                        <input type="radio" id="rating-5" name="rating" value="5" v-model="selectedStars" /><label for="rating-5" :style="{'pointer-events':(pointerEvents)}">5</label>
                        <input type="radio" id="rating-4" name="rating" value="4" v-model="selectedStars" checked="checked" /><label for="rating-4" :style="{'pointer-events':(pointerEvents)}">4</label>
                        <input type="radio" id="rating-3" name="rating" value="3" v-model="selectedStars" /><label for="rating-3" :style="{'pointer-events':(pointerEvents)}">3</label>
                        <input type="radio" id="rating-2" name="rating" value="2" v-model="selectedStars" /><label for="rating-2" :style="{'pointer-events':(pointerEvents)}">2</label>
                        <input type="radio" id="rating-1" name="rating" value="1" v-model="selectedStars" /><label for="rating-1" :style="{'pointer-events':(pointerEvents)}">1</label>
                        <input type="radio" id="rating-0" name="rating" value="0" v-model="selectedStars" class="star-cb-clear" /><label for="rating-0" :style="{'pointer-events':(pointerEvents)}">0</label>
                        </span>
                    </fieldset>
                    </div>
                    <textarea class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="message" required :disabled="this.disabled">Scrivi un commento</textarea>
                </div>
                <button v-if="!this.disabled" type="submit" class="btn btn-success" @click.prevent="sendReview()">Invia recensione</button>
            </form>
        </div>
    </div>
</template>


<script>

import CommentsDisplay from './CommentsDisplay.vue'
export default {
    props: ['user', 'recipe'],
    components: {
        CommentsDisplay
    },
    data() {
        return {
            selectedStars: 4,
            message: '',
            userMessage: 'Valuta la ricetta:',
            disabled: false,
            textColor: 'text-black',
            pointerEvents: ''
        }
    },
    methods: {
        sendReview() {
            const data = {
                user_id: this.user.id,
                recipe_id: this.recipe.id,
                stars: this.selectedStars,
                comment: this.message,
            }
            axios.post('/api/rates/new', data).then(response => {
                this.selectedStars = this.defaultstars;
                this.message = '';
                this.$emit('update');
            })
            this.checkUserRewiev();
        },
        async checkUserRewiev() {
            await axios.get('/api/rates/' + this.user.id + '/' + this.recipe.id).then(response => {
                if (response.data) {
                    this.selectedStars = response.data.rate_id;
                    this.message = response.data.comment;
                    this.disabled = true;
                    this.userMessage = 'Hai già valutato questa ricetta!';
                    this.textColor = 'text-danger';
                    this.pointerEvents = 'none';
                }
            })
        }
    },
    created() {
        this.checkUserRewiev();
    },
    computed: {
        showTextColor() {
            return this.textColor;
        }
    }
}
</script>

<style scoped>
 .add-review-container {
    width: 75%;
 }

 @media screen and (max-width: 577px) {
   .add-review-container {
    width: 100%;
 }
 }
</style>
