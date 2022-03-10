import Vue from 'vue';
import router from './router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import NavBar from '../partials/NavBar'

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.component('nav-bar', NavBar);

new Vue({
    el:'#app',
    router
})