// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

Vue.prototype.$apiEndpoint = 'http://api.gofunder.io/'

// BOOTSTRAP
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// ADICIONAR O VUESELECT
Vue.component('v-select', VueSelect.VueSelect);

import PT from './translation/pt.js'

Vue.filter('fix', (value) => {
  if( !PT[value] ) {
    console.log('TRANSLATION ERROR: ', value)
    return value
  }
  return PT[value] 
})

//NOTIFICAÇÕES
import VueAWN from "vue-awesome-notifications"
Vue.use(VueAWN, {
  icons: {
    enabled: true
  }
})

import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)


import VueCurrencyFilter from 'vue-currency-filter'
Vue.use(VueCurrencyFilter)
Vue.use(VueCurrencyFilter, {
  symbol: '$',
  thousandsSeparator: '.',
  fractionCount: 2,
  fractionSeparator: ',',
  symbolPosition: 'front',
  symbolSpacing: true
})

// FORMATO DE MOEDAS
import Vue2Filters from 'vue2-filters'
Vue.use(Vue2Filters)

// CARREGAR AS STORES
import store from './store'

// CARREGAR AXIOS
import '@/model/request.js'

// FONTES
import 'typeface-roboto';

// FONT AWESOME
import {
  library
} from '@fortawesome/fontawesome-svg-core'

//Solid
import {
  faSearch,
  faChevronLeft,
  faChevronRight,
  faCode,
  faLink,
  faEllipsisH,
  faWallet,
  faHeadphones,
  faMountain,
  faTicketAlt,
  faWarehouse,
  faTree,
  faWrench,
  faIndustry,
  faTruck,
  faCamera,
  faExchangeAlt,
  faLock,
  faUser,
  faEnvelope,
  faExclamationCircle
} from '@fortawesome/free-solid-svg-icons'
//Brands
import {
  faFacebook,
  faFacebookF,
  faTwitter,
  faYoutube,
  faLinkedin,
  faInstagram,
  faPinterest,
  faPinterestP,
  faBitcoin
} from '@fortawesome/free-brands-svg-icons'
// Regular
import {
  faHeart,
  faCreditCard,
  faCheckCircle,
  faLightbulb,
  faCopy
} from '@fortawesome/free-regular-svg-icons'

import {
  FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'
library.add(
  faSearch, faFacebook, faTwitter, faInstagram,
  faPinterest, faChevronLeft, faChevronRight, faHeart,
  faFacebookF, faPinterestP, faCode, faLink, faEllipsisH,
  faCreditCard, faWallet, faCheckCircle, faHeadphones,
  faMountain, faTicketAlt, faWarehouse, faTree,
  faLightbulb, faWrench, faIndustry, faTruck, faLinkedin, faBitcoin,
  faCamera, faCopy, faExchangeAlt, faUser, faLock, faEnvelope, faExclamationCircle, faYoutube
);
Vue.component('font-awesome-icon', FontAwesomeIcon);

// SLIDER
import VueGlide from 'vue-glide-js'
Vue.use(VueGlide);
import 'vue-glide-js/dist/vue-glide.css'

// ==== MEUS COMPONENTES ====
import MainHeader from './components/includes/main-header'
Vue.component('main-header', MainHeader);

import MainFooter from './components/includes/main-footer'
Vue.component('main-footer', MainFooter);

import PreFooter from './components/includes/site/pre-footer'
Vue.component('pre-footer', PreFooter);

import Sidebar from './components/includes/site/sidebar'
Vue.component('sidebar', Sidebar);

import SidebarAdmin from './components/includes/admin/sidebar'
Vue.component('sidebar-admin', SidebarAdmin);

import ProjectCard from './components/includes/site/project-card'
Vue.component('project-card', ProjectCard);

import ProgressBar from './components/includes/progress-bar'
Vue.component('progress-bar', ProgressBar);

import TopBarAdmin from './components/includes/admin/topbar'
Vue.component('topbar-admin', TopBarAdmin);

import TableAdmin from './components/includes/admin/table'
Vue.component('table-admin', TableAdmin);

import TableNoBorderAdmin from './components/includes/admin/table-noborder'
Vue.component('tablenoborder-admin', TableNoBorderAdmin);

// eu acho q não utilizo este pra nada
import TabbedFrame from './components/includes/admin/tabbed-frame'
Vue.component('tabbed-frame', TabbedFrame);

import SubHeaderAdmin from './components/includes/admin/subheader-admin'
Vue.component('subheader-admin', SubHeaderAdmin);

import Popup1 from './components/includes/popups/popup1'
Vue.component('popup1', Popup1);

import Popup2 from './components/includes/popups/popup2'
Vue.component('popup2', Popup2);

import Popup3 from './components/includes/popups/popup3'
Vue.component('popup3', Popup3);
// ==== MEUS COMPONENTES ====

// mascara para inputs
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

Vue.config.productionTip = false


/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: {
    App
  },
  template: '<App/>'

})