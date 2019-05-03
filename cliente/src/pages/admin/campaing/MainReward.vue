<template>
<div class="mainRewardCss">
  <div id="accordion">
    <main-header></main-header>
    <b-modal id="editReward" ref="editReward" hide-footer header-bg-variant="dark" header-text-variant="light" size="lg" title="Escolha as informações básicas para seu item">
      <div class="main-title">
        Informações gerais
      </div>
      <div role="group" class="mb-5 mt-2">
        <b-row class="mb-5 mt-2">
          <b-col cols="12" md="6">
            <label class="labelClass" for="inputLive">Titulo</label>
            <b-input-group size="sm" prepend='<i class="fa fa-font"></i>'>
              <b-form-input id="inputLive" size="sm" v-model.trim="item.title" type="text" placeholder="Ex: Camiseta"></b-form-input>
            </b-input-group>
            <b-form-text>
              O titulo para seu item deverá conter entre 12 e 44 caracteres
            </b-form-text>
          </b-col>
          <b-col cols="12" md="6">
            <label class="labelClass" for="inputLive2">Estoque disponível</label>
            <b-input-group size="sm" prepend='<i class="fa fa-list-ol"></i>'>
              <b-form-input id="inputLive2" type="number" size="sm" placeholder="Estoque disponível" v-model="item.stock"></b-form-input>
            </b-input-group>
            <b-form-text>
              O estoque servirá para controle de quantos item ainda podem ser distribuídos
            </b-form-text>
          </b-col>
        </b-row>
      </div>
      <div role="group">
        <div class="btn-noborder mtop mt-5 mb-3">
          <b-button @click="saveItem()">Salvar Item</b-button>
        </div>
      </div>
    </b-modal>
    <b-modal id="createReward" ref="createReward" hide-footer header-bg-variant="dark" header-text-variant="light" size="lg" title="Escolha as informações básicas para seu item">
      <div class="main-title">
        Informações gerais
      </div>
      <div role="group" class="mb-5 mt-2">
        <b-row class="mb-5 mt-2">
          <b-col cols="12" md="6">
            <label class="labelClass" for="inputLive">Titulo</label>
            <b-input-group size="sm" prepend='<i class="fa fa-font"></i>'>
              <b-form-input id="inputLive" size="sm" v-model.trim="item.title" type="text" placeholder="Ex: Camiseta"></b-form-input>
            </b-input-group>
            <b-form-text>
              O titulo para seu item deverá conter entre 12 e 44 caracteres
            </b-form-text>
          </b-col>
          <b-col cols="12" md="6">
            <label class="labelClass" for="inputLive2">Estoque disponível</label>
            <b-input-group size="sm" prepend='<i class="fa fa-list-ol"></i>'>
              <b-form-input id="inputLive2" type="number" size="sm" placeholder="Estoque disponível" v-model="item.stock"></b-form-input>
            </b-input-group>
            <b-form-text>
              O estoque servirá para controle de quantos item ainda podem ser distribuídos
            </b-form-text>
          </b-col>
        </b-row>
      </div>
      <div role="group">
        <div class="btn-noborder mtop mt-5 mb-3">
          <b-button @click="createItem()">Salvar Item</b-button>
        </div>
      </div>
    </b-modal>
    <b-modal id="createItensReward" ref="createItensReward" hide-footer header-bg-variant="dark" header-text-variant="light" size="lg" title="Editar opções de itens">
      <div class="mb-5 mt-2">
        <div class="main-title">
          Adicionar opções de item (opcional)
        </div>
        <div class="subtitle mb-5">
          Você deseja adicionar itens a esse produto? <br>
          Ex: O usuário poderá escolher a cor de uma camiseta e o tamanho dela
          <div class="mt-3" v-if="tempItems.length == 0">
            <input type="radio" id="one" value="yes" v-model="optionsItensAdd">
            <label for="one">Sim eu desejo adicionar opção de itens</label>
            <br>
            <input type="radio" id="two" value="no" v-model="optionsItensAdd">
            <label for="two">Não, não desejo adicionar opção de itens</label>
          </div>
        </div>
        <b-row v-show="optionsItensAdd=='yes'||tempItems.length > 0">
          <b-col cols="12" md="4">
            <label for="inputLabel1" class="labelClass">Parâmetro</label>
            <b-input-group size="sm" prepend='<i class="fa fa-list-ol"></i>'>
              <b-form-input id="inputLabel1" type="text" size="sm" placeholder="Cor" v-model="paramSubitem"></b-form-input>
            </b-input-group>
          </b-col>
          <b-col cols="12" md="4">
            <label for="inputLabel2" class="labelClass">Valor</label>
            <b-input-group size="sm" prepend='<i class="fa fa-list"></i>'>
              <b-form-input id="inputLabel2" type="text" size="sm" placeholder="Azul" v-model="valueSubitem"></b-form-input>
            </b-input-group>
          </b-col>
          <b-col cols="12" md="4">
            <div class="btn-noborder buttonAlign mb-3">
              <b-button @click="createSubitem()" :disabled="!paramSubitem || !valueSubitem">Adicionar Item</b-button>
            </div>
          </b-col>
        </b-row>
        <div class="table mb-5 mt-3">
          <table class="table b-table" v-show="tempItems.length > 0">
            <thead>
              <tr>
                <th>Parâmetro</th>
                <th>Opção</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in tempItems">
                <td>{{item.param}}</td>
                <td>{{item.value}}</td>
                <td>
                  <button type="button" class="btn btn-danger btn-xs" @click="remSubitem(item)">
                    <i class="fa fa-eraser"></i> Remover
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </b-modal>
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
                <topbar-admin :items="[{text: 'Rascunho', href: '#' },{text:'Editar Recompensa', active: true }]"></topbar-admin>
              </b-col>
            </b-row>
            <b-row class="area-1">
              <b-col lg="12">
                <div class="main-title">
                  <span>Informações de Recompensas</span>
                </div>
                <div class="subtitle">
                  Altere aqui informações da sua recompensa
                </div>
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Informações Gerais
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                      <div class="content">

                        <div class="mt-5 mb-5">
                          <b-row>
                            <b-col cols="12" md="4">
                              <div class="titleCard">
                                <span>Qual valor de doação necessário?</span>
                              </div>
                              <b-input-group size="sm" prepend='<i class="fa fa-money"></i>'>
                                <b-form-input id="perk_min_donation" step="0.01" placeholder="Digite o valor mínimo para ganhar essa recompensa.." type="number" @change="hasChanges = true" v-model="form.perk_min_donation"></b-form-input>
                              </b-input-group>
                              <small>Esse valor é qual quantia mínima o contribuente deve doar para receber a recompensa</small>
                            </b-col>
                            <b-col cols="12" md="4">
                              <div class="titleCard">
                                <span>Qual estimativa de entrega?</span>
                              </div>
                              <b-input-group size="sm" prepend='<i class="fa fa-calendar"></i>'>
                                <b-form-input id="perk_delivery_date" type="date" @change="hasChanges = true" v-model="form.perk_delivery_date"></b-form-input>
                              </b-input-group>
                              <small class="text-danger" v-show="form.perk_delivery_date && new Date(form.perk_delivery_date).getTime() <= new Date().getTime()">Sua data é inválida, deve ser superior ao dia de hoje</small>
                            </b-col>
                            <b-col cols="12" md="4">
                              <div class="titleCard">
                                <span>Qual valor do estoque atual?</span>
                              </div>
                              <b-input-group size="sm" prepend='<i class="fa fa-list-ol"></i>'>
                                <b-form-input id="perk_stock" step="0.01" placeholder="Digite a quantia estoque.." @change="hasChanges = true" type="number" v-model="form.perk_stock"></b-form-input>
                              </b-input-group>
                              <small>Esse valor representa quantas vezes esse recompensa será distribuída</small>
                            </b-col>
                          </b-row>
                        </div>
                        <div class="mt-5 mb-5">
                          <b-row>
                            <b-col cols="12" md="6">
                              <div class="titleCard">
                                <span>Qual nome da recompensa</span>
                              </div>
                              <b-input-group size="sm" prepend='<i class="fa fa-font"></i>'>
                                <b-form-input id="perk_title" type="text" v-model="form.perk_title" @change="hasChanges = true" placeholder="Nome da Recompensa"></b-form-input>
                              </b-input-group>
                              <small class="text-danger" v-show="!form.perk_title || (form.perk_title.length < 6 || form.perk_title.length > 32)">Seu titulo deve ter entre 6 e 32 caracteres</small>
                            </b-col>
                            <b-col cols="12" md="6">
                              <div class="titleCard">
                                <span>A recompensa é visível?</span>
                              </div>
                              <label class="switch">
                                <input type="checkbox" @change="hasChanges = true" v-model="form.perk_secret">
                                <span class="slider round"></span>
                              </label>
                            </b-col>
                          </b-row>
                        </div>
                        <div class="mt-5 mb-5">
                          <span class="titleCard mb-5">
                            Imagem de Overlay <font color=red style="opacity:0.7;">*</font>
                          </span>
                          <br>
                          <span class="info mt-5">
                            Clique na imagem abaixo para editar a imagem que irá aparecer na apresentação da recompensa
                          </span>
                          <br>
                          <div>
                            <div class="boxBlockUpload" v-if="!imageOverlay">
                              <b-img :src="$apiEndpoint + 'uploads/upload.png'" class="overlayImageUpload"></b-img>
                              <input type="file" class="overlayButtonUpload" name="myFile" v-on:change="setOverlayImage">
                            </div>
                            <div class="boxBlock" v-if="imageOverlay">
                              <b-img :src="$apiEndpoint + imageOverlay" class="overlayImage"></b-img>
                              <input type="file" class="overlayButton" name="myFile" v-on:change="setOverlayImage">
                            </div>
                          </div>
                        </div>
                        <div class="mt-5 mb-5">
                          <div class="titleCard">
                            <span>Qual descrição da recompensa</span>
                          </div>
                          <b-form-textarea :rows="2" id="perk_description" @change="hasChanges = true" v-model="form.perk_description" placeholder="Digite aqui uma breve descrição da recompensa"></b-form-textarea>
                          <small class="text-danger" v-show="!form.perk_description || (form.perk_description.length > 255 || form.perk_description.length < 16)">Sua descrição deve ter entre 16 e 255 caracteres</small>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Produtos e Itens
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                      <div class="content">
                        <div class="mt-5 mb-5">
                          <div class="main-title">
                            <span>Produtos e Itens</span>
                          </div>
                          <div class="mb-5">
                            Nessa guia você configura produtos que que estão inclusos nessa recompensa.<br>
                            Clicando em <b>ITENS</b> você pode especificar parâmetros para seu produto <br>
                            isso permite por exemplo o usuário que o usuário escolha entre uma camisa AZUL ou LARANJA<br>
                            Lembre-se que todos produtos aqui embaixo farão parte da recompensa do usuário
                          </div>
                          <button type="button" class="btn btn-success btn-sm" v-b-modal.createReward>
                            <i class="fa fa-plus"></i> Adicionar Produto
                          </button>
                          <br>
                          <br>
                          <div class="table">
                            <table class="table b-table" v-show="perk_item_info.length > 0">
                              <thead>
                                <tr>
                                  <th>Nome Item</th>
                                  <th>Estoque</th>
                                  <th>Ações</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="perk in perk_item_info">
                                  <td>{{perk.title}}</td>
                                  <td>{{perk.stock}}</td>
                                  <td>
                                    <span>
                                      <div class="acoes">
                                        <button type="button" class="btn btn-primary btn-xs" @click="itensProduct(perk.id)">
                                          <i class="fa fa-plus"></i> Itens
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs" @click="remProduct(perk)">
                                          <i class="fa fa-eraser"></i> Remover
                                        </button>
                                        <button type="button" class="btn btn-success btn-xs" @click="editProduct(perk.id)">
                                          <i class="fa fa-check"></i> Editar
                                        </button>
                                      </div>
                                    </span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                      <button class="btn collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Entrega e Valores
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                      <div class="content">
                        <div class="mt-5">
                          <div class="main-title">
                            <span>Endereços e entregas</span>
                          </div>
                          <div class="mb-5">
                            Caso você tenha um produto físico de recompensa você poderá <br>
                            nessa guia ajustar os valores do frete para cada país escolhido<br>
                            Se desejar pode colocar um frete fixo para todo mundo ou paises específicos<br>
                            Caso sua recompensa não exige entrega poderá deixar este campo opcional
                          </div>
                          <div class="table mb-5 mt-3">
                            <table class="table b-table" v-show="perk_shipping_info.length > 0">
                              <thead>
                                <tr>
                                  <th>Pais</th>
                                  <th>Valor do Frete</th>
                                  <th>Ações</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in perk_shipping_info">
                                  <td><i :class="item.locale.icon"></i> {{item.locale.label}}</td>
                                  <td>{{item.price | currency}}</td>
                                  <td>
                                    <button type="button" class="btn btn-danger btn-xs" @click="remFrete(item)">
                                      <i class="fa fa-eraser"></i> Remover
                                    </button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                        </div>
                        <div class="mt-5">
                          <b-row>
                            <b-col class="selectAddress" cols="12" md="4">
                              <div class="titleCard">
                                <span>Endereços de entrega</span>
                              </div>
                              <v-select class="select2-style" @change="hasChanges = true" v-model="countrySendShipping" :options="world_countrys" label="label">
                                <template slot="option" slot-scope="option">
                                  <span :class="option.icon"></span>
                                  {{ option.label }}
                                </template>
                              </v-select>
                              <small>
                                Adicione os paises e seus respectivos valores para entrega
                              </small>
                            </b-col>
                            <b-col cols="12" md="4">
                              <div class="titleCard">
                                <span>Valor para entregar</span>
                              </div>
                              <b-input-group size="sm" prepend='<i class="fa fa-money"></i>'>
                                <b-form-input id="perk_shipping_money" type="number" @change="hasChanges = true" v-model="moneySendShipping" placeholder="Valor para Envio"></b-form-input>
                              </b-input-group>
                              <small>
                                A moeda utilizada para cobrança do frete é a mesma moeda da campanha
                              </small>
                            </b-col>
                            <b-col cols="12" md="4">
                              <div class="mt-4">
                                <button :disabled="!countrySendShipping || !countrySendShipping.label" type="button" class="btn btn-success btn-sm" @click="addFrete()">
                                  <i class="fa fa-check"></i> Adicionar
                                </button>
                              </div>
                            </b-col>
                          </b-row>
                        </div>
                      </div>
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
    this.$awn.asyncBlock(global.$post("/Perk/info", {
        id: this.$route.params.perk_id,
        campaign_id: this.$route.params.id,
      }, this.user.token))
      .then(response => {
        this.form = response.data.MSG
        this.imageOverlay = this.form.perk_image
        if (this.form.perk_shipping_info && this.form.perk_shipping_info.length > 1) {
          this.perk_shipping_info = JSON.parse(this.form.perk_shipping_info)
        }
        if (this.form.perk_item_info && this.form.perk_item_info.length > 1) {
          this.perk_item_info = JSON.parse(this.form.perk_item_info)
        }
      })
      .catch(err => {
        this.$awn.alert("Recompensa não encontrada")
      })
  },
  methods: {
    remSubitem: function(obj) {
      this.$awn.confirm("Tem certeza que deseja deletar?", ss => {
        this.hasChanges = true
        this.tempItems = this.tempItems.filter((el) => el !== obj)
        for (var i in this.perk_item_info) {
          if (this.perk_item_info[i].id == this.editingProductId) {
            this.perk_item_info[i].options = this.tempItems
          }
        }
      })
    },
    remProduct: function(obj) {
      this.$awn.confirm("Tem certeza que deseja deletar?", ss => {
        this.hasChanges = true
        this.perk_item_info = this.perk_item_info.filter((el) => el !== obj)
      })
    },
    remFrete: function(obj) {
      this.$awn.confirm("Tem certeza que deseja deletar?", ss => {
        this.hasChanges = true
        this.perk_shipping_info = this.perk_shipping_info.filter((el) => el !== obj)
      })
    },
    itensProduct: function(id) {
      this.editingProductId = id
      for (var i in this.perk_item_info) {
        if (this.perk_item_info[i].id == this.editingProductId) {
          this.tempItems = this.perk_item_info[i].options
        }
      }
      this.$refs.createItensReward.show()
    },
    saveItem: function() {
      for (var i in this.perk_item_info) {
        if (this.perk_item_info[i].id == this.editingProductId) {
          this.perk_item_info[i].title = this.item.title
          this.perk_item_info[i].stock = this.item.stock
        }
      }
      this.hasChanges = true
      this.$refs.editReward.hide()
    },
    editProduct: function(id) {
      this.editingProductId = id
      for (var i in this.perk_item_info) {
        if (this.perk_item_info[i].id == this.editingProductId) {
          this.item.title = this.perk_item_info[i].title
          this.item.stock = this.perk_item_info[i].stock
        }
      }
      this.$refs.editReward.show()
    },
    setOverlayImage(e) {
      this.$awn.asyncBlock(global.$post("/Perk/send_img", {
          fileToUpload: e.target.files[0]
        }, this.user.token))
        .then(response => {
          this.imageOverlay = response.data.MSG
          this.hasChanges = true
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao hospedar imagem")
        })
    },
    saveCampaign: function() {
      this.hasChanges = false
      this.form.perk_image = this.imageOverlay
      this.form.campaign_id = this.$route.params.id
      this.form.id = this.$route.params.perk_id
      this.form.perk_shipping_info = JSON.stringify(this.perk_shipping_info)
      this.form.perk_item_info = JSON.stringify(this.perk_item_info)
      this.$awn.asyncBlock(global.$post("/Perk/edit", this.form, this.user.token))
        .then(response => {
          this.$awn.success("Recompensa salva com sucesso")

        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao salvar a recompensa")
        })
    },
    createItem: function() {
      this.perk_item_info.push({
        id: Math.random().toString(36).substring(7),
        title: this.item.title,
        stock: this.item.stock,
        options: []
      })
      this.hasChanges = true
      this.$refs.createReward.hide()
    },
    createSubitem: function() {
      let exists = false
      for (var i in this.tempItems) {
        if (this.tempItems[i].param === this.paramSubitem && this.tempItems[i].value === this.valueSubitem) {
          exists = true
          break;
        }
      }
      if (exists) {
        return this.$awn.alert("Esse subitem de produto já existe!")
      }
      this.hasChanges = true
      this.tempItems.push({
        param: this.paramSubitem,
        value: this.valueSubitem
      })
      for (var i in this.perk_item_info) {
        if (this.perk_item_info[i].id == this.editingProductId) {
          this.perk_item_info[i].options = this.tempItems
        }
      }
    },
    addFrete: function() {
      let exists = false
      for (var i in this.perk_shipping_info) {
        if (this.perk_shipping_info[i].locale.label === this.countrySendShipping.label) {
          exists = true
          break;
        }
      }
      if (exists) {
        return this.$awn.alert("Esse pais já existe")
      }
      this.hasChanges = true
      this.perk_shipping_info.push({
        locale: this.countrySendShipping,
        price: this.moneySendShipping
      })
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
  },
  data() {
    return {
      hasChanges: false,
      editingProductId: false,
      optionsItensAdd: 'no',
      subitem: {},
      tempItems: [],
      item: {
        title: '',
        stock: '',
        options: []
      },
      paramSubitem: null,
      valueSubitem: null,
      perk_shipping_info: [],
      perk_item_info: [],
      countrySendShipping: "Selecione um lugar",
      moneySendShipping: 0.00,
      imageOverlay: '',
      form: {
        perk_status: 'inactive',
        perk_stock: '',
        perk_min_donation: '',
        perk_description: '',
        perk_title: '',
        perk_delivery_date: null,
        perk_secret: false
      },
      status_campaign: [{
          text: 'Desativada',
          value: 'disabled'
        },
        {
          text: 'Ativada',
          value: 'enabled'
        },
        {
          text: 'Fora de Estoque',
          value: 'outofstock'
        }
      ],
      world_countrys: require('@/assets/country.json')
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/table.scss";
@import "Styles/switch.scss";

.mainRewardCss {
    .btn-group-xs > .btn,
    .btn-xs {
        padding: 0.15rem 0.2rem;
        font-size: 0.7rem;
        line-height: 0.3;
        border-radius: 0.1rem;
    }

    .selectAddress {
        .dropdown-toggle {
            height: 31px;
        }

    }

    .labelPerso {
        font-size: 11px;
        font-weight: bold;
        color: gray;
        opacity: 0.7;
    }

    .wrap-admin {
        margin-top: 30px;
        margin-bottom: 30px;
        .admin-right-container {
            $gray: gray;
            .inputs {
                margin-bottom: 20px;
            }
            .area-1 {
                .card {
                    border-width: 0;
                }
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
                margin-bottom: 30px;
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

    .boxBlockUpload {
        border: 2px;
        position: relative;
        color: gray;
        background-color: transparent;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 20px;
        font-weight: bold;
        height: 100px;
        .overlayImageUpload {
            display: block;
            height: 100px;
        }
        .overlayButtonUpload {
            position: relative!important;
            height: 100px!important;
            margin-top: -100px!important;
            width: 70%;
            opacity: 0.0;
        }
    }
    .boxBlock {
        position: relative;
        color: gray;
        background-color: transparent;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 20px;
        font-weight: bold;
        width: 100%;
        height: 400px;
        .overlayImage {
            display: block;
            width: 90%;
            height: 100%;
        }
        .overlayButton {
            position: relative!important;
            height: 400px!important;
            margin-top: -400px!important;
            width: 70%;
            opacity: 0.0;
        }
    }
    .buttonAlign {
        margin-top: 30px;
    }
    .select2-style {
        max-height: 31px;
        font-size: 12px;
    }
}
</style>
