<template class=" md-grutter">
<md-tabs class="md-primary">
  <md-tab id="tab-user" :md-label="$f('PROFILE::Perfil')" md-icon="people">
    <div class="md-layout md-grutter">
      <form novalidate class="md-layout">
        <md-card class="md-layout-item">
          <md-card-header>
            <h4 class="header_title">{{"PROFILE::Configurações de Perfil" | fix}}</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-50">

                <div class="md-layout md-gutter">

                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon>people</md-icon>
                      <label>{{"PROFILE::Nome:"| fix}} * </label>
                      <md-input v-model="saveUser.name"></md-input>
                    </md-field>
                  </div>
									<div class="md-layout-item md-size-40">
										<md-field>
											<md-icon>event</md-icon>
											<label>{{"PROFILE::Data Nascimento:"| fix}} * </label>
											<md-input v-model="saveUser.birthday" v-mask="'##/##/####'"></md-input>
										</md-field>
									</div>

                </div>


                <br />
                <span class="md-subheading">{{"PROFILE::Sua imagem de perfil" | fix}}</span>
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-80">

                    <div v-if="base64File">
                      <md-button @click="clickOnFileInput()" class="inputOnImage md-fab">
                        <md-icon>add_a_photo</md-icon>
                      </md-button>
                      <img :src="base64File" class="img-preview" onerror="this.src = 'https://www.lausanne.org/wp-content/uploads/2017/04/anonymous-icon.jpg'">
                    </div>
                    <input type="file" style="display: none" id="input-file" @change="pickImg($event)" accept="image/*">
                  </div>
                </div>
                <br />
                <br />
                <span class="md-subheading">{{"PROFILE::Endereço:" | fix}} </span>
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-flag"></md-icon>
                      <multiselect v-model="saveUser.country" class="select-country" :placeholder="$f('PROFILE::País:')" :options="countries" :showLabels="false" :hideSelected="true">
                        <template slot="noResult">
                          <span><strong>{{"MULTISELECT::Sua pesquisa não encontrou nenhum país, tente novamente" | fix}}</strong></span>
                        </template>
                        <template slot="noOptions">
                          <span><strong>{{"MULTISELECT::Nenhum país encontrado, tente recarregar a página ou contate o administrador" | fix}}</strong></span>
                        </template>
                      </multiselect>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-city"></md-icon>
                      <label>{{"PROFILE::Cidade:"| fix}}  </label>
                      <md-input v-model="saveUser.city"></md-input>
                    </md-field>
                  </div>
                </div>
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-code-equal"></md-icon>
                      <label>{{"PROFILE::CEP:"| fix}}  </label>
                      <md-input v-model="saveUser.zipcode"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-card-text-outline"></md-icon>
                      <label>{{"PROFILE::Endereço:"| fix}}  </label>
                      <md-input v-model="saveUser.address"></md-input>
                    </md-field>
                  </div>
                </div>
              </div>
              <div class="md-layout-item md-size-50  ">
								{{"PROFILE::LINKS ÚTEIS" | fix}}
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-web"></md-icon>
                      <label>{{"PROFILE::Website" | fix}}</label>
                      <md-input v-model="saveUser.website"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-instagram"></md-icon>
                      <label>{{"PROFILE::Instagram" | fix}}</label>
                      <md-input v-model="saveUser.instagram"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-facebook"></md-icon>
                      <label>{{"PROFILE::Facebook" | fix}}</label>
                      <md-input v-model="saveUser.facebook"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-twitter"></md-icon>
                      <label>{{"PROFILE::Twitter" | fix}}</label>
                      <md-input v-model="saveUser.twitter"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-youtube"></md-icon>
                      <label>{{"PROFILE::Youtube" | fix}}</label>
                      <md-input v-model="saveUser.youtube"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-linkedin"></md-icon>
                      <label>{{"PROFILE::Linkedin" | fix}}</label>
                      <md-input v-model="saveUser.linkedin"></md-input>
                    </md-field>
                  </div>
                </div>
								<br/><br/><br/>
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>description</md-icon>
                    <label>{{"PROFILE::Descrição:" | fix}} * </label>
                    <md-textarea v-model="saveUser.description"></md-textarea>
										<span class="md-helper-text">{{"PROFILE::Insira aqui uma pequena nota ou biografia do qual as pessoas poderão ver ao acessar seu perfil" | fix}}</span>
                  </md-field>
                </div>
              </div>
            </div>
          </md-card-content>
          <md-card-actions>
            <md-button type="submit" @click.prevent="saveProfile()" class="md-raised md-roxo">{{"PROFILE::Salvar meu perfil" | fix}}</md-button>
            <br />
            <br />
          </md-card-actions>
        </md-card>
      </form>
    </div>
  </md-tab>
  <md-tab id="tab-senha" :md-label="$f('PROFILE::Trocar Senha')" md-icon="security">
    <div class="md-layout md-grutter">
      <form novalidate class="md-layout">
        <md-card class="md-layout-item">
          <md-card-header>
            <h5 class="header_title">{{"PROFILE::Configurações de Senha" | fix}}</h5>
          </md-card-header>

          <md-card-content>
            <div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>security</md-icon>
                    <label>{{"PROFILE::Senha:" | fix}}</label>
                    <md-input v-model="secureUserPassword.password" type="password"></md-input>
                    <span class="md-helper-text">{{"PROFILE::Para confirmar que é você precisamos da sua senha antiga" | fix}}</span>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>shield</md-icon>
                    <label>{{"PROFILE::Nova Senha:"| fix}}</label>
                    <md-input v-model="secureUserPassword.newPassword2" type="password"></md-input>
                    <span class="md-helper-text">{{"PROFILE::Digite uma senha forte e segura para aprimorar sua segurança na Gofunder" | fix}}</span>
                  </md-field>
                </div>
              </div>

              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field :class="{'md-invalid' : secureUserPassword.newPassword1  && secureUserPassword.newPassword2 && secureUserPassword.newPassword1 != secureUserPassword.newPassword2}">
                    <md-icon>done</md-icon>
                    <label>{{"PROFILE::Confirmar nova senha:" | fix}}</label>
                    <md-input v-model="secureUserPassword.newPassword1" type="password"></md-input>
                    <span class="md-error">{{"PROFILE::As senhas digitadas não conferem!" | fix}}</span>
                    <span class="md-helper-text">{{"PROFILE::Digite novamente a senha para conferirmos se está tudo certo" | fix}}</span>
                  </md-field>
                </div>
              </div>
              <br />
              <br />
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-button type="submit" @click.prevent="saveUserPassword()" class="md-raised md-roxo">{{"PROFILE::Salvar nova senha" | fix}}</md-button>
                </div>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>

  </md-tab>
  <md-tab id="tab-email" :md-label="$f('PROFILE::Configurações de E-mail')" md-icon="email">
    <md-dialog-alert
      :md-active.sync="showAlertProfile"
      :md-title="profileAlertMsg" />

    <md-dialog-alert
      :md-active.sync="showAlertMsg"
      :md-title="copyAlertMsg" />

    <md-dialog-alert
    :md-active.sync="showAlertEmail"
    :md-title="emailAlertMsg" />

    <md-dialog-alert
    :md-active.sync="showAlertPassword"
    :md-title="passwordAlertMsg" />
    <div class="md-layout md-grutter">
      <form novalidate class="md-layout">
        <md-card class="md-layout-item">
          <md-card-header>
            <h4 class="header_title">{{"PROFILE::Configurações de E-mail" | fix}}</h4>
          </md-card-header>

          <md-card-content>
            <div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>email</md-icon>
                    <label>{{"PROFILE::E-mail antigo:" | fix}}</label>
                    <md-input v-model="secureUserEmail.email" :disabled="true"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>shield</md-icon>
                    <label>{{"PROFILE::Novo e-mail:" | fix}}</label>
                    <md-input v-model="secureUserEmail.newEmail"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>security</md-icon>
                    <label>{{"PROFILE::Digite sua senha:" | fix}}</label>
                    <md-input v-model="secureUserEmail.password" type="password"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-button type="submit" @click.prevent="saveUserEmail()" class="md-raised md-roxo">{{"PROFILE::Salvar Novo E-mail" | fix}}</md-button>
                </div>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>
  </md-tab>
  <md-tab id="tab-referal" md-label="Referência" md-icon="email">
    <div class="md-layout md-grutter">
      <md-card class="md-layout-item">
          <md-card-header>
            <h4 class="header_title">{{"PROFILE::Link de Referência" | fix}}</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                {{"PROFILE::Copie o link asseguir e compartilhe com que você gostaria de indicar para a plataforma, você ganhará uma porcentagem de toda doação autenticada que seu convidado realizar!" | fix}}!
              </div>
            </div>

            <div class="link-div">
              <md-field style="width: 300px;">
                <label>{{"PROFILE::Link:" | fix}}</label>
                <md-input type="text" id="referal-input" v-model="referalLink" disabled></md-input>
              </md-field>
              <md-button class="md-raised md-primary" @click="copyToClipboard()">{{"PROFILE::Copiar" | fix}}</md-button>
            </div>
          </md-card-content>
        </md-card>
    </div>
  </md-tab>
  <div class="loading-overlay" v-if="loading">
    <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
  </div>
</md-tabs>
</template>
<script>
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Multiselect from 'vue-multiselect'
import {
  mapState,
  mapActions
} from "vuex";

export default {
  name: 'Profile',
  components: {
    Multiselect
  },
  data() {
    return {
      showAlertMsg: false,
      copyAlertMsg: null,
      showAlertProfile: false,
      profileAlertMsg: null,
      showAlertEmail: false,
      emailAlertMsg: null,
      showAlertPassword: false,
      passwordAlertMsg: null,
      referalLink: null,
      loading: false,
      sendedConfirmEmail: false,
      base64File: null,
      secureUserEmail: {
        email: null,
        password: null
      },
      secureUserPassword: {
        newPassword1: null,
        newPassword2: null,
        password: null
      },
      saveUser: {
        name: "",
        birthday: "",
        description: "",
        twitter: "",
        facebook: "",
        address: "",
        zipcode: "",
        instagram: "",
        linkedin: "",
        city: "",
        country: "",
        website: "",
        image: null
      },
      countries: [],
    }
  },
  computed: {
    ...mapState(["user"]),
  },
  methods: {
    ...mapActions('user', ['userSet']),
    clickOnFileInput() {
      document.getElementById("input-file").click();
    },
    pickImg(evt) {
      let reader = new FileReader();
      this.saveUser.image = evt.target.files[0];
      reader.onload = e => {
        this.base64File = e.target.result;
      };
      reader.readAsDataURL(evt.target.files[0]);
    },
    saveUserEmail() {
      this.loading = true;
      global.$post("/Auth/edit_email", this.secureUserEmail, this.user.token)
        .then(response => {
          this.emailAlertMsg = this.$f('PROFILE::E-mail salvo com sucesso.')
        })
        .catch(err => {
          this.emailAlertMsg = this.$f("PROFILE::E-mail ou senha inválidos!")
        })
        .finally(() => {
          this.showAlertEmail = true
          this.loading = false;

        })
    },
    saveUserPassword() {
      this.loading = true;
      global.$post("/Auth/edit_password", this.secureUserPassword, this.user.token)
        .then(response => {
          this.passwordAlertMsg = this.$f("PROFILE::Senha salva com sucesso")
          
          for (const key in this.secureUserPassword) {
              this.secureUserPassword[key] = null;
          }
        })
        .catch(err => {
          this.passwordAlertMsg = this.$f("PROFILE::Senhas não conferem")
          
        })
        .finally(() => {
          this.showAlertPassword = true
          this.loading = false;

        })
    },
    copyToClipboard() {
      let dummy = document.createElement("textarea");
      document.body.appendChild(dummy);
      dummy.value = this.referalLink
      dummy.select();
      document.execCommand("copy");
      document.body.removeChild(dummy);
    },
    confirmCodeEmail() {

    },
    saveProfile() {
      this.loading = true;  
      console.log(this.saveUser)   
      global.$post("/Profile/edit", this.saveUser, this.user.token)
        .then(response => {
          this.userSet(response.data)
          this.base64File = this.$url + this.user.img
          this.profileAlertMsg = this.$f('PROFILE::Informações de perfil salvas com sucesso')
        })
        .catch(err => {
          
          this.profileAlertMsg = this.$f('PROFILE::Erro ao salvar informações!')
          })
        .finally(() => {
          this.showAlertProfile = true
          this.loading = false;
        })
    },
    getOptions() {
			global
				.$get("/campaign/option", {}, this.user.token)
				.then(response => {
					this.countries = response.data.country.map((element) => {
            return element.country_name
          })
				})
				.catch(err => {});
		},
  },
  mounted() {
    this.base64File = this.$url + this.user.img
    this.saveUser = this.user
    this.secureUserEmail.email = this.user.email
    this.referalLink = `https://gofunder.io/register?id=${this.user.id}`
    this.getOptions()
  }
};
</script>


<style lang="scss" scoped>
.header_title {
  color: gray;
  font-size: 21px;
}

.inputOnImage {
  position: absolute !important;
  width: 40px;
  height: 40px;
}

.img-preview {
  width: 180px !important;
  height: 120px !important;
  margin-left: auto;
  margin-right: auto;
  border-radius: 10px !important;
  margin-bottom: 10px;
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
.link-div {
  display: flex;
  align-items: center;
}
</style>
