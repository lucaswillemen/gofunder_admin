import App from './App.vue'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import store from './store'
import router from './router/router.js'
import './config/request'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'


import "@/default.css"
import "@/style.css"
import "@/gofunder-custom.scss"
import VueCurrencyFilter from 'vue-currency-filter'
import VueTheMask from 'vue-the-mask'
import money from 'v-money'

// $url = url para api
Vue.prototype.$url = 'https://api.gofunder.io/'
// $urlFrontend = url para pagina inicial (template laranja)
Vue.prototype.$urlFrontend = 'http://localhost:8081/#'

Vue.prototype.$resetObj = (obj) => {
  Object.keys(obj).map(key => {
    if (obj[key] instanceof Array) obj[key] = []
    else obj[key] = null
  })
}
// PARTE DA TRADUÇÃO
import PT from '@/translation/pt.js'

Vue.prototype.$f = function(value) {
  if (!PT[value]) {
    console.log('TRANSLATION ERROR: ', value)
    return value
  }
  return PT[value]
}
Vue.filter('fix', (value) => {
  if (!PT[value]) {
    console.log('TRANSLATION ERROR: ', value)
    return value
  }
  return PT[value]
})

Vue.config.productionTip = false
Vue.use(VueMaterial)
Vue.use(require('vue-moment'));
Vue.use(Vuelidate)
Vue.use(VueTheMask)
Vue.use(money, {
  precision: 2,
  decimal: ',',
  thousands: '.',
})
Vue.use(VueCurrencyFilter, {
  symbol: '$',
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