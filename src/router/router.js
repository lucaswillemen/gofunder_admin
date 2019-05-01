import Vue from 'vue';
import Router from 'vue-router';

import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import Root from '@/pages/Root.vue';


Vue.use(Router);

// function load (local, component) {
//   return () => import(`@/${local}/${component}.vue`)
// }

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  linkActiveClass: 'active',
  linkExactActiveClass: 'exact-active',
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: {
        layout: 'public',
        onlyPublic: true
      }
    },
    {
      path: '/register',
      name: 'Register',
      component: Register,
      meta: {
        layout: 'public',
        onlyPublic: true
      }
    },
    {
      path: '/',
      name: 'Root',
      component: Root,
      meta: {
        layout: 'public',
        onlyPublic: true
      }
    },
    {
      path: '*',
      redirect: '/errors',
    },
  ],
});
