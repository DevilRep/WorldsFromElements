import Game from './components/game'
import Login from './components/login'
import NotFound from './components/not-found';

export default [
    {
        path: '/',
        component: Game,
        meta: {
            middlewares: [
                'auth', 'test2'
            ]
        }
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '*',
        component: NotFound
    }
];