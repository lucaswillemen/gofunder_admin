import Vue from 'vue'
import Vuex from 'vuex'

import user from '@/store/modules/user'

import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)


export default new Vuex.Store({
  modules: {
    user
  },
  plugins: [createPersistedState()]
})