<template>
<div>
    <header>
      <div class="w100 bg-white">
        <div class="row d-flex">
          <div class="col-md-2 border p-4 d-flex justify-content-center">
            <img :src="`${publicPath}/images/logo.png`" style="width:150px;" alt="Logo Azzurro Zafferano">
          </div>
          <div class="col-md-10 d-flex justify-content-around border p-4">
            <router-link :to="{name: 'adminCreate', params: {user: user} }"><button class="btn btn-success shadow-sm p-3 btn-header">New Article</button></router-link>
            <router-link to="/admin"><button class="btn btn-outline-primary shadow-sm p-3 btn-header">Articles List</button></router-link>
            <router-link :to="{name: 'adminUserList', params: {actUser: user} }"><button class="btn btn-outline-primary shadow-sm p-3 btn-header">Users List</button></router-link>
            <router-link to="/admin/rateslist"><button class="btn btn-outline-primary shadow-sm p-3 btn-header">Rates List</button></router-link>
          </div>
        </div>
      </div>
    </header>
    <div>
      <div class="row d-flex reverse"  style="min-height:90vh;">
          <div class="col-md-2 d-flex flex-column py-5 border">

              <div class="stat border m-2 pt-4 pb-1 d-flex flex-column justify-content-center align-items-center rounded shadow-sm">
                <i class="fa-solid fa-newspaper fa-xl mb-3"></i>
                <h4 class="text-center fw-bold">Total Articles</h4>
                <hr class="small-orange w-75">
                <h2>{{ this.recipesNumber }}</h2>
              </div>

              <div class="stat border m-2 pt-4 pb-1 d-flex flex-column justify-content-center align-items-center rounded shadow-sm">
                <i class="fa-solid fa-comments fa-xl mb-3"></i>
                <h4 class="text-center fw-bold">New Comments</h4>
                <h6>(24h)</h6>
                <hr class="small-orange w-75">
                <h2>{{ this.newCommentsNumber }}</h2>
              </div>

              <div class="stat border m-2 pt-4 pb-1 d-flex flex-column justify-content-center align-items-center rounded shadow-sm">
                <i class="fa-solid fa-users fa-xl mb-3"></i>
                <h4 class="text-center fw-bold">New Users</h4>
                <h6>(24h)</h6>
                <hr class="small-orange w-75">
                <h2>{{ this.newUsersNumber }}</h2>
              </div>
              <div class="d-flex w-100 mt-3">
                <a :href="this.home" class="w-100 text-center"><button class="btn btn-danger p-2 w-75 mx-auto">CLOSE</button></a>
              </div>
          </div>
          <div class="col-md-10" id="app">
            <router-view></router-view>
          </div>
      </div>
    </div>
</div>
</template>

<script>

export default {
    props: ['user'],
    data(){
       return {
        home: 'http://localhost:8000',
        recipesNumber: 0,
        newCommentsNumber: 0,
        newUsersNumber: 0,
        publicPath: window.location.origin,
        }
    },
    methods: {
      async recipesNumbers() {
          await axios.get('/api/recipes/all').then(response => {
              this.recipesNumber = response.data;
            });
        },
      async newComments() {
          await axios.get('/api/lasts/rates').then(response => {
            this.newCommentsNumber = response.data;
          });
        },
        async newUsers() {
          await axios.get('/api/users/lasts').then(response => {
            this.newUsersNumber = response.data;
          });
        },
    },
    mounted() {
      this.recipesNumbers();
      this.newComments();
      this.newUsers();
    },
  }
</script>

<style scoped>

  @media screen and (max-width: 577px) {
    .reverse {
      flex-direction: column-reverse;
    }
    .btn-header {
      padding-top: 5px !important;
      padding-bottom: 5px !important;
      margin-left: 2px;
      margin-right: 2px;
    }
  }
</style>