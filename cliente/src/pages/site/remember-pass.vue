<template>
<div class="rememberDiv">
  <main-header></main-header>

  <div class="container center">
    <b-row>
      <b-col lg="12">
        <div class="content" v-show="!fase">
          <div class="title">
            <span>Esqueceu sua Senha?</span>
          </div>
          <div class="subtitle">
            <span>Informe seu e-mail cadastrado, que enviaremos instruções para criar uma nova senha.</span>
          </div>

          <b-form-input id="email" type="text" v-model="form.email" placeholder="E-mail:"></b-form-input>

          <div class="btn-noborder">
            <b-button @click="sendCode()" :disabled="!form.email">Envie-me Instruções</b-button>
          </div>
        </div>
        <div class="content" v-show="fase">
          <div class="title">
            <span>Digite o código</span>
          </div>
          <div class="subtitle">
            <span>Digite o código enviado por e-mail e sua nova senha</span>
          </div>

          <b-form-input id="code" type="text" v-model="form.code" placeholder="Código enviado por e-mail"></b-form-input>
          <br>
          <b-form-input id="code" type="password" v-model="form.newpass" placeholder="Digite sua nova senha"></b-form-input>
          <br>
          <b-form-input id="code" type="password" v-model="form.newpass2" placeholder="Confirme sua nova senha"></b-form-input>


          <div class="btn-noborder">
            <b-button @click="changePass()" :disabled="form.newpass!=form.newpass2 || !form.newpass || !form.code">Recuperar minha conta</b-button>
          </div>
        </div>

      </b-col>
    </b-row>
  </div>

  <main-footer></main-footer>
</div>
</template>

<script>
export default {
  data() {
    return {
      fase: 0,
      form: {
        email: '',
        code: '',
        newpass:'',
        newpass2:''
      }
    }
  },
  methods: {
    changePass: function() {
      this.$awn.asyncBlock(global.$post("/Auth/change_password_recover", this.form, false))
        .then(response => {
          this.$awn.success("Senha alterada com sucesso")
        })
        .catch(err => {
          this.$awn.alert("O código digitado é inválido")
        })
        .finally(dev => {
          this.form.code = ""
          this.form.newpass = ""
          this.form.newpass2 = ""
        })
    },
    sendCode : function() {
      this.$awn.asyncBlock(global.$post("/Auth/send_recover_email", this.form, false))
        .then(response => {
          this.fase = 1
          this.$awn.success("Confira o código recebido no e-mail")
        })
        .catch(err => {
          this.$awn.alert("Conta não encontrada")
        })

    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.rememberDiv {
  .content {
    padding: 50px 20px;
    text-align: center;

    div {
        margin: 10px 0;
    }

    input {
        background-color: transparent;
        border-color: $blue;
    }

    input::placeholder {
        color: $blue;
    }

}

}
</style>
