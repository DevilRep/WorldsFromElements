require('./bootstrap');

window.Vue = require('vue');

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0] + '-component', files(key).default));

Vue.use(require('vue-drag-drop'));

const app = new Vue({
    el: '#app'
});

