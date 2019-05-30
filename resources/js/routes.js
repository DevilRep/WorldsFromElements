import Game from './components/game'
import Login from './components/login'
import Signup from './components/signup';
import NotFound from './components/not-found';

export default [
    {
        path: '/',
        component: Game,
        meta: {
            middlewares: [
                'auth'
            ]
        }
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/signup',
        component: Signup
    },
    {
        path: '*',
        component: NotFound
    }
];
