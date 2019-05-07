import genericMutations from '@/store/modules/mutation'


export default {
  namespaced: true,
  state: {
    id: null,
    token: null,
    name: null,
    email: null
  },
  getters: {
    isUserLogged(state) {
      return state.token !== null && state.token.length > 0
    }
  },
  mutations: {
    ...genericMutations
  },
  actions: {
    userSet(context, object) {
      context.commit('SET', object)
    },
    userLogout(context) {
      Object.keys(context.state).forEach(key => {
        context.commit('SET', {
          [key]: null
        })
      })
    }
  }
}