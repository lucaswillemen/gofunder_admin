<template>
<div class="userEdit">
  <main-header></main-header>
  <subheader-admin></subheader-admin>
  <div class="container admin-container mb-30">
    <b-row class="mtop mb-30">
      <b-col lg="12">
        <div class="main-title">
          <span> Olá <span class="orange">{{user.name}}</span></span>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col lg="12">
        <div class="tabbed-frame">
          <b-tabs>
            <b-tab title="Perfil" class="tabs tabprofile" active>
              <div id="tab1" class="tab-wrap">
                <b-row>
                  <b-col lg="12">
                    <div class="main-title">
                      <span>Informações Básicas</span>
                    </div>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col lg="4">
                    <b-form>
                      <div class="sbs mbottom">
                        <span class="subtitle center-left w-20">Nome</span>
                        <b-form-input type="text" v-model="form1.name" class="w-75"></b-form-input>
                      </div>
                      
                      <!--<div class="sbs mbottom">
                        <span class="subtitle center-left w-20">País</span>
                        <b-form-input type="text" v-model="form1.country" class="w-75"></b-form-input>
                      </div>!-->
                    </b-form>
                  </b-col>
                <!--  <b-col lg="4">
                    <b-form>
                      <div class="sbs mbottom">
                        <span class="subtitle center-left w-20">Sobrenome</span>
                        <b-form-input type="text" v-model="form1.lastname" class="w-75"></b-form-input>
                      </div>
                      <div class="sbs mbottom">
                        <span class="subtitle center-left w-20">Cidade</span>
                        <b-form-input type="text" v-model="form1.city" class="w-75"></b-form-input>
                      </div>
                    </b-form>
                  </b-col>!-->
                  <b-col lg="4">
                    <b-form>
                    <!--  <div class="sbs mbottom">
                        <span class="subtitle center-left w-20">Código Postal</span>
                        <b-form-input type="text" v-model="form1.postcode" class="w-75"></b-form-input>
                      </div>!-->
                    </b-form>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col lg="12">
                    <div class="main-title">
                      <span>Sua História</span>
                    </div>
                    <b-form>
                      <div class="sbs mbottom">
                        <span class="subtitle center-left w-20">Pequena Descrição</span>
                        <b-form-input type="text" v-model="form1.tinydescription"></b-form-input>
                      </div>
                      <div class="sbs mbottom">
                        <span class="subtitle center-left w-20">Descrição</span>
                        <b-form-textarea type="text" v-model="form1.description" :rows="6" :max-rows="6"></b-form-textarea>
                      </div>
                    </b-form>
                  </b-col>
                </b-row>
                <hr>
                <b-row>
                  <b-col lg="12">
                    <div class="main-title">
                      <span>Suas Fotos</span>
                    </div>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col lg="12">
                    <div class="img-esq">
                      <div class="subtitle">
                        <span>Imagem do Perfil</span>
                      </div>
                      <div class="img" v-bind:style="{ backgroundImage: 'url(' + (user && user.img ? $apiEndpoint+'/uploads/profile/'+user.img : '/static/anonymous-icon.svg')  + ')' }">
                        <div class="circle">
                          <font-awesome-icon :icon="['fas', 'camera']" />
                          <input id="fileupload" type="file" v-on:change="changeImage" ref="fileInput" style="opacity: 0; position:absolute; z-index:999999999!important;" />
                        </div>
                      </div>
                    </div>
                  </b-col>
                </b-row>
                <hr>
                
                <b-row>
                  <b-col lg="12">
                    <div class="main-title">
                      <span>Links Adicionais</span>
                    </div>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col lg="12">
                    <b-form>
                      <div class="sbs mbottom align-items-center">
                        <i class="fab fa-facebook link-icon" style="color: #496cb5"></i>
                        <!-- <span class="subtitle center-left w-20">Facebook</span> -->
                        <b-form-input type="text" v-model="form1.facebook" class="w-75"></b-form-input>
                      </div>
                      <div class="sbs mbottom align-items-center">
                        <i class="fab fa-twitter link-icon" style="color: #4ab3f4"></i>
                        <!-- <span class="subtitle center-left w-20">Twitter</span> -->
                        <b-form-input type="text" v-model="form1.twitter" class="w-75"></b-form-input>
                      </div>
                    </b-form>
                  </b-col>
                  <b-col lg="12">
                    <b-form>
                      <div id="append-links">
                        <input type="hidden" id="counter-link" value="2">
                        <div class="sbs mbottom align-items-center">
                          <!-- <span class="subtitle center-left w-20">Youtube</span> -->
                          <i class="fab fa-youtube link-icon" style="color: #ff0000"></i>
                          <b-form-input type="text" v-model="form1.youtube" class="w-75"></b-form-input>
                        </div>
                        <div class="sbs mbottom align-items-center">
                          <i class="fa fa-globe link-icon" style="color: #1a2953"></i>
                          <!-- <span class="subtitle center-left w-20">Website</span> -->
                          <b-form-input type="text" v-model="form1.website" class="w-75"></b-form-input>
                        </div>
                      </div>
                    </b-form>
                  </b-col>

                </b-row>
                <b-row>
                  <b-col lg="12">
                    <div class="center">
                      <div class="btn-noborder mtop">
                        <b-button @click="saveProfile()">Salvar meu Perfil</b-button>
                      </div>
                    </div>
                  </b-col>
                </b-row>
              </div>
            </b-tab>
            <b-tab title="Configurações" class="tabs">
              <div id="tab2" class="tab-wrap">
                <div>
                  <!--
									REDES SOCIAIS
                  <b-row class="mb-30">
                    <b-col lg="12">
                      <div class="main-title mb-20">
                        <span>Redes Sociais</span>
                      </div>

                      <div class="btn-border-blue mbottom">
                        <b-button>
                          <font-awesome-icon :icon="['fab', 'facebook']" /> Conecte com Facebook</b-button>
                      </div>
                      <div class="btn-border-blue">
                        <b-button>
                          <font-awesome-icon :icon="['fab', 'linkedin']" /> Conecte com Linkedin</b-button>
                      </div>
                    </b-col>
                  </b-row>
									!-->
                  <b-row>
                    <b-col lg="12">
                      <div class="mbottom">
                        <span class="main-title">Atualize seu e-mail</span>
                      </div>
                      <b-form-group id="fieldset1" label-size="sm" label="E-mail atual" label-for="input0">
                        <b-form-input id="input0" type="email" v-model="user.email" class="w-75" disabled></b-form-input>
                      </b-form-group>
                      <b-form-group id="fieldset1" label-size="sm" label="Digite seu novo e-mail" label-for="input1" description="Você precisará confirmar este e-mail após alterar">
                        <b-form-input id="input1" type="email" v-model="formEmail.email" class="w-75"></b-form-input>
                      </b-form-group>
                      <b-form-group id="fieldset1" label-size="sm" description="Precisamos da sua senha para verificar que é você mesmo" label="Sua senha atual" label-for="input2">
                        <b-form-input id="input2" type="password" v-model="formEmail.password" class="w-75"></b-form-input>
                      </b-form-group>
                      <div class="btn-border  mb-30">
                        <b-button @click="changeEmail()" :disabled="!formEmail.email || !formEmail.password || formEmail.email == user.email">Reenviar e-mail de verificação</b-button>
                      </div>
                    </b-col>
                  </b-row>
                  <hr>
                  <b-row>
                    <b-col lg="12">
                      <div class="mbottom">
                        <span class="main-title">Alterar minha senha</span>
                      </div>
                      <b-form-group id="fieldset10" label-size="sm" label="Digite uma nova senha" label-for="input5">
                        <b-form-input id="input5" type="password" v-model="formPass.newpassword1" class="w-75"></b-form-input>
                      </b-form-group>
                      <b-form-group id="fieldset11" label-size="sm" label="Confirme a nova senha" label-for="input6">
                        <b-form-input id="input6" type="password" v-model="formPass.newpassword2" class="w-75"></b-form-input>
                      </b-form-group>
                      <b-form-group id="fieldset12" label-size="sm" description="Precisamos da sua senha para verificar que é você mesmo" label="Sua senha atual" label-for="input7">
                        <b-form-input id="input7" type="password" v-model="formPass.password" class="w-75"></b-form-input>
                      </b-form-group>
                      <div class="btn-noborder">
                        <b-button @click="changePassword()" :disabled="!formPass.password || formPass.newpassword1 !== formPass.newpassword2">Alterar minha senha</b-button>
                      </div>
                    </b-col>
                  </b-row>
                  <hr>
                  <b-row>
                    <!--<b-col lg="12">
                      <div class="mbottom">
                        <span class="main-title">Desativar sua conta</span>
                      </div>
                      <div class="w-50 mb-20">
                        <span class="subtitle ">
                          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum is simply dummy text of the printing and typesetting
                          industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                        </span>
                      </div>
                      <div class="btn-noborder">
                        <b-button>Desativar minha conta</b-button>
                      </div>
                    </b-col>!-->
                  </b-row>
                </div>
              </div>
            </b-tab>

            <b-tab title="Endereços" class="tabs tabfin">
              <div id="tab3" class="tab-wrap">
                <b-row>
                  <b-col lg="6">
                    <b-row>
                      <b-col lg="12">
                        <b-form>
                          <div class="cc">
                            <div class="main-title">
                              <span>Adicionar Endereço</span>
                            </div>
                            <b-form class="card-form">

                              <b-row style="margin-bottom:0px;">
                                <b-col cols="12" sm="12" md="6" lg="6" xl="6">
                                  <b-form-group label-size="sm" label="Estado" >
                                    <b-form-input v-model="addressForm.state" type="text" placeholder="Estado" required>
                                    </b-form-input>
                                  </b-form-group>
                                </b-col>
                                <b-col cols="12" sm="12" md="6" lg="6" xl="6">
                                  <b-form-group label-size="sm" label="Cidade" label-for="card-form-cvc">
                                    <b-form-input v-model="addressForm.city" placeholder="Cidade" type="text" required>
                                    </b-form-input>
                                  </b-form-group>
                                </b-col>
                              </b-row>

                              <b-form-group label-size="sm" label="Bairro">
                                <b-form-input v-model="addressForm.neighborhood" type="text" placeholder="Bairro"  required>
                                </b-form-input>
                              </b-form-group>

                              <b-row style="margin-bottom:0px;">
                                <b-col cols="12" sm="12" md="6" lg="6" xl="6">
                                  <b-form-group label-size="sm" label="Endereço" >
                                    <b-form-input  v-model="addressForm.address" type="text" placeholder="Endereço"  required>
                                    </b-form-input>
                                  </b-form-group>
                                </b-col>
                                <b-col cols="12" sm="12" md="6" lg="6" xl="6">
                                  <b-form-group label-size="sm" label="Complemento" label-for="card-form-cvc">
                                    <b-form-input  v-model="addressForm.complement" type="text" placeholder="Complemento"  required>
                                    </b-form-input>
                                  </b-form-group>
                                </b-col>
                              </b-row>

                              <b-row>
                                <b-col cols="12" sm="12" md="6" lg="6" xl="6">
                                  <b-form-group label-size="sm" label="Número" >
                                    <b-form-input  v-model="addressForm.number" type="text" placeholder="Número"  required>
                                    </b-form-input>
                                  </b-form-group>
                                </b-col>
                                <b-col cols="12" sm="12" md="6" lg="6" xl="6">
                                  <b-form-group label-size="sm" label="Zipcode" label-for="card-form-cvc">
                                    <b-form-input  v-model="addressForm.zipcode" type="text" placeholder="Zipcode"  required>
                                    </b-form-input>
                                  </b-form-group>
                                </b-col>
                              </b-row>

                              <div class="buttons">
                                <div class="btn-noborder">
                                  <b-button @click="addAddres()">Adicionar Endereço</b-button>
                                </div>
                              </div>
                            </b-form>
                          </div>
                        </b-form>
                      </b-col>
                    </b-row>


                  </b-col>
                  <b-col lg="6" class="right-col">
                    <div class="main-title">
                      <span>Lista de Endereços</span>
                    </div>
                    <div v-if="addressesList.length == 0">
                      <p>Nenhum endereço cadastrado!</p>
                    </div>
                    <div v-else class="partners">
                      <b-container>
                        <b-row v-for="(addr, index) in addressesList" :key="index">
                          <b-col class="d-flex align-items-center justify-content-between p-2" style="border: 1px solid black; border-radius: 0.25rem;">
                            <section>
                              <div>
                                Rua: {{addr.address}}, {{addr.number}} ({{addr.complement}}) - {{addr.city}} {{addr.state}}
                              </div>
                              <div>
                                Bairro: {{addr.neighborhood}}
                              </div>
                              <div>
                                CEP: {{addr.zipcode}}
                              </div>
                            </section>
                            <section>
                              <b-button class="remove-address-btn" @click="remAddres(addr.id)"><i class="fa fa-trash"></i></b-button>
                            </section>
                          </b-col>
                        </b-row>
                      </b-container>
                    </div>
                  </b-col>
                </b-row>
              </div>
            </b-tab>
            <b-tab title="Recompensas" class="tabs tabfin">
              <div id="tab4" class="tab-wrap">
                <b-row>
                  <b-col lg="6">
                    <b-row>
                      <b-col lg="12">
                          <div class="main-title">
                            Recompensas
                          </div>
                          <section class="campaign-perk">
                            <p>Capacete inflável</p>
                            <b-card no-body class="overflow-hidden" style="max-width: 540px;">
                              <b-row no-gutters>
                                <b-col md="6">
                                  <b-card-img src="https://picsum.photos/400/400/?image=20" class="rounded-0"></b-card-img>
                                </b-col>
                                <b-col md="6">
                                  <b-card-body title="Receba seu produto antes!">
                                    <b-card-text>
                                      Receba seu produto antes graças a esse maravilhoso perk!
                                    </b-card-text>
                                  </b-card-body>
                                </b-col>
                              </b-row>
                            </b-card>
                          </section>
                      </b-col>
                    </b-row>


                  </b-col>
                </b-row>
              </div>
            </b-tab>
            <b-tab title="Minhas doações" class="tabs tabfin">
              <div id="tab5" class="tab-wrap">
                <b-row>
                  <b-col lg="6">
                    <b-row>
                      <b-col lg="12">
                        <b-form>
                          <div class="main-title">
                            Minhas Doações
                          </div>
                        </b-form>
                      </b-col>
                    </b-row>


                  </b-col>
                </b-row>
              </div>
            </b-tab>


          </b-tabs>
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
  mounted() {
    this.loadVuexInfo()
    this.getAddresses()
    if (this.user && this.user.subscription_option && this.user.subscription_option.length > 0) {
      this.selectedEmails = this.user.subscription_option.split(",")
    }
  },
  data() {
    return {
      ccs: [],
      form1: {
        name: null,
        tinydescription: null,
        profile_picture: null,
        description: null,
        facebook: null,
        twitter: null,
        youtube: null,
        website: null
      },
      addressesList: [],
      formEmail: {
        email: null,
        password: null
      },
      formPass: {
        newpassword1: null,
        newpassword2: null,
        password: null
      },
      form: {
        email: '',
        pass1: '',
        pass2: '',
        newpass: '',
        confirmnewpass: '',
      },
      imageProfileImg: null,
      categorys: [{
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        },
        {
          name: 'Áudio',
          icon: 'headphones'
        }
      ],
      addressForm: {
        state: null, city: null, address:null, number: null, zipcode: null, neighborhood: null, complement: null
      }
    }
  },
  methods: {
    ...mapActions('user', ['userSet']),
    loadVuexInfo() {
      this.form1 = {...this.user}
    },

    changeImage(e) {
      this.imageProfileImg = e.target.files[0]
      this.uploadProfileImage()
    },

    uploadProfileImage() {
      let myOptions = {
        fileToUpload: this.imageProfileImg
      }

      this.$awn.asyncBlock(global.$post("/Auth/edit_profile_img", myOptions, this.user.token))
        .then(response => {
          this.$awn.success("Imagem de Perfil Atualizado")
          this.userSet(response.data.MSG)
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.MSG)
          this.$awn.alert(validErr ? err.response.data.MSG : "INVALID_ERROR")
        })
    },



    changeEmail: function() {
      global.$post("/Auth/edit_email", this.formEmail, this.user.token)
        .then(response => {
          this.$awn.success("E-mail alterado com sucesso")
          this.$awn.success("Confirme seu e-mail na caixa de entrada")
          console.log('email', response)
          this.userSet(response.data.MSG)
          this.formEmail.email = null
          this.formEmail.password = null
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.MSG)
          this.$awn.alert(validErr ? err.response.data.MSG : "INVALID_ERROR")
        })
    },


    saveProfile: function() {
      global.$post("/Auth/profile", this.form1, this.user.token)
        .then(response => {
          this.$awn.success("Perfil alterado com sucesso")
          this.userSet(response.data.MSG)
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.MSG)
          this.$awn.alert(validErr ? err.response.data.MSG : "INVALID_ERROR")
        })
    },

    addAddres: function() {
      global.$post("/Profile/address", this.addressForm, this.user.token)
        .then(response => {
          this.$awn.success("Endereço adicionado com sucesso")
          this.getAddresses()
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.MSG)
          this.$awn.alert(validErr ? err.response.data.MSG : "INVALID_ERROR")
        })
    },
    remAddres: function(id) {
      global.$post("/Profile/deladdress", {id: id}, this.user.token)
        .then(response => {
          this.$awn.success("Endereço removido")
          this.getAddresses()
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.MSG)
          this.$awn.alert(validErr ? err.response.data.MSG : "INVALID_ERROR")
        })
    },
    getAddresses: function() {
      global.$get("/Profile/address", {}, this.user.token)
        .then(response => {
          this.addressesList = response.data
        })
        .catch(err => {

        })
    },
    changePassword: function() {
      global.$post("/Auth/edit_password", this.formPass, this.user.token)
        .then(response => {
          this.userSet(response.data.MSG)
          this.$awn.success("Senha alterada!")         
          this.formPass.newpassword1 = null
          this.formPass.password = null
          this.formPass.newpassword2 = null
        })
        .catch(err => {

        })
    },
    select: function(id, parent) {
      var elem = $("#" + id);
      $(elem).addClass("active");
      $('.' + parent).children().each(function() {
        if ($(this).attr("id") != id) {
          $(this).removeClass('active');
        }
      })
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.userEdit {
  .admin-container {

      .tabbed-frame {
          // posicao da seta de cada tab
          #tab1:after,
          #tab1:before {
              left: 30px;
          }
          #tab2:after,
          #tab2:before {
              left: 138px;
          }
          #tab3:after,
          #tab3:before {
              left: 265px;
          }
          #tab4:after,
          #tab4:before {
              left: 390px;
          }
          #tab5:after,
          #tab5:before {
              left: 525px;
          }
      }
      .tabfin {

          .row {
              margin-bottom: 30px;
          }

          .right-col {
              border-left: 1px solid $blue;
          }

          button {
              width: 180px;
          }

          .cc {

              #card-name,
              #card-number {
                  width: 300px;
              }

              .main-title {
                  margin-bottom: 15px;
              }

              select {
                  border-color: $blue;
              }

              #card-duedate,
              #select-cardtype {
                  width: 110px;
              }

              #card-secret {
                  width: 60px;
              }

          }
          .wallets {
              font-size: 19px;
              .icon {
                  color: $orange;
              }
          }
          .ccs {

              .ccrow {
                  display: flex;
                  margin-bottom: 35px;
                  .icon {
                      color: $orange;
                      font-size: 45px;
                      margin-right: 20px;
                  }

                  .info {
                      margin-right: 30px;
                      font-size: 14px;
                      .number {
                          display: block;
                          margin-bottom: 2px;
                      }
                  }

                  .options {
                      a {
                          font-size: 13px;
                          cursor: pointer;
                      }
                  }

              }

          }

          .accounts {

              .main-title {
                  margin-bottom: 15px;
              }

              .account {
                  display: flex;

                  .email {
                      margin-right: 20px;
                      font-size: 14px;
                      margin-top: 2px;
                  }

                  .options {
                      display: flex;

                      .checkboxes .custom-checkbox {
                          margin-right: 15px;
                      }

                      a {
                          font-size: 12px;
                          cursor: pointer;
                          margin-top: 4px;
                      }
                  }
              }
          }

          .partners { 

              .remove-address-btn { 
                width: 40px; padding: 0.375rem 0.625rem;
              }
              .partner {

                  display: flex;
                  margin-bottom: 10px;

                  .amount,
                  .name {
                      margin-right: 50px;
                      font-size: 16px;
                      font-weight: 500;
                      color: $orange;
                  }

                  button {
                      width: 78px;
                      padding: 4px 10px;
                      font-size: 11px;
                      height: 24px;
                  }

              }

          }

          .main-title {
              margin-bottom: 15px;
          }

      }
      .main-title {
          margin-bottom: 15px;
      }

      .tabprofile {

          .img-esq {
              float: left;
              margin-right: 50px;

              .subtitle {
                  margin-bottom: 10px;
              }

              .img {
                  width: 200px;
                  height: 200px;
                  background-repeat: no-repeat;
                  background-size: cover;
                  position: relative;

                  .circle {
                      position: absolute;
                      width: 35px;
                      height: 35px;
                      background-color: white;
                      border-radius: 50px;
                      left: 0;
                      right: 0;
                      margin: auto;
                      bottom: -15px;
                      cursor: pointer;

                      svg {
                          position: absolute;
                          left: 0;
                          right: 0;
                          bottom: 0;
                          top: 0;
                          margin: auto;
                          font-size: 20px;
                          color: #404040;
                      }
                  }
              }
          }

          .img-dir {
              float: left;

              .subtitle {
                  margin-bottom: 10px;
              }

              .avatar {
                  width: 65px;
                  height: 65px;
                  background-repeat: no-repeat;
                  background-size: cover;
                  position: relative;
                  border-radius: 5px;

                  .circle {
                      position: absolute;
                      width: 35px;
                      height: 35px;
                      background-color: white;
                      border-radius: 50px;
                      left: 0;
                      right: 0;
                      margin: auto;
                      bottom: -15px;
                      cursor: pointer;

                      svg {
                          position: absolute;
                          left: 0;
                          right: 0;
                          bottom: 0;
                          top: 0;
                          margin: auto;
                          font-size: 20px;
                          color: #404040;
                      }
                  }
              }
          }
          .link-icon {
            font-size: 23px;
            width: 26px;
          }
      }

      .tabinterest {

          .categorys,
        s {
              margin-top: 20px;
              width: 500px;

              .category,
              .community,
              .job {
                  border: 1px solid $orange;
                  border-radius: 5px;
                  height: 80px;
                  width: 90px;
                  position: relative;
                  margin-right: 15px;
                  float: left;
                  margin-bottom: 10px;

                  .inner {

                      position: absolute;
                      top: 14px;
                      bottom: 0;
                      left: 28px;

                      .title {
                          text-align: center;
                          color: $orange;
                          font-size: 12px;
                          margin-top: 5px;
                          font-weight: 500;
                      }

                      svg {
                          margin: 0 auto;
                          font-size: 32px;
                          color: $orange;
                      }
                  }

              }

          }

          .stages,
          .types {
              margin-top: 50px;

              .stage,
              .type {
                  float: left;
                  position: relative;
                  height: 130px;
                  width: 245px;
                  border: 1px solid $orange;
                  border-radius: 5px;
                  margin-right: 10px;

                  .circle {
                      height: 50px;
                      width: 50px;
                      border: 2px solid white;
                      border-radius: 25px;
                      position: relative;
                      background-color: $orange;
                      top: -30px;
                      margin: auto;

                      svg {
                          position: absolute;
                          margin: auto;
                          top: -6px;
                          bottom: 0;
                          left: 0;
                          right: 0;
                          font-size: 24px;
                          color: white;
                      }
                  }

                  .subtitle,
                  .title {
                      position: absolute;
                      margin: auto;
                      width: 211px;
                      left: 0;
                      right: 0;
                  }

                  .title {
                      top: 31px;
                      font-size: 14px;
                      color: $orange;
                      font-weight: 500;
                  }

                  .subtitle {
                      top: 54px;
                      font-size: 12px;
                      line-height: 15px;
                  }

                  cursor: pointer;

              }

              .type:hover {
                  border: 3px solid $orange;
              }

              .active {
                  background-color: $orange!important;

                  .subtitle,
                  .title {
                      color: white;
                  }

              }
          }

          .row {
              margin-bottom: 30px;
          }
      }

  }

  @media only screen and (max-width: 768px) {

      .tabbed-frame {

          .categorys {
              width: 100%!important;
              .category,
              .community,
              .job {
                  margin-right: 6px!important;
              }
          }

          .stage,
          .type {
              margin-bottom: 40px;
              width: 100%!important;
          }

          .tabfin {
              .right-col {
                  border-left: none!important;
              }
          }

      }

  }
}
</style>
