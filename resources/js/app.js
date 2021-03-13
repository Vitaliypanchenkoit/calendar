require('./bootstrap');
require('alpinejs');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import routes from './route'

const router = new VueRouter({
    routes
})
let calendar = document.getElementById('calendar');
if (calendar) {
    const app = new Vue({
        router
    }).$mount('#calendar')
}
