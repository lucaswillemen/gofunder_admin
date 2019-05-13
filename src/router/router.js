import Vue from 'vue';
import Router from 'vue-router';

import Login from '@/pages/Login.vue';
import ResetPassword from '@/pages/ResetPassword.vue';
import Register from '@/pages/Register.vue';
import Root from '@/pages/Root.vue';
import Create from '@/pages/Create.vue';
import Campaigns from '@/pages/Campaigns.vue';
import Edit from '@/pages/Edit.vue';
import Withdraw from '@/pages/Withdraw.vue';
import Extract from '@/pages/Extract.vue';
import Test from '@/pages/Test.vue';

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
  routes: [{
      path: '/test',
      name: 'Test',
      component: Test,
      meta: {
        onlyPublic: true
      }
    },{
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
      path: '/resetpassword',
      name: 'ResetPassword',
      component: ResetPassword,
      meta: {
        onlyPublic: true
      }
    },
    {
      path: '/',
      name: 'Dashboard',
      component: Root,
      meta: {
        onlyAuth: true
      },
      children: [{
          path: '/create',
          name: 'Criação de Campanha',
          component: Create,
          meta: {
            onlyAuth: true
          }
        },
        {
          path: '/campaigns',
          name: 'Minhas Campanhas',
          component: Campaigns,
          meta: {
            onlyAuth: true
          }
        },
        {
          path: '/edit/:id',
          name: 'Edição de Campanha',
          component: Edit,
          meta: {
            onlyAuth: true
          },
        },
        {
          path: '/withdraw',
          name: 'Saques',
          component: Withdraw,
          meta: {
            onlyAuth: true
          }
        },
        {
          path: '/extract',
          name: 'Extratos',
          component: Extract,
          meta: {
            onlyAuth: true
          }
        },
        {
          path: '/withdraw',
          name: 'Withdraw',
          component: Withdraw,
          meta: {
            onlyPublic: true
          }
        }
      ]
    },
    {
      path: '*',
      redirect: '/errors',
    },
  ],
});