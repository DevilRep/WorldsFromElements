import Game from './components/game'
import Login from './components/login'
import Signup from './components/signup';
import NotFound from './components/not-found';

export default [
    {
        path: '/',
        name: 'home',
        component: Game,
        meta: {
            middlewares: [
                'auth'
            ]
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/signup',
        name: 'signup',
        component: Signup
    },
    {
        path: '*',
        component: NotFound
    }
];
