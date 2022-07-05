<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-white" style="background-color:rgb(11, 56, 105);">La Tua Dashboard</div>

                <div class="card-body">
                    <div class="profile-menu d-flex justify-content-evenly">
                        <router-link to="/dash"><button class="btn btn-outline-primary btn-sm" type="button" aria-expanded="false">Profilo</button></router-link>
                        <router-link to="/dash/favorites"><button class="btn btn-outline-primary btn-sm" type="button" aria-expanded="false">Preferiti</button></router-link>
                        <router-link to="/dash/comments"><button class="btn btn-outline-primary btn-sm" type="button" aria-expanded="false">Recensioni</button></router-link>
                    </div>
                    <hr>
                    <div id="app" class="mt-5">
                        <router-view :user="this.user"></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: ['user'],  
  data () {
    return {
      message: 'This is the home component!'
    };
  }
};
</script>