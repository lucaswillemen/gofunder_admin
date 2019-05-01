<template>
  <div class="page-container">
    <md-app>
      <md-app-toolbar class="md-primary">
        <span class="md-title">Page name</span>
      </md-app-toolbar>

      <md-app-drawer md-permanent="full">
        <md-toolbar class="md-primary" md-elevation="0">
          LOGO
        </md-toolbar>

        <md-list>
          <md-list-item @click="alert">
            <md-icon>dashboard</md-icon>
            <span class="md-list-item-text">Dashboard</span>
          </md-list-item>

          <md-list-item @click="alert">
            <md-icon>add</md-icon>
            <span class="md-list-item-text">Create new campaign</span>
          </md-list-item>

          <md-list-item @click="alert">
            <md-icon>send</md-icon>
            <span class="md-list-item-text">My campaigns</span>
          </md-list-item>
          <router-link to="login">
          <md-list-item >
            <md-icon>close</md-icon>
            <span class="md-list-item-text">Logout</span>
          </md-list-item>
      </router-link>
        </md-list>
      </md-app-drawer>

    </md-app>
  </div>
</template>

<style lang="scss" scoped>
  .md-app {
    max-height: 400px;
    border: 1px solid rgba(#000, .12);
  }

   // Demo purposes only
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }
</style>

<script>
export default {
  name: 'Normal'
}
</script>
<script>
export default {
  name: 'ListTypes',
  methods: {
    alert () {
      window.alert('...')
    }
  }
}
</script>