<template>
  <div class="centered-container">
    <md-content class="md-elevation-3">

      <div class="title">
        <img src="../../public/go-funder-icon.png">
        <div class="md-title">Register</div>
      </div>

      <div class="form" @keyup.enter="registerUser()">
        <md-field :class="nameInvalid">
          <label>Nome</label>
          <md-input v-model="register.name" autofocus></md-input>
          <span class="md-error">Digite seu nome corretamente</span>
        </md-field>
        <md-field :class="emailInvalid">
          <label>E-mail</label>
          <md-input v-model="register.email" autofocus></md-input>
          <span class="md-error">Digite um e-mail válido para registro!</span>
        </md-field>

        <md-field md-has-password  :class="passwordInvalid">
          <label>Senha</label>
          <md-input v-model="register.password" type="password"></md-input>
          <span class="md-error">As senhas digitadas não conferem!</span>
        </md-field>

        <md-field md-has-password>
          <label>Confirme sua senha</label>
          <md-input v-model="register.password2" type="password"></md-input>
        </md-field>

        <router-link to="/login">Você já tem uma conta?</router-link>
      </div>
      <div class="">
        <md-button  :disabled="invalidForm()" class="md-raised md-primary" @click="registerUser()">Registrar</md-button>
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
        password: null,
        password2: null
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
            location.href = '/login'
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
        .finally(() => {
          this.loading = false // ao terminar finalizar o loading
        })
    },
    invalidForm() {
      return this.register.password !== this.register.password2 || (this.register.email == null || !(/\S+@\S+\.\S+/.test(this.register.email))) || (this.register.name == null || this.register.name.length < 3)
    }
  },


  computed: {
      nameInvalid () {
        return {
          'md-invalid': this.register.name == null || this.register.name.length < 3
        }
      },
      emailInvalid () {
       return {
          'md-invalid': this.register.email == null || !(/\S+@\S+\.\S+/.test(this.register.email))
        }
      },
      passwordInvalid() {
        return {
          'md-invalid': this.register.password !== this.register.password2
        }
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
