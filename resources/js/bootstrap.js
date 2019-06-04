import Popper from 'popper.js';
import Bootstrap from 'bootstrap';
import jQuery from 'jquery';
import Axios from 'axios';
import VueCookies from 'vue-cookies';

window.Popper = Popper;
window.$ = window.jQuery = jQuery;

window.axios = Axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

if (VueCookies.isKey('auth')) {
    window.axios.defaults.headers.common.Authorization = 'Bearer ' + VueCookies.get('auth');
}


