/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from "vue";

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue' //Importing
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(VueSweetalert2)

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ProductsComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('products-component', require('./components/ProductsComponent.vue').default);
Vue.component('audit-component', require('./components/AuditComponent.vue').default);
Vue.component('providers-component', require('./components/ProvidersComponent.vue').default);
Vue.component('purchaseorderpayment-component', require('./components/PurchaseOrderPaymentComponent.vue').default);
Vue.component('purchaseorderpayed-component', require('./components/PurchaseOrderPayedComponent.vue').default);
Vue.component('tags-component', require('./components/TagsComponent.vue').default);
Vue.component('restore-products-component', require('./components/RestoreProductsComponent.vue').default);
Vue.component('restore-providers-component', require('./components/RestoreProvidersComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
