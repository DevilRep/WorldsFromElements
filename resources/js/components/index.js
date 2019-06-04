import Vue from 'vue';
import Element from './element';
import Game from './game';
import Login from './login';
import Main from './main';
import Modal from './modal';
import NotFound from './not-found';
import Signup from './signup';
import Header from './header';
import Loader from './loader';
import Progress from './progress';

let componentDefinitions = { Element, Game, Login, Main, Modal, NotFound, Signup, Header, Loader, Progress };
let components = {};
for (let [name, definition] of Object.entries(componentDefinitions)) {
    Vue.component(name.toLowerCase() + '-component', definition);
}

export default components;