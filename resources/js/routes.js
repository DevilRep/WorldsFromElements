import Vue from 'vue'
import Router from 'vue-router'
import Main from './components/main'
import Login from './components/login'

Vue.use(Router);

export default new Router({
    routes: [
        { path: '/', component: Main },
        { path: '/login', component: Login }
    ]
});