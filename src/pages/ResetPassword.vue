<template>
<div class="centered-container">
  <md-content class="md-elevation-3">
    <div class="title">
      <img src="../../public/go-funder-icon.png">
      <div class="md-title">Recuperação de Senha</div>
    </div>
    <form v-if="!emailCheck" novalidate @submit.prevent="sendRecoverPass()">
      <div class="form">
        <md-field :class="getValidationClass('email')">
          <label>E-mail</label>
          <md-input v-model="login.email" type="email" name="email" autofocus required></md-input>
          <span class="md-error">O e-mail digitado é inválido</span>
        </md-field>
      </div>
      <md-button type="submit" class="md-raised md-primary md-auth">Enviar código recuperação!</md-button>
    </form>

    <form v-if="emailCheck" novalidate @submit.prevent="recoverPassword()">
      <div class="form">
        <md-field :class="getValidationClass('password')">
          <label>Nova senha</label>
          <md-input v-model="login.newpass" type="password" name="password" autofocus required></md-input>
          <span class="md-error">A senha digitada é inválida</span>
        </md-field>
        <md-field :class="getValidationClass('password')">
          <label>Confirme sua nova senha</label>
          <md-input v-model="login.newpass2" type="password" name="password" autofocus required></md-input>
          <span class="md-error">A senha digitada é inválida</span>
        </md-field>
        <md-field :class="getValidationClass('password2')">
          <label>Código enviado por e-mail</label>
          <md-input v-model="login.code" type="code" name="code" autofocus required></md-input>
          <span class="md-error">O código digitado é inválido</span>
        </md-field>
      </div>
      <md-button type="submit" class="md-raised md-primary md-auth">Recuperar minha conta</md-button>
    </form>


    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>

    <md-dialog-alert
      :md-active.sync="alteredPassword"
      md-title="Senha alterada"
      md-content="Sua senha foi alterada com sucesso!" />

    <md-dialog-alert :md-active.sync="recoverError" md-content="O código digitado está inválido" md-confirm-text="Ok" />

    <md-dialog-alert :md-active.sync="loginError" md-content="Não foi encontrada nenhuma conta para este e-mail!" md-confirm-text="Ok" />

    <md-dialog-alert :md-active.sync="passwordError" md-content="As senhas digitadas não são iguais!" md-confirm-text="Ok" />
  </md-content>

</div>
</template>

<script>
import {
  mapState,
  mapActions
}
from 'vuex'
import {
  validationMixin
}
from 'vuelidate'
import {
  required,
  email,
  minLength,
  maxLength
}
from 'vuelidate/lib/validators'

export default {
  name: "ResetPassword",
  computed: {
    ...mapState(['user'])
  },
  data() {
    return {
      alteredPassword:false,
      emailCheck: false,
      recoverError: false,
      loginError: false,
      loading: false,
      passwordError: false,
      login: {
        email: '',
        newpass: '',
        code: '',
        newpass2: ''
      }
    };
  },
  validations: {
    login: {
      email: {
        required,
        email
      }
    }
  },
  methods: {
    recoverPassword() {
      if(this.login.newpass != this.login.newpass2) {
        return this.passwordError = true
      }
      this.$v.login.$touch()
      if (this.$v.login.$invalid) {
        return false;
      }
      this.loading = true
      global.$post("/Auth/change_password_recover", this.login)
        .then(response => {
          this.alteredPassword = true
          setTimeout(function() {
            location.href = '/login'
          }, 2000)
        })
        .catch(err => {
          this.recoverError = true
        })
        .finally(() => {
          this.loading = false
        })
    },
    sendRecoverPass() {
      this.$v.login.$touch()
      if (this.$v.login.$invalid) {
        return false;
      }
      this.loading = true
      global.$post("/Auth/send_recover_email", this.login)
        .then(response => {
          this.emailCheck = true
        })
        .catch(err => {
          this.loginError = true
        })
        .finally(() => {
          this.loading = false
        })
    },
    getValidationClass(fieldName) {
      const field = this.$v.login[fieldName]
      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    }
  },
  mounted() {

  }


}
</script>

<style lang="scss">
.md-auth {
    width: 100%;
    margin-left: 0px!important;
}

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
