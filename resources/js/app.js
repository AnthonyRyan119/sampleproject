/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import "bootstrap/dist/css/bootstrap.css";
import BootstrapVue from 'bootstrap-vue';
import "bootstrap-vue/dist/bootstrap-vue.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import moment from 'moment';
import { VueEditor } from "vue2-editor";
import VueApexCharts from 'vue-apexcharts';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(VueSweetalert2);
Vue.component('v-select', vSelect);
Vue.use(VueApexCharts);
Vue.component('apexchart', VueApexCharts);

Vue.prototype.$page_options = [
    { value: 'All', text: 'All' },
    { value: '5', text: '5' },
    { value: '10', text: '10' },
    { value: '50', text: '50' },
    { value: '100', text: '100' },
];

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Master
// TopBar
Vue.component('master-top-bar', require('./components/Master/TopBar.vue').default);
// SideBar
Vue.component('master-side-bar', require('./components/Master/SideBar.vue').default);
// Footer
Vue.component('master-footer', require('./components/Master/Footer.vue').default);

// Dashboard
Vue.component('dashboard', require('./components/DashboardComponent.vue').default);

// User
Vue.component('User', require('./components/UserComponent.vue').default);

// Product
Vue.component('Product', require('./components/ProductComponent.vue').default);

// Create Product
Vue.component('create-product', require('./components/CreateProductComponent.vue').default);

// Category
Vue.component('Category', require('./components/CategoryComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
