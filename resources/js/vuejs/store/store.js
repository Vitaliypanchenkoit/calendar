import Vue from 'vue';
import Vuex from 'vuex';

import month from "./modules/month";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
  		month,
  },
});
