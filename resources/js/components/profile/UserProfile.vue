<template>
    <div class="container pb-5">
        <div class="row px-2">
            <div class="col">
                <h2 class="font-montserrat text-uppercase">PROFILO</h2>
                <hr class="ms-2" style="border: 2px solid orange; width:60px; border-radius: 20px; opacity:1;">
                <span class="fw-bold">Name: </span><span>{{ this.user.name}}</span><br />
                <span class="fw-bold">Email: </span><span>{{ this.user.email}}</span><br />
                <span class="fw-bold">Data iscrizione: </span><span>{{ this.formatDate()  }}</span><br />
                <span class="fw-bold">Registrato come: </span><span>{{ this.role() }}</span><br />
                <div class="mt-4 mb-4" >
                    <small class="fw-bold"><u>Cambia immagine del profilo</u></small>
                    <form @submit.prevent="submitForm">
                        <input type="file" name="user_image" id="newImg" @change="uploadFile">
                        <input type="submit" class=" mt-1 btn btn-success btn-sm" id="submitBtn" value="Salva nuova immagine" style="visibility:hidden;">
                    </form>
                </div>
            </div>
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <img :src="'images/avatars/'+ this.avatar" alt="" style="width: 250px; height: 250px; object-fit:cover;" class="rounded-circle mb-2">

                 <div v-if="this.error != ''" class="alert alert-danger" role="alert">
                    <strong>{{ this.error }}</strong>
                </div>

                <div v-if="this.success != ''" class="alert alert-success" role="alert">
                    <strong>{{ this.success }}</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import FormData from 'form-data';
    export default {
        props: ['user'],
        data() {
            return {
                form: {
                    image: ''
                },
                success: '',
                error: '',
                avatar: this.user.avatar
            }
        },
        methods: {
            role() {
                switch (this.user.role) {
                    case 0:
                    return 'Fondatore';

                    case 1:
                    return 'Amministratore';

                    case 2:
                    return 'Editor';
                
                    default:
                    return 'Utente Base';
                }
            },
            uploadFile(event) {
            this.form.image = event.target.files[0];
            this.showButton();
            },
            showButton() {
                if (document.getElementById('newImg').files.length !== 0) {
                document.getElementById('submitBtn').style.visibility = 'visible';
                }
            },
            formatDate() {
                return moment(this.user.created_at).format('DD/MM/YYYY');
            },
            async submitForm() {
            this.error = '';
            this.success = '';
            let formdata = new FormData();
            formdata.append('image', this.form.image);
            formdata.append('_method', 'post')
            let config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
            await axios.post('../../api/users/updateAvatar/' + this.user.id, formdata, config)
            .then((response) => {
                console.log(response);
                this.avatar = response.data;
                this.success = 'Immagine modificata con successo!';
            })
            .catch((error) => {
                if (error.response.status == 422)
                this.error = 'Errore, riprova...'; 
            });
        },
        }
    }
</script>
