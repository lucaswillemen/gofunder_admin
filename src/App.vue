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

export default {
  name: 'app',
  components: {

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
  },
  created() {
    this.$router.beforeResolve((to, from, next) => {
      if (to.matched.some(record => record.meta.onlyPublic)) {
        if (this.isUserLogged) {
           return this.$router.push("/root")
        }
      }
      if (to.matched.some(record => record.meta.onlyAuth)) {
        if (!this.isUserLogged) {
          return this.$router.push("/")
        }
      }
      return next()
    })
    this.$router.beforeEach((to, from, next) => {
      if (this.isUserLogged && this.$route.meta && this.$route.meta.onlyPublic === true) {
        return this.$router.push("/root")
      }
      if (!this.isUserLogged && this.$route.meta && this.$route.meta.onlyAuth === true) {
        return  this.$router.push("/")
      }
      return next()
    })
  }
}
</script>
