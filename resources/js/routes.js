import Vue from 'vue'
import Router from 'vue-router'
import Game from './components/game'
import Login from './components/login'

Vue.use(Router);

export default new Router({
    routes: [
        { path: '/', component: Game },
        { path: '/login', component: Login }
    ]
});