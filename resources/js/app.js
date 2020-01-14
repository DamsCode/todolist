/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
const axios = require('axios');
import VueRouter from "vue-router";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
Vue.use(VueRouter);
// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers['Content-Type'] = 'application/json';
axios.defaults.headers['Accept'] = 'application/json';
Vue.prototype.$http = axios;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import HomeComponent from "./components/HomeComponent.vue";
import CreateComponent from "./components/CreateComponent.vue";
import ListsComponent from "./components/todolist/ListsComponent.vue";
import EditComponent from "./components/EditComponent.vue";
import LoginComponent from "./components/user/LoginComponent.vue";
import InscriptionComponent from "./components/user/InscriptionComponent.vue";
import ProjetComponent from "./components/projet/ProjetComponent.vue";

import App from "./App.vue";


const routes = [{
    name: "login",
    path: "/login",
    component: LoginComponent
},{
    name: "signin",
    path: "/signin",
    component: InscriptionComponent
},{
    name: "home",
    path: "/",
    component: HomeComponent,
}, {
    name: "lists",
    path: "/lists",
    component: ListsComponent,
    // beforeEnter: authGuard,
}, {
    name: "listedit",
    path: "/lists/edit/:id",
    component: EditComponent,
},{
    name: "projets",
    path: "/projets",
    component: ProjetComponent,
}];

const router = new VueRouter({
    mode: "history",
    routes: routes
});

let isAuthenticated = false;
router.beforeEach((to, from, next) => {
    if (to.name === "login" || to.name === "signin" || localStorage.getItem('api_token'))
        next();
    else
        next('/login');
});

const app = new Vue(Vue.util.extend({
    router
}, App)).$mount("#todo");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

