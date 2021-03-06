import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/pages/site/home'
import UserInfo from '@/pages/admin/UserInfo'
import Login from '@/pages/site/login'
import Register from '@/pages/site/register'
import Remember from '@/pages/site/remember-pass'

import Projects from '@/pages/site/projects'
import Financial from '@/pages/site/financial'




import Marketplace from '@/pages/site/marketplace'
import PaymentContribution from '@/pages/admin/PaymentContribution'
import NotFound from '@/pages/site/NotFound'

Vue.use(Router)

export default new Router({
  routes: [{
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/prom',
      name: 'Marketplace',
      component: Marketplace
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/remember',
      name: 'Remember',
      component: Remember
    },
    // {
    //   path: '/user/edit',
    //   name: 'UserEdit',
    //   component: UserEdit
    // },
    {
      path: '/user/:id/info',
      name: 'UserInfo',
      component: UserInfo
    },
    {
      path: '/projects/:search?',
      name: 'ProjectsSearch',
      component: Projects
    },
    {
      path: '/projects-category/:category?',
      name: 'ProjectsCategory',
      component: Projects
    },
    {
      path: '/projects-type/:type?',
      name: 'ProjectsType',
      component: Projects
    },
    {
      path: '/project-info/:id/:title',
      name: 'Financial',
      component: Financial
    }, ,
    {
      path: '/payment-contribution/campaign/:campaign_id',
      name: 'PaymentContributionCampaign',
      component: PaymentContribution
    },
    {
      path: '/payment-contribution/cota/:campaign_id/:cota_id',
      name: 'PaymentContributionCota',
      component: PaymentContribution
    },
    {
      path: '/payment-contribution/perk/:campaign_id/:perk_id',
      name: 'PaymentContributionPerk',
      component: PaymentContribution
    },
    {
      path: '/not-found',
      name: 'NotFound',
      component: NotFound
    },
    {
      path: "*",
      redirect: '/not-found',
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})