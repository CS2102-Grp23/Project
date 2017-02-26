
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import App from './App';
import Register from './components/Register';
import Projects from './components/Projects';
import Profile from './components/Profile';
import Auth from './data/Auth';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

const router = new VueRouter({
  routes: [
    { path: '/projects', name: 'projects', component: Projects, alias: '/', auth: true, },
		{ path: '/profile', name: 'profile', component: Profile, auth: true, },
    { path: '/register', name: 'register', component: Register, auth: true, },
  ],
});
/*
router.beforeEach((to, from, next) => {
  if (to.name === 'projects' && !Auth.getEmail()) {
    next({
      path: '/register',
    });
  } else {
    next();
  }
});*/

const eventHub = new Vue();
Vue.prototype.$eventHub = eventHub;

const app = new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
