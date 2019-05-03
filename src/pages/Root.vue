<template>
<md-app style="min-height: 100vh;" md-mode="fixed">
  <md-app-toolbar class="md-primary">
    <span class="md-title">Page name</span>
  </md-app-toolbar>

  <md-app-drawer md-permanent="full" class="md-elevation-4">
    <md-toolbar class="md-primary" md-elevation="0">
      LOGO
    </md-toolbar>

    <md-list>
      <md-list-item>
        <md-icon>dashboard</md-icon>
        <a href="/"><span class="md-list-item-text">Dashboard</span></a>
      </md-list-item>

      <md-list-item>
        <md-icon>add</md-icon>
        <a href="/create"><span class="md-list-item-text">Create new campaign</span></a>
      </md-list-item>

      <md-list-item>
        <md-icon>send</md-icon>
        <a href="/my_campaigns"><span class="md-list-item-text">My campaigns</span></a>
      </md-list-item>
      <router-link to="login">
        <md-list-item>
          <md-icon>close</md-icon>
          <a href="#" @click="logout()"><span class="md-list-item-text">Logout</span></a>
        </md-list-item>
      </router-link>
    </md-list>
  </md-app-drawer>
  <md-app-content>
    <router-view></router-view>
  </md-app-content>
</md-app>
</template>

<style lang="scss" scoped>
// Demo purposes only
.md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
}
</style>

<script>
import {
  mapGetters,
  mapActions
} from 'vuex'


export default {
  name: 'ListTypes',
  computed: {
    ...mapGetters({
      isUserLogged: 'user/isUserLogged',
    })
  },
  data() {
    return {
      intervalTimer: false
    }
  },
  methods: {
    ...mapActions('user', ['userLogout', 'userSet']),
    logout() {
      this.userLogout()
      location.href = '/login'
    },
    checkLogin() {
      if (!this.isUserLogged) {
        this.logout()
      }
      global.$post("/Auth/check", {}, this.user.token)
        .then(res => {
          //this.userSet(res)
        })
        .catch(() => {
          this.logout()
        })
    }
  },
  mounted() {
    this.checkLogin()
    this.intervalTimer = setInterval(this.checkLogin, 10000)
  },
  beforeDestroy() {
    clearInterval(this.intervalTimer)
  }
}
</script>
