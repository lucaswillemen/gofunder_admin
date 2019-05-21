<template>
<div class="registerDiv">
  <main-header></main-header>
  <div class="container wrap-login center">
    <b-row>
      <b-col lg="12">
        <div class="login">
          <div class="circle">
            <font-awesome-icon :icon="['fas', 'user']" />
          </div>
          <div class="title mtop mbottom">
            <span>{{"REGISTER::Digite seus dados abaixo para ingressar na plataforma."|fix}}</span>
          </div>
          <form v-on:submit.prevent="register()">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon :icon="['fas', 'user']" />
                </span>
              </div>
              <b-form-input v-model="form.name" type="text" :placeholder="$f('REGISTER::Digite seu nome completo')" autocomplete="on"></b-form-input>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon :icon="['fas', 'envelope']" />
                </span>
              </div>
              <b-form-input v-model="form.email" type="email" :placeholder="$f('REGISTER::Digite seu e-mail')" autocomplete="on"></b-form-input>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                  <font-awesome-icon :icon="['fas', 'lock']" />
                </span>
              </div>
              <b-form-input type="password" v-model="form.password" :placeholder="$f('REGISTER::Digite sua senha')" autocomplete="current-password"></b-form-input>
            </div>
            <div class="checkboxes">
              <b-form-checkbox v-model="form.selected" name="remember">
                <span>{{"REGISTER::Concordo com os"|fix}} <span class="orange">{{"REGISTER::Termos de Uso"|fix}}</span> e <span class="orange">{{"REGISTER::Politica de Privacidade"|fix}}</span></span>
              </b-form-checkbox>
            </div>
            <div class="btn-noborder-blue">
              <b-button type="submit" :disabled="!form.email || !form.name  || !form.password || !form.selected">{{"REGISTER::Cadastrar-se"|fix}}</b-button>
            </div>
          </form>
          <div class="title mtop mbottom">
            <span>{{"REGISTER::Já tem uma conta?"|fix}} <a href="/#/login" class="orange"><b>{{"REGISTER::Logue-se"|fix}}</b></a></span>
          </div>
          <div class="btn-border-blue">
            <b-button>
              <font-awesome-icon :icon="['fab', 'facebook']" /> {{"REGISTER::Cadastrar com Facebook"|fix}} </b-button>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
  <main-footer></main-footer>
</div>
</template>

<script>
import {
  mapState,
  mapActions
} from 'vuex'


export default {
  computed: {
    ...mapState(['user'])
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
        name: '',
        selected: false
      }
    }
  },
  methods: {
    register: function() {
      global.$post("/Auth/register", this.form)
        .then(response => {
          this.$awn.success("REGISTERED")
          this.$router.push('login')
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.MSG)
          this.$awn.alert(validErr ? err.response.data.MSG : "INVALID_ERROR")
        })
    }
  },
  mounted() {
    if (this.user.token !== null) {
      this.$router.push('/user/edit')
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.registerDiv {

    .wrap-login {

        padding: 60px 0 40px;

        .login {
            padding: 60px 50px 20px;
            // height: 400px;
            // width: 400px;
            border: 2px solid $blue;
            background-color: white;
            border-radius: 5px;
            position: relative;
            text-align: center;

            .circle {
                position: absolute;
                width: 90px;
                height: 90px;
                background-color: $blue;
                border-radius: 50px;
                border: 1px solid $blue;
                left: 0;
                right: 0;
                top: -45px;
                margin: auto;

                svg {
                    position: absolute;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    top: -5px;
                    margin: auto;
                    font-size: 42px;
                    color: #cfcfcf;
                }
            }

            button {
                font-size: 15px;
                height: 36px;
                padding: 5px 80px;
                border-width: 2px!important;
                margin: 10px 0;
                width: 100%;
            }

            .input-group-text {
                height: 38px;
            }
            input {
                margin-bottom: 10px;
            }

            input,
            input::placeholder {
                //  text-align: center;
            }

        }

        .options {
            overflow: auto;
            .checkboxes {
                float: left;
            }
            .subtitle {
                float: right;
                padding-top: 5px;
                a {
                    color: gray;
                }
            }
        }

        a:hover {
            color: $orange;
        }

        .orange {
            color: $orange!important;
        }

        .title {
            font-size: 14px;
        }

    }

    @media only screen and (max-width: 768px) {

        .login {
            padding: 60px 2px 20px 2px!important !important;
        }

    }
}
</style>
