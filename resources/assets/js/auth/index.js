import Vue from 'vue';
import Login from './components/Login';


import { BootstrapVue, BAlert } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.component('b-alert', BAlert)

import {ApiModules} from '../api/ApiModules';
const AUTHAPI = ApiModules.get('Auth');
Vue.prototype.$AuthApi = AUTHAPI;

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

new Vue({
    el:"#app",
    components:{
        Login
    }
})