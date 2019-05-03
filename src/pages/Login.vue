<template>
<div class="centered-container">
  <md-content class="md-elevation-3">
    <div class="title">
      <img src="../../public/go-funder-icon.png">
      <div class="md-title">Login</div>
    </div>
    <div class="form">
      <md-field>
        <label>E-mail</label>
        <md-input v-model="login.email" autofocus></md-input>
      </md-field>
      <md-field md-has-password>
        <label>Password</label>
        <md-input v-model="login.password" type="password"></md-input>
      </md-field>
      <a href="/resetpassword">Reset password</a>
    </div>
    <div class="md-alignment-center">
      <md-button class="md-raised md-primary md-alignment-center" @click="auth()">Log in</md-button>
    </div>
    <router-link to="register">
      <div class="">
        <md-button class="md-raised md-primary">Create new account</md-button>
      </div>
    </router-link>
    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>
  </md-content>

  <div class="background" />
</div>
</template>

<script>
import {
  mapState,
  mapActions
} from 'vuex'


export default {
  name: "Login",
  computed: {
    ...mapState(['user'])
  },
  data() {
    return {
      loading: false,
      login: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    ...mapActions('user', ['userSet']),
    auth() {
      this.loading = true
      global.$post("/Auth/login", this.login)
        .then(response => {
          this.userSet(response.data)
          location.href = '/create'
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR")
        })
        .finally(() => {
          this.loading = false
        })
    }
  },
  mounted() {

  }
}
</script>

<style lang="scss">
.centered-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    height: 100vh;
    .title {
        text-align: center;
        margin-bottom: 30px;
        img {
            margin-bottom: 16px;
            max-width: 80px;
        }
    }
    .form {
        margin-bottom: 60px;
    }
    .md-content {
        z-index: 1;
        padding: 40px;
        width: 100%;
        max-width: 400px;
        position: relative;
    }
    .loading-overlay {
        z-index: 10;
        top: 0;
        left: 0;
        right: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>
