import genericMutations from '@/store/modules/mutation'


export default {
  namespaced: true,
  state: {
    id: null,
    name: null,
    img: null,
    email: null,
    city: null,
    country: null,
    facebook: null,
    instagram: null,
    website: null,
    zipcode: null,
    address: null,
    twitter: null,
    birthday: null,
    youtube: null,
    usd: null,
    btc: null,
    token: null,
    password: null,
    description: null,
    tinydescription: null,
    recover_token: null,
    email_confirm_code: null,
    email_confirmed: null,
    created_at: null
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