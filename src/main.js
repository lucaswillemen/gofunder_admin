import App from './App.vue'
import Vue from 'vue'
import store from './store'
import router from './router/router.js'
import './config/request'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'



Vue.config.productionTip = false
Vue.use(VueMaterial)

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')