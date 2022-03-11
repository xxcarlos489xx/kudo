import Vue from 'vue'
import VueRouter from 'vue-router'

import Dashboard from './components/Dashboard';
import Tablero from './components/Tablero';
import NotFound from '../partials/NotFound'

Vue.use(VueRouter)

const routes = [
    { path: '/dashboard', component: Dashboard, name: 'Index',props: true},
    { path: '/dashboard/:id', component: Tablero, name: 'Tablero' },
    { path: '*', component: NotFound ,name: 'Not Found'},
  ]

export default new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    mode: 'history',
    routes: routes
})