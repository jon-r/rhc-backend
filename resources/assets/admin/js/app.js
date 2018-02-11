import Axios from 'axios';
import Vue from 'vue';
import VueRouter from 'vue-router';
import Buefy from 'buefy';
// import 'buefy/lib/buefy.css';

import store from './store';
import router from './router';

import AppMain from './vues/AppMain';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    Axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**

*/
Vue.use(Buefy, {defaultIconPack: 'fas'});
Vue.use(VueRouter);

Vue.component('app-main', AppMain);

const app = new Vue({
  store,
  router
}).$mount('#v-app');
