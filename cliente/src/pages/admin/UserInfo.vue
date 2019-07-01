<template>
<div class="userInfo">
  <main-header></main-header>
  <subheader-admin></subheader-admin>
  <div class="container admin-container mb-30">
    <b-row class="mtop mb-30">
      <b-col lg="12">
        <div class="main-title">
          <span> Perfil de <span class="orange">{{userData.name}}</span></span>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col lg="12">
        <div class="tabbed-frame">
          <b-tabs>
            <b-tab title="Perfil" class="tabs tabprofile">
              <div id="tab1" class="tab-wrap">
                <b-row>
                  <b-col lg="4" xl="3">
                    <div class="img" v-bind:style="{ backgroundImage: 'url(' + (userData && userData.img ? this.$apiEndpoint+userData.img : '/static/anonymous-icon.svg')  + ')' }">
                    </div>
                  </b-col>
                  <b-col lg="8" xl="9">
                    <b-row>
                      <b-col lg="12">
                        <div class="title">
                          <div class="main-title mb-3">
                            <span class="adjust_title">Sobre <span class="orange">mim</span></span>
                          </div>
                        </div>
                        <div class="info">
                         <span>{{userData.description}}</span>
                        </div>
                      </b-col>
                    </b-row>
                    <b-row>
                      
                      <b-col lg="12">
                        
                        <div class="boxes">
                          <div class="box">
                            <div class="top">
                            <span>{{campanhas.length}}</span>
                            </div>
                            <div class="bottom">
                              <span>Campanha (s)</span>
                            </div>
                          </div>

                          <div class="box">
                            <div class="top">
                              <span>{{userData.donations_received}}</span>
                            </div>
                            <div class="bottom">
                              <span>Doações recebidas</span>
                            </div>
                          </div>

                          <div class="box">
                            <div class="top">
                              <span>{{userData.donations_done}}</span>
                            </div>
                            <div class="bottom">
                              <span>Doações efetuadas</span>
                            </div>
                          </div>

                        </div>
                        <hr>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col lg="12 bottom">
                        <div class="main-title mb-3">
                          <span>Informações <span class="orange">Adicionais</span></span>
                        </div>
                        <div class="info w-100 mb-0 d-flex flex-md-row flex-column">
                          <section class="email-contact mr-md-3 mb-3 mb-md-0">
                            <header class="mb-md-0 mb-2">Entre em contato comigo pelo meu email:</header>
                            <div class="p-md-2 d-flex align-items-center">
                              <i class="fa fa-at link-icon-email"></i> <span>{{userData.email}}</span>
                            </div>
                          </section>
                          <section v-if="userData.facebook || userData.twitter || userData.youtube || userData.linkedin || userData.website">
                            <header class="mb-md-0 mb-2">Ou então, descubra mais sobre mim verificando os links abaixo:</header>
                            <div class="list p-md-2">        
                                <a :href="userData.facebook" target="_blank"  :style="userData.facebook ? 'color: #496cb5': 'pointer-events: none;'"><i class="fab fa-facebook link-icon"></i></a>
                                <a :href="userData.instagram" target="_blank"  :style="userData.instagram ? 'color: #d6249f': 'pointer-events: none;'"><i class="fab fa-instagram link-icon"></i></a>                                
                                <a :href="userData.twitter"  target="_blank" :style="userData.twitter ? 'color: #4ab3f4': 'pointer-events: none;'"><i class="fab fa-twitter link-icon"></i></a>
                                <a :href="userData.youtube"  target="_blank" :style="userData.youtube ? 'color: #ff0000': 'pointer-events: none;'"><i class="fab fa-youtube link-icon"></i></a>
                                <a :href="userData.linkedin" target="_blank"  :style="userData.linkedin ? 'color: #0077B5': 'pointer-events: none;'"><i class="fab fa-linkedin link-icon"></i></a>                                
                                <a :href="userData.website"  target="_blank" :style="userData.website ? 'color: #0065B5': 'pointer-events: none;'"><i class="fa fa-globe link-icon"></i></a>
                            </div>
                          </section>
                        </div>
                        
                      </b-col>
                    </b-row>
                  </b-col>
                </b-row>
              </div>
            </b-tab>
            <b-tab title="Campanhas do Usuário" class="tabs tabref">
              <div id="tab2" class="tab-wrap">
                <section class="d-flex flex-wrap justify-content-start campaign-margin">
                   <!-- <b-card style="width: 350px;" v-for="(campanha, index) in campanhas" :key="index" :title="campanha.title" :img-src="campanha.cover_url ? $apiEndpoint+campanha.cover_url : 'https://via.placeholder.com/150' " img-alt="Image" class="campaign-card mb-3" img-top body-class="body-position" >
                    <div class="card-description">
                    {{campanha.description}}
                    </div>
                    <div class="campaign-type d-flex align-items-center justify-content-center">
                      Funding
                    </div>
                    <div class="other-info mt-4 mb-2 d-flex justify-content-between">
                      <div class="type" v-if="campanha.flexible == 'static'" v-b-tooltip.hover title="Ao atingir 100% do valor das doações a campanha se encerra">{{campanha.flexible}} Goal</div>
                      <div class="type" v-else v-b-tooltip.hover title="Ao atingir 100% do valor das doações a campanha ainda pode receber mais doações">{{campanha.flexible}} Goal</div>
                      
                      <div class="days-left">{{campanha.finishAt}}</div>
                      <div></div>
                    </div>
                    <div class="card-progress ">
                      <progress-bar :max="100" :current="campaignPercentage(campanha.amount_received, campanha.amount)"></progress-bar>
                      <div class="d-flex justify-content-between">
                        <div class="raise" >Arrecadou: {{campanha.amount_received | currency}} </div>
                        <div class="goal">Meta: {{campanha.amount | currency}} </div>
                      </div>
                    </div>
                    
                    <div slot="footer">
                      <div class="text-center footer-text" :class="{'approved-campaign': campanha.status== 'approved'}">
                        {{campaignStatus(campanha.status)}}
                      </div>
                    </div>
                  </b-card> -->
                  <project-card :projects="campanhas" v-if="campanhas.length > 0"></project-card>
                  <div v-else class="text-center w-100">
                    <h3>O usuário não possui nenhuma campanha!</h3>
                  </div>
                </section>
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
export default {
  mounted() {
    let self = this
   },
  data() {
    return {
      campanhas: [],
      userData: {},
      rascunhos: [],
      finalizadas: [],
      extratos: [],
      projects:[]
    }
  },
  methods: {
    getProfileData() {
      global.$get("/Profile/getuserbyid?user_id="+this.$route.params.id, {})
      .then(response => {
      this.userData = response.data
      // this.$awn.success("E-mail cadastrado com sucesso!")  
          
      })
      .catch(err => {
        console.log(err)

        // this.$awn.alert("Ocorreu um erro!")         
      })
    },
    getUserCampaign() {
      global.$get("/Campaign/getlistcampaignid?user_id="+this.$route.params.id, {})
      .then(response => {
        response.data.forEach(element => {
          let percent = ((100 / element.amount) * element.amount_received)
          element.percent = percent > 100 ? 100 : percent
          if(element.status == 'pending_level') element['lancamento'] = 'Lancamento em breve!' 
          if(element.status == 'draft') element['lancamento'] = 'Rascunho de campanha!' 
          if(element.status == 'approved') element['lancamento'] = 'Campanha ativa!'
          if(element.status == 'approved' && element.remain_days > 0 && element.remain_days < 10) element['lancamento'] = 'Quase acabando!' 
          if(element.status == 'approved' && element.remain_days < 0) element['lancamento'] = 'Já acabou!' 
        });
        this.campanhas = response.data
        // this.$awn.success("E-mail cadastrado com sucesso!")  
           
      })
      .catch(err => {
        console.log(err)

        // this.$awn.alert("Ocorreu um erro!")         
      })
    },
    campaignPercentage(received, goal) {
      let percentage = parseInt((received/goal) * 100)
      return percentage < 100 ? percentage : 100
    },
    // campaignStatus(status) {
    //   if(status == 'approved')
    //     return 'Campanha Lançada!'
    //   if(status == 'draft') 
    //     return 'Rascunho de Campanha'
    //   if(status == 'pending_level')
    //     return 'Lançamento em breve!'
    // }
  },
  mounted() {
    this.getProfileData()
    this.getUserCampaign()
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.userInfo {
  .admin-container {
      .tabbed-frame {
        .tab-wrap {
          padding: 20px;
        }
      
        .campaign-card {
          .card-img-top {
            height: 300px;
          }
          // border-bottom: none;
          &:not(:nth-child(3n)) {
            margin-right: 9px;
          }
          .body-position {
            position: relative;
          }
          .campaign-type {
            position: absolute;
            background-color: $orange;
            color: white;
            height: 30px;
            width: 100%;
            left: 0;
            top: -30px;
          }
          .card-description {
            color: gray;
            font-size: 14px;

          }
          
          .footer-text {
            color: $orange;
            font-weight: 600;
          }
          .approved-campaign {
            color: $blue;
          }
          .card-progress {
            .raise {
              color: $orange;
            }
            .goal {
              color: $blue;
            }
            .raise,.goal {
                font-size: 12px;
                font-weight: 600;
                margin-bottom: 2px;
              }
          }
          .other-info {
            color: $blue;
            .type {
              display: inline-block;
              border-bottom: 1px dashed #1a2953;
              text-transform: capitalize;
              font-weight: 600;
               &:hover {
                  cursor: pointer;
                }
            }
         
            .days-left {

            }
           
          }
        }
        
          // posicao da seta de cada tab
          #tab1:after,
          #tab1:before {
              left: 30px;
          }
          #tab2:after,
          #tab2:before {
              left: 155px;
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
          .link-icon-email {
              font-size: 23px;
              margin-right: .5rem;
            }
          .list {
            a {
              text-decoration: none;
              color: #707070;
              margin-right: 1rem;

              &:hover {
              color: #707070;              
              }

            }
            .link-icon {
              font-size: 23px;
              width: 26px;
            }
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
                  display: flex;
                  justify-content: center;
                  .box {
                    
                  }
                  .box:not(:last-child) {
                    margin-right: 2.5rem;
                  }
              }

              .list {
                  display: block;
              }

          }

      }

  }
  @media only screen and (max-width: 475px) {
    .tabprofile {
      .boxes {
          display: block !important;
          .box {
            
            margin-right: 0 !important;
          }
          .box:not(:last-child) {
            margin-bottom: 2rem;
          }
      }

      .list {
          display: block;
      }

    }
  }
  .adjust_title {
      margin-left: -10px;
  }
}


</style>
