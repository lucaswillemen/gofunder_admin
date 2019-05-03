<template>
<div class="listContent">

  <main-header></main-header>
  <div class="container wrap-admin">
    <b-row>
      <b-col lg="3">
        <sidebar-admin></sidebar-admin>
      </b-col>
      <b-col lg="9">
        <div class="container admin-right-container">
          <b-row class="area-1">
            <b-col lg="12">
              <div>
                <div class="title">
                  <span>Lançar minha campanha</span>
                </div>
                <div class="subtitle">
                  A partir desse momento, você irá lançar sua campanha. <br>
                  Após lançada sua campanha <b>não poderá mais ser editada</b>!<br>
                  Lembre-se de pre-visualizar (preview) sua campanha antes pra ver como ela ficará em nossa página
                </div>
                <div class="alert alert-danger" role="alert" v-show="erros.length">
                  <small>
                    <i class="fa fa-exclamation-circle"></i>
                    Existem alguns erros na sua campanha. Corrija-os antes de lançar ela <br><br>
                    <ol>
                      <li v-for="item in erros">{{item}}</li>
                    </ol>
                  </small>
                </div>
                <div class="botoes">
                  <div class="btn-border-blue">
                    <b-button @click="launchCampaign()" :disabled="erros.length !== 0">Sim, entendo e quero lançar minha campanha</b-button>
                  </div>
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
  mapState,
  mapActions
} from 'vuex'
export default {
  computed: {
    ...mapState(['user'])
  },
  mounted() {
    this.loadCampaign()
  },
  methods: {
    launchCampaign() {
      this.$awn.asyncBlock(global.$post("/Campaign/launch", {
          id: this.$route.params.id
        }, this.user.token))
        .then(response => {
          location.href = "/#/project-info/" + this.$route.params.id
          this.$awn.success("Campanha foi lançada com sucesso!")
        })
        .catch(err => {
          this.$awn.alert("Campanha não encontrada!")
        })
    },

    loadCampaign() {
      this.$awn.asyncBlock(global.$post("/Campaign/info", {
          id: this.$route.params.id
        }, this.user.token))
        .then(response => {
          let campaign = response.data.MSG

          if (campaign.title.length < 16 || campaign.title.length > 64) this.erros.push("O titulo de sua campanha deve ter entre 16 e 64 caracteres")
          if (campaign.description.length < 64 || campaign.description.length > 128) this.erros.push("A descrição de sua campanha deve ter entre 64 e 128 caracteres")
          if (campaign.cash < 100) this.erros.push("O valor da sua campanha deve ser maior que $100,00")
          if (!campaign.image_galery.split("|") || campaign.image_galery.split("|").length < 3) this.erros.push("Sua galeria deve conter no mínimo 3 fotos para campanha")
          if (!campaign.country || !campaign.city) this.erros.push("Sua campanha não tem uma localização adequada: Cidade e Pais")
          if (campaign.campaign_overview.length < 192 || campaign.description.length > 320) this.erros.push("O resumo de sua campanha deve ter entre 192 e 320 caracteres")
          if ((new Date(campaign.end_date).getTime() <= new Date().getTime())) this.erros.push("A data final da sua campanha deve ser no futuro")
          if (!campaign.image_overlay) this.erros.push("Você não definiu uma imagem principal para sua campanha")


          if (campaign.perks) {
            let perks = campaign.perks
            let perks_title = false
            let perks_stock = false
            let perks_description = false
            let perks_image = false
            let perks_delivery_date = false
            let perks_delivery_price = false
            let perks_item_title = false
            let perks_item_stock = false

            for (var i in perks) {
              if (!perks_stock && (perks[i].perk_stock <= 0)) {
                this.erros.push("O estoque de um de suas recompensas não deve ser inferior a um")
                perks_stock = true
              }
              if (!perks_title && (perks[i].perk_title.length < 6 || perks[i].perk_title.length > 32)) {
                this.erros.push("O titulo de um das suas recompensas deve ter entre 12 a 32 caracteres")
                perks_title = true
              }
              if (!perks_description && (perks[i].perk_description.length < 16 || perks[i].perk_description.length > 255)) {
                this.erros.push("A descrição de uma das suas recompensas deve ter entre 16 a 255 caracteres")
                perks_description = true
              }
              if (!perks_image && !perks[i].perk_image) {
                this.erros.push("Uma de suas recompensas não tem uma imagem valida!")
                perks_image = true
              }
              if (!perks_delivery_date && (new Date(perks[i].perk_delivery_date).getTime() <= new Date().getTime())) {
                this.erros.push("A data de entrega de uma recompensa sua deve ser superior ao dia de hoje!")
                perks_delivery_date = true
              }
              try {
                let perks_items = JSON.parse(perks[i].perk_item_info)
                for (var g in perks_items) {
                  if (!perks_item_stock && perks_items[g].stock <= 0) {
                    this.erros.push("O estoque de um dos seus itens de recompensa deve ser maior que zero!")
                    perks_item_stock = true
                  }
                  if (!perks_item_title && (!perks_items[g].title || perks_items[g].title.length < 6 || perks_items[g].title.length > 32)) {
                    this.erros.push("O titulo de um dos seus itens de recompensa deve ter entre 6 a 32 caracteres")
                    perks_item_title = true
                  }
                }
              } catch (exp) {}
              try {
                let perk_shipping_info = JSON.parse(perks[i].perk_shipping_info)
                for (var j in perk_shipping_info) {
                  if (!perks_delivery_price && perk_shipping_info[j].price <= 0) {
                    this.erros.push("O preço de uma das suas entregas precisa ser maior que $0,00")
                    perks_delivery_price = true
                  }
                }
              } catch (exp) {}
            }
          }
        })
        .catch(err => {
          this.$awn.alert("Campanha não encontrada!")
        })
    }
  },
  data() {
    return {
      erros: [],
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/table.scss";

.listContent {
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
    input {
        font-size: 14px!important;
        font-weight: bold!important;
        color: gray;
    }
    .wrap-admin {
        margin-top: 30px;
        margin-bottom: 30px;
        .admin-right-container {
            width: 100%;
            border: 1px solid $orange;
            border-radius: 6px;
            .botoes {
                display: flex;
                float: left;
            }
            #removeReward {
                cursor: pointer;
            }
            $gray: gray;
            .area-1 {
                margin-top: 15px;
                margin-bottom: 0;
                .title {
                    font-size: 17px;
                    color: $blue;
                    font-weight: 600;
                }
                .subtitle {
                    font-size: 12px;
                    color: $gray;
                    width: 70%;
                    margin-bottom: 30px;
                }
                .secret {
                    .title {
                        font-size: 12px;
                        color: gray;
                        display: block;
                    }

                    input {
                        width: 300px;
                    }
                }
                .visibility {
                    .title {
                        font-size: 12px;
                        color: gray;
                        display: block;
                    }
                    .subtitle {
                        font-size: 12px;
                        color: gray;
                        margin-bottom: 20px;
                    }
                }
            }
            .area-6 {
                .local {
                    display: block;
                    width: 100%;
                    float: left;
                    padding: 25px;
                    border: 2px solid $gray-input;
                    border-radius: 5px;
                }
                #div-input-local {
                    overflow: auto;

                    .input-taxa {
                        width: 100px;
                    }
                }
            }
            .inputs {
                margin-bottom: 20px;
            }
            .botoes {
                margin-bottom: 40px;
            }
        }
    }
}
</style>
