import Vue from 'vue'
import Router from 'vue-router'
import availableMiddlewares from './middlewares';
import routes from './routes';

Vue.use(Router);

let router = new Router({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    if (!to.meta.middlewares) {
        next();
    }
    let promise = Promise.resolve();
    to.meta.middlewares.forEach(middleware =>
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
    promise
        .then(next)
        .catch(next)
});

export default router;