<template>
<div class="centered-container">
  <md-content class="md-elevation-3">

    <div class="title">
      <img src="../../public/go-funder-icon.png">
      <div class="md-title">{{"REGISTER::Cadastro" | fix}}</div>
    </div>
    <form novalidate @submit.prevent="registerUser()">
      <div class="form">
        <md-field :class="getValidationClass('name')">
          <label>{{"REGISTER::Nome" | fix}}</label>
          <md-input v-model="register.name" name="name" autofocus required></md-input>
          <span class="md-error">{{"REGISTER::Digite seu nome corretamente" | fix}}</span>
        </md-field>
        <md-field :class="getValidationClass('email')">
          <label>{{"REGISTER::E-mail" | fix}}</label>
          <md-input v-model="register.email" name="email" autofocus required></md-input>
          <span class="md-error">{{"REGISTER::Digite um e-mail válido para registro!" | fix}}</span>
        </md-field>

        <md-field :class="getValidationClass('password')">
          <label>{{"REGISTER::Senha" | fix}}</label>
          <md-input v-model="register.password" name="password" type="password" required></md-input>
          <span class="md-error">{{"REGISTER::Informe uma senha!" | fix}}</span>
        </md-field>

        <md-field :class="getValidationClass('password2')">
          <label>{{"REGISTER::Confirme sua senha" | fix}}</label>
          <md-input v-model="register.password2" type="password" name="password2" required></md-input>
          <span class="md-error">{{"REGISTER::As senhas digitadas não conferem!" | fix}}</span>
        </md-field>

        <router-link to="/login">{{"REGISTER::Você já tem uma conta?" | fix}}</router-link>
      </div>
      <div class="">
        <md-button type="submit" class="md-raised md-primary md-auth">{{"REGISTER::Registrar" | fix}}</md-button>
      </div>
    </form>


    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>


  </md-content>
  <md-dialog-alert :md-active.sync="emailUsed" :md-content="$f('REGISTER::O e-mail já está sendo usado!')" md-confirm-text="Fechar" />

  <div class="background" />
</div>
</template>

<script>
import {
  mapActions
} from 'vuex'
import {
  validationMixin
}
from 'vuelidate'
import {
  required,
  email,
  minLength,
  maxLength,
  sameAs
}
from 'vuelidate/lib/validators'
export default {
  name: "Register",
  data() {
    return {
      emailUsed: false,
      loading: false,
      register: {
        name: null,
        email: null,
        password: null,
        password2: null
      }
    };
  },

  validations: {
    register: {
      email: {
        required,
        email
      },
      password: {
        required
      },
      password2: {
        sameAsPassword: sameAs('password')
      },
      name: {
        required
      }
    }
  },
  methods: {
    ...mapActions('user', ['userSet']),
    registerUser() {

      this.$v.register.$touch()
      if (this.$v.register.$invalid) {
        return false
      }
      this.loading = true
      global.$post("/Auth/register", this.register)
        .then(response => {
          location.href = '/create'
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          this.emailUsed = true
          this.loading = false
        })
    },

    getValidationClass(fieldName) {
      const field = this.$v.register[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
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
