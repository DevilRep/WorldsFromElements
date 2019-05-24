export default function (req, next) {
    /*if (window.axios.defaults.headers.common.Authorization) {
        return next();
    }*/
    ///next({ path: '/login' });
    setTimeout(() => {
        alert('1');
        next();
    }, 1000);
}
