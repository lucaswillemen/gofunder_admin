const globalAlert = {
  install(Vue) {
    Vue.prototype.$alert = function(opt) {
      alert(opt)
    }
  }
}

export default globalAlert
