import Vue from 'vue'
import Router from 'vue-router'
import availableMiddlewares from './middlewares';
import routes from './routes';

Vue.use(Router);

let router = new Router({
    routes,
    mode: 'history'
});

function runMiddlewares(middlewares, to, from, next) {
    if (!middlewares || !middlewares.length) {
        return next();
    }
    availableMiddlewares[middlewares[0]](
        from,
        result => {
            if (result instanceof Error) {
                return next(result);
            }
            middlewares.shift();
            runMiddlewares(middlewares, to, from, next);
        },
        router,
        to
    );
}

router.beforeEach((to, from, next) => {
    if (!to.meta.middlewares) {
        return next();
    }
    let middlewares = to.meta.middlewares.slice();
    runMiddlewares(middlewares, to, from, next);
});

export default router;