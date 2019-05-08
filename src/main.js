import App from './App.vue'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import store from './store'
import router from './router/router.js'
import './config/request'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import CKEditor from '@ckeditor/ckeditor5-vue'
//import 'vue-material/dist/theme/custom.css'
import "@/style.css"
import AlertVue from "./components/AlertVue.vue"



Vue.config.productionTip = false
Vue.use(VueMaterial)
Vue.use(Vuelidate)
Vue.use(CKEditor)
Vue.use(AlertVue)

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')