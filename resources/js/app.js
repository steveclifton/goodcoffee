import axios from 'axios';
import packery from 'packery';
import jQ from 'jquery';
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

window.$ = jQ;
window.Packery = packery;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
});
