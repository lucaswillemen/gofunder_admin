<template>
    <div class="centered-container">
        <md-content class="md-elevation-3">
            <div class="title">
                <img src="../../public/go-funder-icon.png">
                <div class="md-title">{{"LOGIN::Login" | fix}}</div>
            </div>
            <form novalidate @submit.prevent="auth()">
                <div class="form">
                    <md-field :class="getValidationClass('email')">
                        <label>{{"LOGIN::E-mail" | fix}}</label>
                        <md-input v-model="login.email" type="email" name="email" autofocus required></md-input>
                        <span class="md-error">{{"LOGIN::E-mail digitado é inválido" | fix}}</span>
                    </md-field>
                    <md-field  :class="getValidationClass('password')">
                        <label>{{"LOGIN::Senha" | fix}}</label>
                        <md-input v-model="login.password" type="password" required></md-input>
                        <span class="md-error">{{"LOGIN::Senha inválida" | fix}}</span>
                    </md-field>
                    <a href="/resetpassword">{{"LOGIN::Eu perdi minha senha" | fix}}</a>
                </div>
                <md-button type="submit" class="md-raised md-primary md-auth">{{"LOGIN::Entrar na minha conta" | fix}}</md-button>
            </form>
            <router-link to="/register">
                <md-button class="md-raised md-primary md-auth">{{"LOGIN::Criar nova conta" | fix}}</md-button>
            </router-link>
            <div class="loading-overlay" v-if="loading">
                <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
            </div>

            <md-dialog-alert
              :md-active.sync="loginError"
              :md-content="$f('LOGIN::O login digitado é inválido')"
              :md-confirm-text="$f('COMMON::Ok!')" />
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
        name: "Login",
        computed: {
            ...mapState(['user'])
        },
        data() {
            return {
                loginError: false,
                loading: false,
                login: {
                    email: '',
                    password: ''
                }
            };
        },
        validations: {
            login: {
                email: {
                    required,
                    email
                },
                password: {
                    required
                }
            }
        },
        methods: {
            ...mapActions('user', ['userSet']),
            auth() {

                this.$v.login.$touch()
                if (this.$v.login.$invalid) {
                    return false;
                }
                this.loading = true
                global.$post("/Auth/login", this.login)
                    .then(response => {
                        this.userSet(response.data)
                        //this.$router.push("/create") push não está funcional
                        location.href = "/create"
                    })
                    .catch(err => {
                        this.loginError = true
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
            this.loading = false
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
