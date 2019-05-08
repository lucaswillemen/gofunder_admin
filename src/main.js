import App from './App.vue'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import store from './store'
import router from './router/router.js'
import './config/request'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import CKEditor from '@ckeditor/ckeditor5-vue'
import "@/default.css"
import "@/style.css"
import VueCurrencyFilter from 'vue-currency-filter'
import VueTheMask from 'vue-the-mask'
import money from 'v-money'

Vue.config.productionTip = false
Vue.use(VueMaterial)
Vue.use(Vuelidate)
Vue.use(CKEditor)
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