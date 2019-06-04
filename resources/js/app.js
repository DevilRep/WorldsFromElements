import './bootstrap';
import Vue from 'vue';
import './components'
import DragAndDrop from 'vue-drag-drop';
import router from './router';

Vue.use(DragAndDrop);

new Vue({
    el: '#app',
    router
});
