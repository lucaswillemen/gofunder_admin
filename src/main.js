import App from './App.vue'
import Vue from 'vue'
import router from './router/router.js';
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here

Vue.config.productionTip = false
Vue.use(VueMaterial)

new Vue({  
  router,
  render: h => h(App),
}).$mount('#app')
