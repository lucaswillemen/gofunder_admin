import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/pages/site/home'
import UserEdit from '@/pages/admin/UserEdit'
import UserInfo from '@/pages/admin/UserInfo'
import Login from '@/pages/site/login'
import Register from '@/pages/site/register'
import Remember from '@/pages/site/remember-pass'

import Projects from '@/pages/site/projects'
import Financial from '@/pages/site/financial'



import CreateCampaing from '@/pages/site/create-campaing'
import MainCampaign from '@/pages/admin/campaing/MainCampaign'
import MainContent from '@/pages/admin/campaing/MainContent'
import MainListReward from '@/pages/admin/campaing/MainListReward'
import MainReward from '@/pages/admin/campaing/MainReward'
import MainPublish from '@/pages/admin/campaing/MainPublish'
import Marketplace from '@/pages/site/marketplace'
import PaymentContribution from '@/pages/admin/PaymentContribution'

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
    {
      path: '/user/edit',
      name: 'UserEdit',
      component: UserEdit
    },
    {
      path: '/user/info/:tab',
      name: 'UserInfo',
      component: UserInfo
    },
    {
      path: '/projects/:search?',
      name: 'Projects',
      component: Projects
    },
    {
      path: '/projects-category/:category?',
      name: 'Projects',
      component: Projects
    },
    {
      path: '/projects-type/:type?',
      name: 'Projects',
      component: Projects
    },
    {
      path: '/project-info/:id',
      name: 'Financial',
      component: Financial
    },
    {
      path: '/user/campaing/create',
      name: 'CreateCampaing',
      component: CreateCampaing
    },
    {
      path: '/user/campaing/edit/:id',
      name: 'MainCampaign',
      component: MainCampaign
    },
    {
      path: '/user/campaing/content/:id',
      name: 'MainContent',
      component: MainContent
    },
    {
      path: '/user/campaing/reward/:id',
      name: 'MainListReward',
      component: MainListReward
    },
    {
      path: '/user/campaing/publish/:id',
      name: 'MainPublish',
      component: MainPublish
    },
    {
      path: '/user/campaing/reward/edit/:id/:perk_id',
      name: 'MainReward',
      component: MainReward
    },
    {
      path: '/payment-contribution/:id/:perk?',
      name: 'PaymentContribution',
      component: PaymentContribution
    }
  ]
})