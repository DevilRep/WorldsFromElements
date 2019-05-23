import Vue from 'vue'
import Router from 'vue-router'
import Game from './components/game'
import Login from './components/login'
import NotFound from './components/not-found';
import availableMiddlewares from './middlewares';

Vue.use(Router);

let router = new Router({
    routes: [
        {
            path: '/',
            component: Game,
            meta: {
                middlewares: [
                    'test1', 'test2'
                ]
            }
        },
        {
            path: '/login',
            component: Login
        },
        { path: '*', component: NotFound}
    ],
    mode: 'history'
});

let runMiddlewares = function (middlewares, from, router, to) {
    let promise = Promise.resolve();
    middlewares.forEach(middleware =>
        promise = promise.then(() => {
            return new Promise((resolve, reject) => {
                availableMiddlewares[middleware](
                    result => result ? reject(result) : resolve(),
                    from,
                    router,
                    to
                )
            });
        })
    );
    return promise;
};

router.beforeEach((to, from, next) => {
    if (!to.meta.middlewares) {
        next();
    }
    runMiddlewares(to.meta.middlewares, from, router, to)
        .then(() => {
            debugger;
            next();
        })
        .catch(next)
});

export default router;