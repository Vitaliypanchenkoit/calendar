import Vue from 'vue';
import VueRouter from 'vue-router';
import Month from "../components/Month";
import Day from "../components/Day";

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
    component: Day,
  },




];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
});

export default router;
