import Vue from 'vue';
import VueRouter from 'vue-router';
import Month from "../views/Month";
import Date from "../views/Date";
import CreateEvent from "../views/Event/CreateEvent";

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'month',
    component: Month,
  },
  {
    path: '/:year/:month/:date',
    name: 'day',
    component: Date,
  },
		{
				path: '/events/create',
				name: 'createEvent',
				component: CreateEvent,
		},
		{
				path: '/news/create',
				name: 'createNews',
				component: CreateNews,
		},
		{
				path: '/reminders/create',
				name: 'createReminder',
				component: CreateReminder,
		},




];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
});

export default router;
