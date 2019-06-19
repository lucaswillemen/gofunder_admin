<template class=" md-grutter">
<md-tabs class="md-primary">
  <md-dialog-alert :md-active.sync="alertError" md-title="Erro!" :md-content="alertErrorMsg" />
  <md-tab id="tab-user" md-label="Perfil" md-icon="people">
    <div class="md-layout md-grutter">
      <form novalidate class="md-layout">
        <md-card class="md-layout-item">
          <md-card-header>
            <h4 class="header_title">Configurações Perfil</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-50">

                <div class="md-layout md-gutter">

                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon>people</md-icon>
                      <label>Nome: *</label>
                      <md-input v-model="saveUser.name"></md-input>
                    </md-field>
                  </div>
									<div class="md-layout-item md-size-40">
										<md-field>
											<md-icon>event</md-icon>
											<label>Data Nascimento: *</label>
											<md-input v-model="saveUser.birthday"></md-input>
										</md-field>
									</div>

                </div>


                <br />
                <span class="md-subheading">Sua imagem de perfil</span>
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
                <span class="md-subheading">Endereço</span>
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-flag"></md-icon>
                      <label>Pais</label>
                      <md-input v-model="saveUser.country"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-city"></md-icon>
                      <label>City</label>
                      <md-input v-model="saveUser.city"></md-input>
                    </md-field>
                  </div>
                </div>
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-code-equal"></md-icon>
                      <label>Zipcode</label>
                      <md-input v-model="saveUser.zipcode"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-40">
                    <md-field>
                      <md-icon class="mdi mdi-card-text-outline"></md-icon>
                      <label>Endereço</label>
                      <md-input v-model="saveUser.address"></md-input>
                    </md-field>
                  </div>
                </div>
              </div>
              <div class="md-layout-item md-size-50  ">
								LINKS ÚTEIS
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-web"></md-icon>
                      <label>Website</label>
                      <md-input v-model="saveUser.website"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-instagram"></md-icon>
                      <label>Instagram</label>
                      <md-input v-model="saveUser.instagram"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-facebook"></md-icon>
                      <label>Facebook</label>
                      <md-input v-model="saveUser.facebook"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-twitter"></md-icon>
                      <label>Twitter</label>
                      <md-input v-model="saveUser.twitter"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-youtube"></md-icon>
                      <label>Youtube</label>
                      <md-input v-model="saveUser.youtube"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-50">
                    <md-field>
                      <md-icon class="mdi mdi-linkedin"></md-icon>
                      <label>Linkedin</label>
                      <md-input v-model="saveUser.likedin"></md-input>
                    </md-field>
                  </div>
                </div>
								<br/><br/><br/>
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>description</md-icon>
                    <label>Descrição: *</label>
                    <md-textarea v-model="saveUser.description"></md-textarea>
										<span class="md-helper-text">Insira aqui uma pequena nota ou biografia do qual as pessoas poderão ver ao acessar seu perfil</span>
                  </md-field>
                </div>
              </div>
            </div>
          </md-card-content>
          <md-card-actions>
            <md-button type="submit" @click.prevent="saveProfile()" class="md-raised md-roxo">Salvar meu perfil</md-button>
            <br />
            <br />
          </md-card-actions>
        </md-card>
      </form>
    </div>
  </md-tab>
  <md-tab id="tab-senha" md-label="Trocar Senha" md-icon="security">
    <div class="md-layout md-grutter">
      <form novalidate class="md-layout">
        <md-card class="md-layout-item">
          <md-card-header>
            <h5 class="header_title">Configurações de Senha</h5>
          </md-card-header>

          <md-card-content>
            <div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>security</md-icon>
                    <label>Senha</label>
                    <md-input v-model="secureUserPassword.password" type="password"></md-input>
                    <span class="md-helper-text">Para confirmar que é você precisamos da sua senha antiga</span>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>shield</md-icon>
                    <label>Nova senha:</label>
                    <md-input v-model="secureUserPassword.newPassword2" type="password"></md-input>
                    <span class="md-helper-text">Digite uma senha forte e segura para aprimorar sua segurança na Gofunder</span>
                  </md-field>
                </div>
              </div>

              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field :class="{'md-invalid' : secureUserPassword.newPassword1  && secureUserPassword.newPassword2 && secureUserPassword.newPassword1 != secureUserPassword.newPassword2}">
                    <md-icon>done</md-icon>
                    <label>Confirmar nova senha:</label>
                    <md-input v-model="secureUserPassword.newPassword1" type="password"></md-input>
                    <span class="md-error">As senhas digitadas não conferem!</span>
                    <span class="md-helper-text">Digite novamente a senha para conferirmos se está tudo certo</span>
                  </md-field>
                </div>
              </div>
              <br />
              <br />
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-button type="submit" @click.prevent="saveUserPassword()" class="md-raised md-roxo">Salvar nova senha</md-button>
                </div>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>

  </md-tab>
  <md-tab id="tab-email" md-label="Configurações E-mail" md-icon="email">
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
            <h4 class="header_title">Configurações de E-mail</h4>
          </md-card-header>

          <md-card-content>
            <div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>email</md-icon>
                    <label>E-mail antigo</label>
                    <md-input v-model="secureUserEmail.email" :disabled="true"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>shield</md-icon>
                    <label>Novo e-mail:</label>
                    <md-input v-model="secureUserEmail.newEmail"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <md-icon>security</md-icon>
                    <label>Digite sua senha:</label>
                    <md-input v-model="secureUserEmail.password" type="password"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-button type="submit" @click.prevent="saveUserEmail()" class="md-raised md-roxo">Salvar Novo E-mail</md-button>
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
            <h4 class="header_title">Link de Referência</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                Copie o link asseguir e compartilhe com que você gostaria de indicar para a plataforma, você ganhará uma porcentagem de toda doação autenticada que seu convidado realizar!
              </div>
            </div>

            <div class="link-div">
              <md-field style="width: 300px;">
                <label>Link:</label>
                <md-input type="text" id="referal-input" v-model="referalLink" disabled></md-input>
              </md-field>
              <md-button class="md-raised md-primary" @click="copyToClipboard()">Copiar</md-button>
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
import {
  mapState,
  mapActions
} from "vuex";

export default {
  name: 'Profile',
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
        city: "",
        country: "",
        website: "",
        image: null
      }
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
          this.emailAlertMsg = 'E-mail salvo com sucesso. Confirme ele na sua caixa  de entrada'
        })
        .catch(err => {
          this.emailAlertMsg = "E-mail ou senha inválido!"
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
          this.passwordAlertMsg = "Senha salva com sucesso"
        })
        .catch(err => {
          this.passwordAlertMsg = "Senhas não conferem"
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
      global.$post("/Profile/edit", this.saveUser, this.user.token)
        .then(response => {
          this.userSet(response.data)
          this.base64File = this.$url + this.user.img
          this.profileAlertMsg = 'Informações de perfil salvas com sucesso'
        })
        .catch(err => {
          
          this.profileAlertMsg = 'Erro ao salvar informações!'
          })
        .finally(() => {
          this.showAlertProfile = true
          this.loading = false;
        })
    }
  },
  mounted() {
    this.base64File = this.$url + this.user.img
    this.saveUser = this.user
    this.secureUserEmail.email = this.user.email
    this.referalLink = `https://gofunder.io/register?id=${this.user.id}`
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
