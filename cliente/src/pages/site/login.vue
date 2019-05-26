<template>
<div class="loginDiv">
  <main-header></main-header>
  <div class="container wrap-login center">
    <b-row>
      <b-col lg="12">
        <div class="login">
          <div class="circle">
            <font-awesome-icon :icon="['fas', 'user']" />
          </div>
          <div class="title mtop mbottom">
            <span>{{"LOGIN::Digite seus dados abaixo para entrar."|fix}}</span>
          </div>
          <form v-on:submit.prevent="login()">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon :icon="['fas', 'user']" />
                </span>
              </div>
              <b-form-input v-model="form.email" type="email" :placeholder="$f('LOGIN::Digite seu e-mail')"></b-form-input>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon :icon="['fas', 'lock']" />
                </span>
              </div>
              <b-form-input type="password" v-model="form.password" :placeholder="$f('LOGIN::Digite sua senha')"></b-form-input>
            </div>
            <div class="options">
              <div class="checkboxes">
                <b-form-checkbox v-model="form.selected" name="remember">
                  <span>{{"LOGIN::Lembre-me"|fix}}</span>
                </b-form-checkbox>
              </div>
              <div class="subtitle">
                <span><a href="/#/remember">{{"LOGIN::Esqueceu sua senha?"|fix}}</a></span>
              </div>
            </div>
            <div class="btn-noborder-blue">
              <b-button type="submit" :disabled="!form.email || !form.password">{{"LOGIN::Login"|fix}}</b-button>
            </div>
          </form>
          <div class="title mtop mbottom">
            <span>{{"LOGIN::Novo no Portal?"|fix}} <a href="/#/register" class="orange"><b>{{"LOGIN::Cadastre-se"|fix}}</b></a></span>
          </div>
          <div class="btn-border-blue">
            <b-button>
              <font-awesome-icon :icon="['fab', 'facebook']" />{{"LOGIN::Entrar com Facebook"|fix}}</b-button>
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
        selected: false
      }
    }
  },
  methods: {
    ...mapActions('user', ['userSet']),
    login: function() {
      global.$post("/Auth/login", this.form)
        .then(response => {
          this.$awn.success("Bem vindo " + response.data.name)
          this.userSet(response.data)
          setTimeout(function() {
            location.href = this.$urlPainel + '/profile'
          }, 1200)

        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          this.$awn.alert(validErr ? err.response.data.error : "INVALID_ERROR")
        })
    }
  },
  mounted() {
    if (this.user.token !== null) {
        location.href = this.$urlPainel + '/profile'
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.loginDiv {
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
