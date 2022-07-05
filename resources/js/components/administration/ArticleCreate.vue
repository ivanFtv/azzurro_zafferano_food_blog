<template>
    <div class="container my-5 w-75 mx-auto">
        <div class="row">
            <div class="col mt-3">
                <h3 class="fw-bold">Inserisci una nuova ricetta</h3>
            </div>
        </div>
        <form class="row g-3 mt-3 p-3 border shadow-sm" @submit.prevent="submitForm">
            <div class="col-12">
                <label for="name" class="form-label">Titolo della Ricetta:</label>
                <input type="text" name="name" class="form-control" id="text" v-model="form.name"/>
            </div>
            <div class="col-12">
                <label for="image" class="form-label">Carica una foto del piatto:</label>
                <input type="file" name="image" class="form-control" id="image" @change="uploadFile"/>
            </div>
            <div class="col-12">
                <label for="ingredients" class="form-label">Ingredienti:</label><br />
                <small>Separati da una virgola (es. Pasta, Pomodoro, Basilico, ecc...)</small>
                <textarea class="form-control" name="ingredients" id="ingredients" cols="30" rows="5" v-model="form.ingredients"></textarea>
            </div>
            <div class="col-12">
                <label for="text" class="form-label">Preparazione della ricetta:</label>
                <textarea class="form-control" name="text" id="text" cols="30" rows="10" v-model="form.text"></textarea>
            </div>
            <div class="col-md-6">
                <label for="keywords" class="form-label">Tipo di preparazione:</label>
                <small>(es. pasta, pollo, manzo ecc...)</small>
                <input type="text" name="keywords" id="keywords" class="form-control" v-model="form.keywords"/>
            </div>
            <div class="col-md-6">
                <label for="category" class="form-label">Categoria:</label>
                <select id="category" name="category" class="form-select" v-model="form.category">
                    <option value="Antipasti" selected>Antipasti</option>
                    <option value="Primi Piatti">Primi Piatti</option>
                    <option value="Secondi Piatti">Secondi Piatti</option>
                    <option value="Dolci">Dolci</option>
                    <option value="Ricette Veloci">Ricette Veloci</option>
                </select>
            </div>

            <div v-if="this.error != ''" class="alert alert-danger" role="alert">
                <strong>{{ this.error }}</strong>
            </div>

             <div v-if="this.success != ''" class="alert alert-success" role="alert">
                <strong>{{ this.success }}</strong>
            </div>
           
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Salva nuova ricetta</button>
            </div>
            
        </form>
    </div>
</template>


<script> 
import FormData from 'form-data';
export default {
    props: ['user'],
    data() {
        return {
            form: {
                users_id: this.user.id,
                name: '',
                image: '',
                ingredients: '',
                text: '',
                keywords: '',
                category: '',
            },
            error: '',
            success: ''
        }
    },
    methods: {
        async submitForm() {
            this.error = '';
            this.success = '';
            let formdata = new FormData();
            formdata.append('users_id', this.form.users_id);
            formdata.append('name', this.form.name);
            formdata.append('image', this.form.image);
            formdata.append('ingredients', this.form.ingredients);
            formdata.append('text', this.form.text);
            formdata.append('keywords', this.form.keywords);
            formdata.append('category', this.form.category);
            formdata.append('_method', 'post')
            let config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
            await axios.post('../../api/recipes/create', formdata, config)
            .then((response) => {
                this.success = 'Articolo inserito con successo';
                setTimeout(() => {
                    window.location.href = "http://localhost:8000/admin/";
                }, 2000);
            })
            .catch((error) => {
                if (error.response.status == 422)
                this.error = 'Ricontrolla i campi inseriti'; 
            });
        },
        uploadFile(event) {
            this.form.image = event.target.files[0];
        }
    },
}
</script>
