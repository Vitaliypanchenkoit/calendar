import Vue from 'vue';
import Vuex from 'vuex';

import month from "./modules/month";
import date from "./modules/date";
import event from "./modules/event";
import news from "./modules/news";
import reminder from "./modules/reminder";
import week from "./modules/week";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
  		month,
			date,
			event,
			news,
			reminder,
			week
  },
});
