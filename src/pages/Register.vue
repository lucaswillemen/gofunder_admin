<template>
  <div class="centered-container">
    <md-content class="md-elevation-3">

      <div class="title">
        <img src="https://vuematerial.io/assets/logo-color.png">
        <div class="md-title">Vue Material</div>
      </div>

      <div class="form" @keyup.enter="registerUser()">
        <md-field>
          <label>Name</label>
          <md-input v-model="register.name" autofocus></md-input>
        </md-field>
        <md-field>
          <label>E-mail</label>
          <md-input v-model="register.email" autofocus></md-input>
        </md-field>

        <md-field md-has-password>
          <label>Password</label>
          <md-input v-model="register.password" type="password"></md-input>
        </md-field>
        <router-link to="/login">Already have an account?</router-link>
      </div>
      <div class="">
        <md-button class="md-raised md-primary" @click="registerUser()">Register</md-button>
      </div>


      <div class="loading-overlay" v-if="loading">
        <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
      </div>


    </md-content>
    <md-dialog-alert
      :md-active.sync="first"
      md-content="Wrogn password!"
      md-confirm-text="Close!" />

    <div class="background" />
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: "Register",
  data() {
    return {
      first: false,
      loading: false,
      register: {
        name: null,
        email: null,
        password: null
      }
    };
  },
  methods: {
    ...mapActions('user', ['userSet']),
    registerUser() {
      this.loading = true;
      // your code to login user
      // this is only for example of loading
       global.$post("/Auth/register", this.register)
        .then(response => {
            // logado armazenar informações na store
            console.log('registrado', response)
            this.userSet(response.data)
            this.$router.push('/create')
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
        .finally(() => {
          this.loading = false // ao terminar finalizar o loading
        })
    }
  }
};
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
