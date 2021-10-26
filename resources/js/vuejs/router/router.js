import Vue from 'vue';
import VueRouter from 'vue-router';
import Month from "../views/Month";
import Date from "../views/Date";
import CreateEditEvent from "../views/Event/CreateEditEvent";
import CreateEditNews from "../views/News/CreateEditNews";
import CreateEditReminder from "../views/Reminder/CreateEditReminder";
import EventDetails from "../views/Event/EventDetails";

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
		/* CREATE */
		{
				path: '/events/create/',
				name: 'createEvent',
				component: CreateEditEvent,
		},
		{
				path: '/news/create',
				name: 'createNews',
				component: CreateEditNews,
		},
		{
				path: '/reminders/create/',
				name: 'createReminder',
				component: CreateEditReminder,
		},

		/* EDIT */
		{
				path: '/events/edit/:id',
				name: 'editEvent',
				props: true,
				component: CreateEditEvent,
		},
		{
				path: '/news/edit/:id',
				name: 'editNews',
				props: true,
				component: CreateEditNews,
		},
		{
				path: '/reminders/edit/:id',
				name: 'editReminder',
				props: true,
				component: CreateEditReminder,
		},
		{
				path: '/events/details/:id',
				name: 'eventDetails',
				props: true,
				component: EventDetails,
		},
];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
});

export default router;
