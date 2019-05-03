import mt from '@/store/mutation.js'


export default {
  namespaced: true,
  state: {
    token: null,
    name: null,
    email: null,
    btc: 0.0000,
    usd: 0.000
  },
  actions: {
    userSet(ctx, obj) {
      ctx.commit('set', obj)
    },
    userLogout(ctx) {
      Object.keys(ctx.state).forEach(key => {
        ctx.commit('set', {
          [key]: null
        })
      })
    },
    setUserParam(ctx, obj) {
      ctx.commit('setUserParam', obj)
    }
  },
  mutations: {
    ...mt,
    setUserParam(state, obj) {
      state[obj.paramName] = obj.param
    }
  }
}