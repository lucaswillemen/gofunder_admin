import App from './App.vue'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import store from './store'
import router from './router/router.js'
import './config/request'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import globalAlert from '@/plugins/GlobalAlert'
import Alert from '@/components/Alert'

import "@/default.css"
import "@/style.css"
import VueCurrencyFilter from 'vue-currency-filter'
import VueTheMask from 'vue-the-mask'
import money from 'v-money'


Vue.prototype.$url = 'https://api.gofunder.io/'

Vue.config.productionTip = false
Vue.use(VueMaterial)
Vue.use(Alert)
Vue.use(globalAlert)
Vue.use(require('vue-moment'));
Vue.use(Vuelidate)
Vue.use(VueTheMask)
Vue.use(money, {precision: 4})
Vue.use(VueCurrencyFilter,
  {
    symbol : '$',
    thousandsSeparator: '.',
    fractionCount: 2,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
  })

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')