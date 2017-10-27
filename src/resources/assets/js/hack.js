
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.trans = window.trans;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('Hackmenu', require('./components/Hackmenu.vue'));
Vue.component('Hackheader', require('./components/Hackheader.vue'));
Vue.component('Hackfooter', require('./components/Hackfooter.vue'));

const app = new Vue({
    el: '#app',
    mounted: function() {

    }
});
