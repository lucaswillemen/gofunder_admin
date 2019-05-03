<template>
<div class="mainCampaignCss">
  <main-header></main-header>
  <div class="container wrap-admin">

    <b-row>
      <b-col lg="3">
        <sidebar-admin></sidebar-admin>
      </b-col>
      <b-col lg="9">
        <div class="alert alert-danger" role="alert" v-show="hasChanges">
          <small><i class="fa fa-exclamation-circle"></i> Existem alterações não salvas, clique em <b>Salvar Campanha</b> para salva-las! </small>
        </div>
        <div class="container admin-right-container">
          <b-row class="top">
            <b-col lg="12">
              <topbar-admin :items="[{ text: 'Rascunho', href: '#' }, { text: 'Informaçoes Gerais', active: true }]"></topbar-admin>
            </b-col>
          </b-row>
          <b-row class="area-1">
            <b-col lg="12">
              <div class="main-title">
                <span>Informações gerais da campanha</span>
              </div>
              <div class="subtitle">
                Altere aqui informações básicas sobre sua campanha
              </div>
              <div class="content mt-5">

                <div class="mb-4">
                  <b-row>
                    <b-col cols="12" md="4">
                      <div class="titleCard">
                        <span>Quanto valor que você quer arrecadar?</span>
                      </div>
                      <b-input-group size="sm" prepend='$'>
                        <b-form-input @change="hasChanges = true" id="value" step="0.01" placeholder="Digite o valor da sua campanha aqui..." type="number" v-model="form.cash"></b-form-input>
                      </b-input-group>
                      <small class="text-danger" v-show="form.cash < 100 && form.cash">Valor mínimo $100,00</small>
                    </b-col>

                    <b-col cols="12" md="4">
                      <div class="titleCard">
                        <span>Qual prazo final para campanha?</span>
                      </div>
                      <b-input-group size="sm" prepend='<i class="fa fa-calendar"></i>'>
                        <b-form-input id="description" type="date" @change="hasChanges = true" v-model="form.end_date" placeholder=""></b-form-input>
                      </b-input-group>
                      <small class="text-danger" v-show="(new Date(form.end_date).getTime() <= new Date().getTime())">Sua data é inválida, deve ser superior ao dia de hoje</small>
                    </b-col>
                  </b-row>
                </div>
                <div class="mb-5">
                  <div class="titleCard">
                    <span>Qual o título da campanha</span>
                  </div>
                  <b-input-group size="sm" prepend='<i class="fa fa-font"></i>'>
                    <b-form-input id="title" type="text" @change="hasChanges = true" v-model="form.title" placeholder="Titulo da Campanha"></b-form-input>
                  </b-input-group>
                  <small class="text-danger" v-show="!form.title || (form.title.length > 64 || form.title.length < 16)">Seu titulo deve ter entre 16 e 64 caracteres</small>
                </div>
                <div class="mb-5">
                  <div class="titleCard">
                    <span>Qual descrição da campanha</span>
                  </div>
                  <b-form-textarea :rows="3" id="description" type="text" @change="hasChanges = true" v-model="form.description" placeholder="Digite aqui uma breve descrição de sua campanha"></b-form-textarea>
                  <small class="text-danger" v-show="!form.description || (form.description.length > 128 || form.description.length < 64)">Sua descrição deve ter entre 64 e 128 caracteres</small>
                </div>
                <div class="mb-5">
                  <div class="titleCard">
                    <span>Quais tags para sua campanha?</span>
                  </div>
                  <b-input-group size="sm" prepend='<i class="fa fa-tags"></i>'>
                    <b-form-input id="description" type="text" @change="hasChanges = true" v-model="form.tags_content" placeholder="Digite aqui tags separadas por virgulas da sua campanha ..."></b-form-input>
                  </b-input-group>
                </div>
                <div class="mb-5">
                  <div class="titleCard">
                    <span>Sua campanha é flexível??</span>
                  </div>
                  <div class="subtitle">
                    Campanhas flexíveis ao atingir 100% não são finalizadas e continuam recebendo doações<br>
                    Campanhas estáticas são finalizadas após atingir a meta.
                  </div>
                  <b-form-select v-model="form.campaign_type" :options="[{ value: 'funding_flexible', text: 'Campanha Flexível' },{ value: 'funding_static', text: 'Campanha Estática' }]" class="mb-3" size="sm" />
                </div>
                <div class="mb-5">
                  <div class="titleCard">
                    <span>Qual categoria da campanha?</span>
                  </div>
                  <div class="subtitle">
                    Escolher uma boa categoria ajuda sua campanha ser encontrada pelas pessoas
                  </div>
                  <b-form-select v-model="form.campaign_category" :options="campaignsCategory" class="mb-3" size="sm" />
                </div>
                <div class="mb-5">
                  <div class="titleCard">
                    <span>Localidade da campanha</span>
                  </div>
                  <b-row>
                    <b-col cols="12" md="4">
                      <b-input-group size="sm" prepend='<i class="fa fa-globe"></i>'>
                        <b-form-input id="description" type="text" @change="hasChanges = true" v-model="form.country" placeholder="Digite aqui o país da campanha"></b-form-input>
                      </b-input-group>
                    </b-col>
                    <b-col cols="12" md="8">
                      <b-input-group size="sm" prepend='<i class="fa fa-map-marker"></i>'>
                        <b-form-input id="description" type="text" @change="hasChanges = true" v-model="form.city" placeholder="Digite aqui a cidade da sua campanha"></b-form-input>
                      </b-input-group>
                    </b-col>
                  </b-row>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
    </b-row>
  </div>
  <main-footer></main-footer>
</div>
</template>

<script>
import {
  mapActions,
  mapState,
  mapGetters
} from 'vuex'



export default {
  computed: {
    ...mapState(['user'])
  },
  mounted() {

    this.$awn.asyncBlock(global.$post("/Campaign/category_list", {}, this.user.token))
      .then(response => {
        this.campaignsCategory = response.data.MSG.map((currentValue, index, arr) => {
          return {
            text: currentValue.name,
            value: currentValue.id
          }
        })
      })
      .catch(err => {

      })

    this.$awn.asyncBlock(global.$post("/Campaign/info", {
        id: this.$route.params.id
      }, this.user.token))
      .then(response => {
        this.form.status = response.data.MSG.status
        this.form.cash = response.data.MSG.cash
        this.form.description = response.data.MSG.description
        this.form.title = response.data.MSG.title
        this.form.end_date = response.data.MSG.end_date
        this.form.coin_type = response.data.MSG.coin_type
        this.form.country = response.data.MSG.country
        this.form.city = response.data.MSG.city
        this.form.tags_content = response.data.MSG.tags_content
        this.form.campaign_type = response.data.MSG.campaign_type
        this.form.campaign_category = response.data.MSG.campaign_category
      })
      .catch(err => {
        this.$awn.alert("Campanha não encontrada!")
      })
  },
  methods: {
    saveCampaign: function() {
      this.hasChanges = false
      this.form.id = this.$route.params.id
      this.$awn.asyncBlock(global.$post("/Campaign/main_edit", this.form, this.user.token))
        .then(response => {
          this.$awn.success("Campanha salva com sucesso!")
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao salvar a campanha!")
        })
    }
  },
  data() {
    return {
      hasChanges: false,
      campaignsCategory: [],
      form: {
        status: 'inactive',
        cash: '',
        description: '',
        title: '',
        end_date: null,
        coin_type: 'USD',
        country: '',
        city: '',
        campaign_category: 1,
        tags_content: '',
        campaign_type: 'funding_flexible'
      },
      currencys: [{
          text: 'Dólar Americano',
          value: 'USD'
        },
        {
          text: 'Euro',
          value: 'EUR'
        },
        {
          text: 'Real Brasileiro',
          value: 'BRL'
        },
      ]
    }
  },
  watch: {
    hasChanges: function(next) {
      window.onbeforeunload = next ? (function() {
        return "Are you sure you want to close the window?"
      }) : null
    }
  },
  beforeRouteLeave(to, from, next) {
    if (this.hasChanges) {
      const answer = window.confirm('Deseja sair antes de salvar a campanha?')
      if (answer) {
        next()
      } else {
        next(false)
      }
    } else {
      next()
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.mainCampaignCss {
    .wrap-admin {

        margin-top: 30px;
        margin-bottom: 30px;

        .admin-right-container {

            $gray: gray;

            .inputs {
                margin-bottom: 20px;
            }

            .area-1 {
                ::-webkit-input-placeholder {
                    font-size: 13px;
                    font-weight: 300;
                }
                ::-moz-placeholder {
                    font-size: 13px;
                    font-weight: 300;
                }
                :-ms-input-placeholder {
                    font-size: 13px;
                    font-weight: 300;
                }
                :-moz-placeholder {
                    font-size: 13px;
                    font-weight: 300;
                }

                .titleCard {
                    font-size: 14px;
                    color: gray;
                    font-weight: 300;
                }
                .div-border {
                    height: 100%;
                }
                input,
                select,
                textarea {
                    height: 31px;
                    font-size: 13px;
                    color: gray;
                    font-weight: bold;
                }
                textarea {
                    height: 100px;
                }

            }

            .top {

                .right {
                    display: flex;
                    margin-top: 5px;
                }

                button {
                    height: 22px;
                    font-size: 10px;
                }

            }

            .main-title {
                font-size: 17px;
                color: $blue;
                font-weight: 600;
            }

            .subtitle {
                font-size: 11px;
                color: $gray;
                // width: 50%;
                margin-bottom: 5px;
            }

            .gallery {
                border: 1px dotted $gray-input;
                border-radius: 5px;
                padding: 20px;
                margin-top: 20px;
                display: flex;

                .img-wrap {
                    padding-right: 40px;
                    .image {
                        height: 150px;
                        width: 190px;
                        background-size: cover;
                        border-radius: 5px;
                        border: 1px solid $gray-input;
                        position: relative;
                    }
                    .descr {
                        width: 190px;
                        margin-top: 10px;
                    }
                }
            }
            .wrap {
                display: inline-flex;
            }

        }

    }

    @media only screen and (max-width: 768px) {

        .admin-right-container {

            .div-border {
                height: auto!important;
            }

            .wrap {
                display: block;
            }

            .gallery {
                display: block;

                .img-wrap {
                    padding-right: 0px!important;
                    width: 100%;

                    .image {
                        width: 100%!important;
                    }

                    .inputs {
                        width: 100%;
                        input {
                            width: 100%!important;
                            margin-bottom: 30px;
                        }
                    }

                }

            }

        }
    }
}
</style>
