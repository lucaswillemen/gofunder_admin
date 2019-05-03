<template>
<md-app style="min-height: 100vh;" md-mode="fixed">
  <md-app-toolbar class="md-primary">
    <span class="md-title">Page name</span>
  </md-app-toolbar>

  <md-app-drawer md-permanent="full" class="md-elevation-0">
    <md-toolbar class="md-primary" md-elevation="0">
      LOGO
    </md-toolbar>
    <md-list>
      <router-link to="/">
        <md-list-item class="nav-item ">
          <md-icon>dashboard</md-icon>
          <span class="md-list-item-text">Dashboard</span>
        </md-list-item>
      </router-link>
      <router-link to="/create">
        <md-list-item class="nav-item active">
          <md-icon>add</md-icon>
          <span class="md-list-item-text">Create new campaign</span>
        </md-list-item>
      </router-link>
      <router-link to="/create">
        <md-list-item class="nav-item">
          <md-icon>send</md-icon>
          <span class="md-list-item-text">My campaigns</span>
        </md-list-item>
      </router-link>
      <a href="#" @click="logout()">
        <md-list-item class="nav-item">
          <md-icon>close</md-icon>
          <span class="md-list-item-text">Logout</span>
        </md-list-item>
      </a>
    </md-list>
  </md-app-drawer>
  <md-app-content>
    <router-view></router-view>
  </md-app-content>
</md-app>
</template>


<style lang="scss" scoped>
.md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
}
.nav-item {
    margin-top: 12px;
}
.nav-item.active {
    border-left: #448aff;
    border-left-style: solid;
    background: #448aff24;
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
}
.md-app .md-content.md-theme-default {
    border-left-color: rgba(0,0,0,0);
}
.topbar{
      box-shadow: 0 0 0 0 rgba(0,0,0,0), 0 0 0 0 rgba(0,0,0,.0), 0 0 0 0 rgba(0,0,0,0)!important;
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
