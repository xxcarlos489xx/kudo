import Vue from 'vue'
import VueRouter from 'vue-router'

import Dashboard from './components/Dashboard';
import NotFound from '../partials/NotFound'

Vue.use(VueRouter)

const routes = [
    { path: '/dashboard', component: Dashboard, name: 'Index',props: true},
    // { path: '/admin/recursos/add', component: AddRecurso, name: 'Add' },
    { path: '*', component: NotFound ,name: 'Not Found'},
  ]

export default new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    mode: 'history',
    routes: routes
})