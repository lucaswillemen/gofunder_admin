<template>
<div class="userInfo">
  <main-header></main-header>
  <subheader-admin></subheader-admin>
  <div class="container admin-container mb-30">
    <b-row class="mtop mb-30">
      <b-col lg="12">
        <div class="main-title">
          <span> Sobre <span class="orange">{{user.name}}</span></span>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col lg="12">
        <div class="tabbed-frame">
          <b-tabs>
            <b-tab title="Perfil" class="tabs tabprofile" :active="$route.params.tab === 'perfil'">
              <div id="tab1" class="tab-wrap">
                <b-row>
                  <b-col lg="3">
                    <div class="img" v-bind:style="{ backgroundImage: 'url(' + (user && user.img ? this.$apiEndpoint+'/uploads/profile/'+user.img : '/static/anonymous-icon.svg')  + ')' }">
                    </div>
                  </b-col>
                  <b-col lg="9">
                    <b-row>
                      <b-col lg="12">
                        <div class="title">
                          <div class="main-title">
                            <span class="adjust_title">Sobre <span class="orange">mim</span></span>
                          </div>
                        </div>
                        <div class="info">
                        <!--  <span>{{user.description}}</span>!-->
                        </div>
                      </b-col>
                    </b-row>
                    <b-row>
                      
                      <b-col lg="12">
                        <!--
                        <div class="boxes">
                          <div class="box">
                            <div class="top">
                            <span>{{user.total_campaigns}}</span>
                            </div>
                            <div class="bottom">
                              <span>Campanha (s)</span>
                            </div>
                          </div>

                          <div class="box">
                            <div class="top">
                              <span>{{user.usd | currency}}</span>

                            </div>
                            <div class="bottom">
                              <span>Saldo em Dólares</span>
                            </div>
                          </div>

                        </div>
                        <hr>
                       !-->
                      </b-col>
                    </b-row>
                    <!--<b-row>
                      <b-col lg="12 bottom">
                        <div class="main-title">
                          <span>Informação <span class="orange">Verificada</span></span>
                        </div>
                        <div class="list">
                          <div v-bind:class="user.facebook_confirmed ? 'checked' : 'not_checked'">
                            <font-awesome-icon v-if="!user.facebook_confirmed" :icon="['fas', 'exclamation-circle']" />
                            <font-awesome-icon v-if="user.facebook_confirmed" :icon="['far', 'check-circle']" />
                            <span class="item">
                              Facebook
                            </span>
                          </div>

                          <div v-bind:class="user.linkedin_confirmed ? 'checked' : 'not_checked'">
                            <font-awesome-icon v-if="!user.linkedin_confirmed" :icon="['fas', 'exclamation-circle']" />
                            <font-awesome-icon v-if="user.linkedin_confirmed" :icon="['far', 'check-circle']" />
                            <span class="item">
                              Linkedin
                            </span>
                          </div>


                          <div v-bind:class="user.email_confirmed ? 'checked' : 'not_checked'">
                            <font-awesome-icon v-if="!user.email_confirmed" :icon="['fas', 'exclamation-circle']" />
                            <font-awesome-icon v-if="user.email_confirmed" :icon="['far', 'check-circle']" />
                            <span class="item">
                              E-mail Proprietário
                            </span>
                          </div>
                        </div>
                      </b-col>
                    </b-row>!-->
                  </b-col>
                </b-row>
              </div>
            </b-tab>
            <b-tab title="Rascunhos Campanhas" class="tabs tabcontr" :active="$route.params.tab === 'rascunho'">
              <div id="tab2" class="tab-wrap">

              </div>
            </b-tab>
            <b-tab title="Campanhas em Aberto" class="tabs tabcontr" :active="$route.params.tab === 'campanha'">
              <div id="tab3" class="tab-wrap">

              </div>
            </b-tab>
            <b-tab title="Campanhas Finalizada" class="tabs tabref" :active="$route.params.tab === 'finalizada'">
              <div id="tab4" class="tab-wrap">

              </div>
            </b-tab>
            <b-tab title="Extratos Financeiros" class="tabs tabcontr" :active="$route.params.tab === 'extratos'">
              <div id="tab5" class="tab-wrap">

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
    let self = this
   },
  data() {
    return {
      campanhas: [],
      rascunhos: [],
      finalizadas: [],
      extratos: []
    }
  },
  methods: {

  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.userInfo {
  .admin-container {
      .tabbed-frame {
          // posicao da seta de cada tab
          #tab1:after,
          #tab1:before {
              left: 20px;
          }
          #tab2:after,
          #tab2:before {
              left: 105px;
          }
          #tab3:after,
          #tab3:before {
              left: 290px;
          }
          #tab4:after,
          #tab4:before {
              left: 475px;
          }
          #tab5:after,
          #tab5:before {
              left: 660px;
          }
          #tab6:after,
          #tab6:before {
              left: 700px;
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

              input {
                  margin-bottom: 10px;
              }

              input,
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

          .ccs {

              .ccrow {
                  display: flex;

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

      .progress div {
          background-color: $orange;
      }

      .tabcampaign {

          .main-title {
              margin-bottom: 30px;
          }

          .campaigns {

              .campaign {

                  .content {
                      overflow: auto;
                  }

                  .img {
                      width: 94px;
                      height: 94px;
                      background-size: cover;
                      background-repeat: no-repeat;
                      float: left;
                      margin-right: 20px;
                  }

                  .info {
                      float: left;

                      .name {
                          font-size: 16px;
                          font-weight: 600;
                          color: gray;
                          margin-bottom: 10px;
                          line-height: 20px;
                      }

                      .id {
                          font-size: 14px;
                          color: gray;
                          margin-bottom: 7px;
                      }

                      .status {
                          font-size: 14px;
                          color: $orange;
                          font-weight: 600;
                      }

                  }

                  .select {
                      float: right;
                      padding-top: 30px;
                  }

              }

          }
          .follows {

              .follow {

                  .content {
                      overflow: auto;
                  }

                  .img {
                      width: 94px;
                      height: 94px;
                      background-size: cover;
                      background-repeat: no-repeat;
                      float: left;
                      margin-right: 20px;
                  }

                  .info {
                      float: left;

                      .name {
                          font-size: 16px;
                          font-weight: 600;
                          color: gray;
                          line-height: 20px;
                      }

                      .subtitle {
                          font-size: 12px;
                          color: gray;
                          margin-bottom: 7px;
                          width: 700px;
                          line-height: 15px;
                      }

                      .status {
                          font-size: 14px;
                          color: $orange;
                          font-weight: 600;
                      }

                  }

                  .select {
                      float: right;
                      padding-top: 30px;
                  }

              }

          }

      }

      .tabprofile {

          .img {
              width: 230px;
              height: 230px;
              background-repeat: no-repeat;
              background-size: cover;
          }

          .title {

              overflow: auto;
              margin-bottom: 0;

              .title_img {
                  width: 40px;
                  height: 40px;
                  background-repeat: no-repeat;
                  background-size: cover;
                  float: left;
              }

              .main-title {
                  margin-top: 6px;
                  margin-left: 10px;
                  float: left;
                  font-size: 19px;
              }

          }

          .info {
              font-size: 14px;
              color: gray;
              width: 63%;
              margin-bottom: 20px;
          }

          .boxes {
              display: flex;

              .box {
                  text-align: center;
                  margin-right: 20px;

                  .top {
                      background-color: $orange;
                      border: 1px solid $orange;
                      border-top-left-radius: 5px;
                      border-top-right-radius: 5px;
                      color: white;
                  }

                  .bottom {
                      border-bottom-left-radius: 5px;
                      border-bottom-right-radius: 5px;
                      border: 1px solid gray;
                      color: gray;
                  }

                  .bottom,
                  .top {
                      font-size: 13px;
                      padding: 2px 20px;
                  }

              }
          }

          .list {
              display: flex;

              .not_checked {
                  margin-right: 15px;

                  svg {
                      color: red;
                      font-size: 12px;
                      vertical-align: middle;
                  }

                  .item {
                      font-size: 14px;
                      color: gray;
                  }
              }

              .checked {
                  margin-right: 15px;

                  svg {
                      color: green;
                      font-size: 12px;
                      vertical-align: middle;
                  }

                  .item {
                      font-size: 14px;
                      color: gray;
                  }
              }
          }

          .bottom {
              .main-title {
                  font-size: 20px;
              }
          }

      }
  }

  @media only screen and (max-width: 768px) {

      .tabbed-frame {

          .tabfin {
              .wallets {

                  .wallet {
                      display: block;
                  }

              }

              .right-col {
                  border-left: none!important;
              }
          }

          .tabprofile {

              .boxes {
                  display: block;

                  .box {
                      margin-bottom: 20px;
                  }
              }

              .list {
                  display: block;
              }

          }

      }

  }

  .adjust_title {
      margin-left: -10px;
  }
}

</style>
