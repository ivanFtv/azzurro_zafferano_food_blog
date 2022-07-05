
require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(require('moment'));


import UserProfile from './components/profile/UserProfile';
import UserComments from './components/profile/UserComments';
import UserFavorites from './components/profile/UserFavorites';
import ArticlesList from './components/administration/ArticlesList';
import UsersList from './components/administration/UsersList';
import RatesList from './components/administration/RatesList';
import ArticleCreate from './components/administration/ArticleCreate';
import ArticleEdit from './components/administration/ArticleEdit';


Vue.component('articles-search-main', require('./components/search/ArticlesSearchMain.vue').default);
Vue.component('articles-search-display', require('./components/search/ArticlesSearchDisplay.vue').default);
Vue.component('articles-main', require('./components/ArticlesMain.vue').default);
Vue.component('articles-display', require('./components/ArticlesDisplay.vue').default);
Vue.component('articles-main-api', require('./components/ArticlesMainApi.vue').default);
Vue.component('suggested', require('./components/recipes/Suggested.vue').default);

Vue.component('main-profile', require('./components/profile/MainProfile.vue').default);
Vue.component('main-admin', require('./components/administration/MainAdmin.vue').default);
Vue.component('main-show', require('./components/recipes/MainShow.vue').default);
Vue.component('main-comments', require('./components/recipes/MainComments.vue').default);

Vue.component('comments-display', require('./components/recipes/CommentsDisplay.vue').default);
Vue.component('add-comment', require('./components/recipes/AddComment.vue').default);


const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/dash', component: UserProfile },
        { path: '/dash/favorites', component: UserFavorites },
        { path: '/dash/comments', component: UserComments },
        { path: '/admin', component: ArticlesList },
        { path: '/admin/userslist:actUser', name: 'adminUserList', component: UsersList, props: true },
        { path: '/admin/rateslist', component: RatesList },
        { path: '/admin/create/:user', name: 'adminCreate', component: ArticleCreate, props: true },
        { path: '/admin/edit/:recipe', name: 'edit', component: ArticleEdit, props: true },
    ]
})

const app = new Vue({
    el: '#app',
    router
});

