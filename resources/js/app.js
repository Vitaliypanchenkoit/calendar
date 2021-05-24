require('./bootstrap');
require('alpinejs');

import Vue from 'vue'
import App from './vuejs/App'
import router from './vuejs/router/router'
import store from './vuejs/store/store'

Vue.config.productionTip = false

let calendar = document.getElementById('calendar');

if (calendar) {
    new Vue({
        router,
        store,
        render: h => h(App)
    }).$mount('#calendar')
}
