<template>
  <div id="app" style="min-height: 100vh;">
    <router-view msg="Welcome to Your Vue.js App"/>
  </div>
</template>


<script>

import {
  mapGetters,
  mapActions
} from 'vuex'
import Alert from '@/components/Alert'
export default {
  name: 'app',
  components: {
    Alert
  },
  computed: {
    ...mapGetters({
      isUserLogged: 'user/isUserLogged',
    })
  },
  data() {
    return {
      intervalTimer: false,
      isHome: true
    }
  },
  watch: {
    '$route.path': function() {
      this.checkPath()
    }
  },

  methods: {
    ...mapActions('user', ['userSet']),
    checkPath() {
      if (this.$route.path === '/') {
        this.isHome = true
      } else {
        this.isHome = false
      }
    }
  }
}
</script>
