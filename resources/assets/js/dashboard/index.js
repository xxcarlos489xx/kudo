import Vue from 'vue';
import router from './router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import NavBar from '../partials/NavBar'
import Footer from '../partials/Footer'


Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.component('nav-bar', NavBar);
Vue.component('footer-dash', Footer);


import {ApiModules} from '../api/ApiModules';
const DASHBOARDAPI = ApiModules.get('Dashboard');
Vue.prototype.$DashboardApi = DASHBOARDAPI;

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
Vue.use(Toast);

const eventHub = new Vue();
Vue.mixin({
    data: function() {
        return {
            eventHub: eventHub
        }
    }
});

new Vue({
    el:'#app',
    router
})