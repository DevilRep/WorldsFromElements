import Vue from 'vue'
import Router from 'vue-router'
import availableMiddlewares from './middlewares';
import routes from './routes';
import EventBus from './eventBus';

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
            if (result) {
                if (
                    typeof result === 'string' && result === from.path ||
                    typeof result === 'object' && result.path === from.path
                ) {
                    EventBus.$emit('loader:hide');
                    return next(false);
                }
                return next(result);
            }
            middlewares.shift();
            runMiddlewares(middlewares, to, from, next);
        },
        router,
        to
    );
}

let isRouterEnded = false;
EventBus.$on('router:load:check', () => {
    if (isRouterEnded) {
        return EventBus.$emit('router:loaded');
    }
    EventBus.$emit('router:loading');
});

router.beforeEach((to, from, next) => {
    isRouterEnded = false;
    EventBus.$emit('loader:show');
    if (!to.meta.middlewares) {
        return next();
    }
    let middlewares = to.meta.middlewares.slice();
    runMiddlewares(middlewares, to, from, next);
});

router.afterEach(() => {
    isRouterEnded = true;
    EventBus.$emit('loader:hide')
});

export default router;