import Vue from 'vue';
import Router from 'vue-router';

import PersonalBlog from './views/PersonalBlog.vue';
import Profile from './views/Profile.vue';
import AddNewPost from './views/AddNewPost.vue';
import Errors from './views/Errors.vue';
import ComponentsOverview from './views/ComponentsOverview.vue';
import Tables from './views/Tables.vue';
import BlogPosts from './views/BlogPosts.vue';
import Login from './views/Login.vue';
import Register from './views/Register.vue';
import ConfirmEmail from './views/ConfirmEmail.vue';


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
      path: '/',
      redirect: '/blog-overview',
    },
    {
      path: '/blog-overview',
      name: 'blog-overview',
      component: PersonalBlog,
      meta: {
        onlyAuth: true
      }
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile,
      meta: {
        onlyAuth: true
      }
    },
    {
      path: '/add-new-post',
      name: 'add-new-post',
      component: AddNewPost,
      meta: {
        onlyAuth: true
      }
    },
    {
      path: '/errors',
      name: 'errors',
      component: Errors,
      meta: {
        onlyAuth: true
      }

    },
    {
      path: '/components-overview',
      name: 'components-overview',
      component: ComponentsOverview,
      meta: {
        onlyAuth: true
      }
    },
    {
      path: '/tables',
      name: 'tables',
      component: Tables,
      meta: {
        onlyAuth: true
      }
    },
    {
      path: '/blog-posts',
      name: 'blog-posts',
      component: BlogPosts,
      meta: {
        onlyAuth: true
      }
    },
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
      path: '/confirm-email',
      name: 'ConfirmEmail',
      component: ConfirmEmail,
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
