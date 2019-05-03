import Vue from 'vue';
import Router from 'vue-router';

import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import Root from '@/pages/Root.vue';
import Create from '@/pages/Create.vue';


Vue.use(Router);

// function load (local, component) {
//   return () => import(`@/${local}/${component}.vue`)
// }

export default new Router({
  mode: 'history',
  linkActiveClass: 'active',
  linkExactActiveClass: 'exact-active',
  scrollBehavior() {
    return {
      x: 0,
      y: 0
    };
  },
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: {
        onlyPublic: true
      }
    },
    {
      path: '/register',
      name: 'Register',
      component: Register,
      meta: {
        onlyPublic: true
      }
    },
    {
      path: '/',
      name: 'Root',
      component: Root,
      meta: {
        onlyAuth: true
      },
      children: [
        {
          // UserProfile will be rendered inside User's <router-view>
          // when /user/:id/profile is matched
          path: '/create',
          component: Create
        }
        ]
    },
    {
      path: '*',
      redirect: '/errors',
    },
  ],
});