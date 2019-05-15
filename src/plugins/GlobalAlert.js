import GlobalAlertComponent from './GlobalAlertComponent.vue'
import {events} from './events'
const globalAlert = {
  install(Vue) {
    Vue.prototype.$alert = function(params) {
      events.$emit('add', params)
      
    }
    Vue.component('globalAlertComp', GlobalAlertComponent)
  }
}

export default globalAlert
