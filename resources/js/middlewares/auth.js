export default function (req, next) {
    if (window.axios.defaults.headers.common.Authorization) {
        return next();
    }
    next('/login');
}
