<template>
<div class="listContent">
  <b-modal id="createReward" ref="createReward" hide-footer header-bg-variant="dark" header-text-variant="light" size="lg" title="Escolha as informações básicas para seu perk" @ok="createReward()">
    <div role="group" class="mb-5 mt-2">
      <label class="labelClass" for="inputLive">Titulo para o Perk</label>
      <b-input-group size="sm" prepend='<i class="fa fa-font"></i>'>
        <b-form-input id="inputLive" size="sm" v-model.trim="form.perk_title" type="text" placeholder="Entre com um titulo para seu Perk"></b-form-input>
      </b-input-group>
      <b-form-text>
        O titulo para seu Perk deverá conter entre 12 e 44 caracteres
      </b-form-text>
    </div>
    <b-row>
      <b-col>
        <label class="labelClass" for="inputLive2">Estoque disponível</label>
        <b-input-group size="sm" prepend='<i class="fa fa-list-ol"></i>'>
          <b-form-input id="inputLive2" type="number" size="sm" placeholder="Estoque disponível" v-model="form.perk_stock"></b-form-input>
        </b-input-group>
        <b-form-text>
          O estoque servirá para controle de quantos Perks ainda podem ser distribuídos
        </b-form-text>
      </b-col>
      <b-col>
        <label class="labelClass" for="inputLive3">Estimativa de entrega</label>
        <b-input-group size="sm" prepend='<i class="fa fa-calendar"></i>'>
          <b-form-input id="inputLive3" size="sm" type="date" placeholder="" v-model="form.perk_delivery_date"></b-form-input>
        </b-input-group>
        <b-form-text>
          A data de envio serve para informar aos usuários qual estimativa para data de envio do Perk
        </b-form-text>
      </b-col>
    </b-row>
    <div role="group" class="mb-2 mt-5">
      <b-form-checkbox v-model="form.perk_secret" value="1">
        <label class="labelClass">Este perk não deve estar visível para os usuários</label>
      </b-form-checkbox>
      <b-form-text>
        Com essa opção ativada essa recompensa será secreta para quem doar.
      </b-form-text>
    </div>
    <div role="group">
      <div class="btn-noborder mtop mt-5 mb-3">
        <b-button @click="createPerk()">Criar Recompensa</b-button>
      </div>
    </div>
  </b-modal>
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
              <topbar-admin :items="[  				{ text: 'Rascunho', href: '#' }, { text: 'Recompensas de Campanha', active: true }]"></topbar-admin>
            </b-col>
          </b-row>
          <b-row class="area-1">
            <b-col lg="12">
              <div>
                <div class="title">
                  <span>Detalhes da Recompensa</span>
                </div>
                <div class="subtitle">
                  Recompensas são prêmios que você fornece para membros que fizerem doação para seus projetos
                </div>
                <div class="botoes">
                  <div class="btn-border-blue">
                    <b-button v-b-modal.createReward>Criar Recompensa</b-button>
                  </div>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="area-2">
            <b-col lg="12">
              <div class="table" v-show="perks.length">
                <table class="table b-table">
                  <thead>
                    <tr>
                      <th>Nome pacote</th>
                      <th>Doação Mínima</th>
                      <th>Estoque</th>
                      <th>Shipping</th>

                      <th>Acoes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="perk in perks">
                      <td>{{perk.perk_title}}</td>
                      <td>{{perk.perk_min_donation}}</td>
                      <td>{{perk.perk_stock}}</td>
                      <td>{{perk.perk_delivery_date}}</td>
                      <td><span>
                          <div class="acoes">
                            <span><a class="orange" :href="'/#/user/campaing/reward/edit/'  + $route.params.id + '/' + perk.id">Editar</a>
                              <span class="separator">|</span>
                              <span class="blue" id="removeReward" @click="deletePerk(perk.id)">Remover</span>
                            </span>
                          </div>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
    this.loadPerks()
  },
  methods: {
    saveCampaign: function() {

    },
    deletePerk: function(perk_id) {
      this.$awn.confirm("Desejar deletar mesmo?", suc => {
        return this.$awn.asyncBlock(global.$post("/Perk/delete", {
            id: perk_id,
            campaign_id: this.$route.params.id
          }, this.user.token))
          .then(response => {
            this.$awn.success("O perk foi deletado")
            this.loadPerks()
          })
      }, err => {
        this.$awn.alert("Erro ao deletar o perk")
      })
    },
    loadPerks: function() {
      this.$awn.asyncBlock(global.$post("/Perk/list", {
          campaign_id: this.$route.params.id
        }, this.user.token))
        .then(response => {
          this.perks = response.data.MSG
        })
        .catch(err => {
          this.$awn.alert("Campanha não encontrada")
        })
    },
    createPerk: function() {
      this.form.campaign_id = this.$route.params.id;
      this.$awn.asyncBlock(global.$post("/Perk/create", this.form, this.user.token))
        .then(response => {
          this.$awn.success("Recompensa criada com sucesso")
          this.$refs.createReward.hide()
        })
        .catch(err => {
          this.$awn.alert("Erro ao criar recompensa")
        })
        .finally(err => {
          this.loadPerks()
        })
    }
  },
  data() {
    return {
      hasChanges: false,
      perks: [],
      form: {
        perk_title: '',
        perk_secret: false,
        perk_min_donation: 0,
        perk_stock: '',
        perk_delivery_date: null
      }
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
                    font-size: 11px;
                    color: $gray;
                    width: 50%;
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
                        font-size: 14px;
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
