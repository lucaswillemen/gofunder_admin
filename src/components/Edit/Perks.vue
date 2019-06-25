<template>
<main>
  <md-dialog-alert :md-active.sync="alertError" md-title="Erro!" :md-content="alertErrorMsg" />
  <span class="md-layout-item md-small-size-100 md-size-100" v-if="perkList.length == 0">
    <md-card class="mt-layout-item">
      <md-empty-state md-icon="card_giftcard" :md-label="$f('PERKS::Crie seu perk!')" :md-description="$f('PERKS::Os perks servem como recompensa para as pessoas que doaram para sua campanha.')">
        <md-button class="md-primary md-raised" @click="perkDialog = true">{{"PERKS::Criar uma recompensa" | fix}}</md-button>
      </md-empty-state>
    </md-card>
  </span>
  <div class="md-layout md-grutter" v-else>
    <card-items :items="perkList">
      <template v-slot:img="itemProp">
        <div class="img-container">
          <img :src="$url +itemProp.item.cover_url" onerror="this.src='https://via.placeholder.com/150'" alt="" >
          <md-button class="md-fab md-mini delete-btn" @click="openDeleteConfirmation(itemProp.item.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </div>
      </template>
      <template v-slot:body="itemProp">
        <div class="item-body">
          <div class="item-title">
            <h2>{{itemProp.item.name}}</h2>
          </div>
          <div class="md-subhead">{{"PERKS::Valor mínimo para ganhar recompensa:" | fix}}
            <div>{{itemProp.item.price | currency}}</div>
          </div>
         <div class="item-description" style="margin-top: 1rem;">{{itemProp.item.description}}
         </div>
        </div>
      </template>
      <template v-slot:footer="itemProp">
        <div style="display: block; margin-top: auto">
          <md-button class="md-raised md-primary" @click="showModalEditPerk(itemProp.item)" style="width: 95%">{{"PERKS::Editar Recompensa" | fix}}</md-button>
        </div>
      </template>
    </card-items>
    <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
      <br>
      <md-button :disabled="parentCall && parentCall.loadingState()" class="md-fab md-primary" @click="perkDialog = true">
        <md-icon>add</md-icon>
      </md-button>
    </div>
  </div>
  <div>
    <md-dialog :md-active.sync="perkDialog">
      <md-dialog-title>{{"PERKS::Criar novo Perk" | fix}}</md-dialog-title>
      <md-dialog-content>
        <div class="md-layout md-gutter">
          <div class="md-layout-item md-small-size-100">
            <img :src="base64FilePerk" class="imagePerk /">
            <div v-if="!base64FilePerk">
              <input type="file"  style="display: none" id="input-file-perk" @change="pickImgPerk($event)" accept="image/*">
              <md-button @click="clickOnFileInputPerk()" class="md-raised md-primary">
                {{"PERKS::Adicionar uma Foto" | fix}} <md-icon>add_a_photo</md-icon>
              </md-button>
              <div v-if="$v.perk.image.$invalid && $v.perk.image.$dirty" style="color: #ff1744;">{{"PERKS::Insira uma imagem para o perk" | fix}} *</div>
            </div>
            <div v-if="base64FilePerk">
              <input type="file"  style="display: none" id="input-file-perk" @change="pickImgPerk($event)" accept="image/*">
              <md-button @click="clickOnFileInputPerk()" class="md-raised md-primary">
                {{"PERKS::Alterar essa foto" | fix}}<md-icon>add_a_photo</md-icon>
                <div v-if="$v.perk.image.$invalid && $v.perk.image.$dirty" style="color: #ff1744;">{{"PERKS::Insira uma imagem para o perk" | fix}}</div>
              </md-button>
            </div>
            <md-field :class="{'md-invalid': $v.perk.description.$invalid && $v.perk.description.$dirty}">
              <md-icon>description</md-icon>
              <label>{{"PERKS::Qual a descrição do seu perk?" | fix}}</label>
              <md-textarea v-model="perk.description" required md></md-textarea>
              <span class="md-error">{{"PERKS::Informe a descrição!" | fix}}</span>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100">
            <md-field :class="{'md-invalid': $v.perk.name.$invalid && $v.perk.name.$dirty}">
              <md-icon>title</md-icon>
              <label>{{"PERKS::Qual o nome da sua recompensa?" | fix}}</label>
              <md-input v-model="perk.name" required></md-input>
              <span class="md-error">{{"PERKS::Informe o titulo da sua recompensa" | fix}}</span>
            </md-field>
            <md-field :class="{'md-invalid': $v.perk.price.$invalid && $v.perk.price.$dirty}" class="md-focused money-input">
              <md-icon>attach_money</md-icon>
              <label>{{"PERKS::Qual o valor do seu perk?" | fix}}</label>
              <money class="md-input" v-model.number="perk.price" required></money>
              <span class="md-error">{{"PERKS::Informe o valor" | fix}}</span>
              <span class="md-helper-text">{{"PERKS::Insira o valor mínimo a ser doado em dólares para receber o perk" | fix}}</span>
            </md-field>
            <md-field :class="{'md-invalid': $v.perk.stock.$invalid && $v.perk.stock.$dirty}">
              <md-icon>store</md-icon>
              <label>{{"PERKS::Qual o estoque do seu perk?" | fix}}</label>
              <md-input v-mask="'######'" v-model.number="perk.stock" required></md-input>
              <span class="md-error">{{"PERKS::Informe o estoque" | fix}}</span>
              <span class="md-helper-text">{{"PERKS::Informe quantas pessoas devem podem resgatar esse prêmio" | fix}}</span>
            </md-field>
            <md-field :class="{'md-invalid': $v.perk.discount.$invalid && $v.perk.discount.$dirty}">
              <md-icon>money_off</md-icon>
              <label>
                {{"PERKS::Há um valor de desconto?" | fix}}
              </label>
              <span class="md-helper-text">{{"PERKS::Este valor é uma porcentagem de desconto para o valor de doação do seu perk" | fix}}</span>
              <md-input v-mask="'###'" v-model.number="perk.discount"></md-input>
              <span class="md-error ">{{"PERKS::Informe uma porcentagem válida!" | fix}}</span>

            </md-field>
          </div>
        </div>
        <md-switch class="md-primary" v-model="perk.haveFrete">{{"PERKS::Seu produto será enviado pelos correios?" | fix}}</md-switch>
        <div v-show="perk.haveFrete">
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-datepicker class="datepicker-correct-icon" :class="{'md-invalid': $v.perk.shipping_date.$invalid}" md-immediately v-model="perk.shipping_date" required>
                <label>{{"PERKS::Informe a data estimada de entrega da sua recompensa" | fix}}</label>
                <span class="md-helper-text">{{"PERKS::O usuário será informado que receberá o prêmio aproximadamente nessa data" | fix}}</span>
              </md-datepicker>
            </div>
          </div>
          <div>
            <b>{{"PERKS::Opções de envio:" | fix}}</b>
          </div>
          <div style="display:flex">
            <md-radio v-model="perk.shipping_worldwide" value="only_country">{{"PERKS::Meu produto será enviado apenas para o país" | fix}}</md-radio>
            <md-radio v-model="perk.shipping_worldwide" value="world_wide">{{"PERKS::Meu produto será enviado para diversos países" | fix}}</md-radio>
          </div>
          <div v-if="perk.shipping_worldwide == 'only_country'" class="md-layout-item md-small-size-100">
            <md-field :class="{'md-invalid': $v.perk.shipping_price.$invalid}" style="margin-top: 1rem;">
              <md-icon>commute</md-icon>
              <label>{{"PERKS::Qual o valor do frete?" | fix}}</label>
              <md-input v-model.number="perk.shipping_price" required></md-input>
              <span class="md-error">{{"PERKS::Informe o valor do frete em dólares!" | fix}}</span>
            </md-field>
          </div>
          <div v-else-if="perk.shipping_worldwide == 'world_wide'" class="md-layout-item md-small-size-100">
            <h4>{{"PERKS::Lista de frete:" | fix}} <span v-if="perk.shipping_data.length == 0"> {{"PERKS::Vazia!" | fix}}</span> </h4>
            <div class="shipping-list">
              <div v-for="(shipping, index) in perk.shipping_data" :key="index" class="shipping-added" @click="removeShippingPerk(index, perk.shipping_data)">
                <div class="shipping-added-text">
                  {{"PERKS::Remover" | fix}}
                </div>
                <div>
                  <md-icon>commute</md-icon>
                  {{shipping.country_name}} - {{shipping.price | currency}}
                </div>
              </div>
            </div>
            <div class="multiple-shipping-container">
              <div style="display: flex; flex-direction: column; width:90%;">
                <div style="text-align: center; margin: 1rem; 0">
                  <div>{{"PERKS::Escolha os países que você deseja entregar sua recompensa e seus respectivos valores de frete" | fix}}</div>
                  <small><strong>{{"PERKS::É possível definir o mesmo valor de frete para países diferentes!" | fix}}</strong></small>
                </div>
                <multiselect v-model="countriesSelecteds" :placeholder="$f('MULTISELECT::Pesquise um país')" label="country_name" track-by="id" :options="countries" :multiple="true" :max-height="210" :hideSelected="true" :selectLabel="$f('MULTISELECT::Clique para selecionar')" :selectedLabel="$f('MULTISELECT::Selecionado')" :close-on-select="false">
                  <template slot="noResult">
                    <span><strong>{{"MULTISELECT::Sua pesquisa não encontrou nenhum país, tente novamente" | fix}}</strong></span>
                  </template>
                  <template slot="noOptions">
                    <span><strong>{{"MULTISELECT::Nenhum país encontrado, tente recarregar a página ou contate o administrador" | fix}}</strong></span>
                  </template>
                </multiselect>
                <div style="text-align: center">
                  <small><strong>{{"PERKS::Para editar o valor do frete de um país ja adicionado, pesquise-o acima e o insira um novo valor para sobrescrever o antigo!" | fix}}</strong></small>
                </div>
                <md-field>
                  <md-icon>commute</md-icon>
                  <label class="input-label-selected">{{"PERKS::Qual o valor do frete para o(s) país(es) selecionados?" | fix}}</label>
                  <money v-model.number="multipleShippingValue" class="md-input"></money>
                  <span class="md-error">{{"PERKS::Informe o valor do frete em dólares!" | fix}}</span>
                </md-field>
              </div>
              <md-button :disabled="multipleShippingValue <= 0 || countriesSelecteds.length <= 0" class="md-raised md-icon-button" @click="addMultipleShippingPerk(perk.shipping_data)">
                <md-icon style="color: white">add</md-icon>
              </md-button>

            </div>

          </div>
        </div>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button class="md-gray md-raised" @click="resetPerk()">{{"COMMON::Fechar" | fix}}</md-button>
        <md-button class="md-primary md-raised" :disabled="parentCall && parentCall.loadingState()" @click="uploadNewPerk()">{{"COMMON::Adicionar" | fix}}</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>

  <div>
    <md-dialog :md-active.sync="perkEditDialog">
      <md-dialog-title>{{"PERKS::Editar Perk" | fix}}</md-dialog-title>
      <md-dialog-content>
        <div class="md-layout md-gutter">
          <div class="md-layout-item md-small-size-100">
            <img :src="base64FilePerkEdit || $url + perkEdit.cover_url" class="imagePerk /">
            <input type="file"  style="display: none" id="edit-input-file-perk" @change="pickImgPerkEdit($event)" accept="image/*">
            <div v-if="!base64FilePerkEdit">
              <md-button @click="clickOnFileInputPerkEdit()" class="md-raised md-primary">
                {{"PERKS::Adicionar uma Foto" | fix}} <md-icon>add_a_photo</md-icon>
              </md-button>
            </div>
            <div v-if="base64FilePerkEdit">
              <md-button @click="clickOnFileInputPerkEdit()" class="md-raised md-primary">
                {{"PERKS::Alterar essa foto" | fix}} <md-icon>add_a_photo</md-icon>
              </md-button>
            </div>
            <div v-if="$v.perk.image.$invalid && $v.perk.image.$dirty" style="color: #ff1744;">{{"PERKS::Insira uma imagem para o perk" | fix}}</div>
            <md-field :class="{'md-invalid': $v.perkEdit.description.$invalid && $v.perkEdit.description.$dirty}">
              <md-icon>description</md-icon>
              <label>{{"PERKS::Qual a descrição do seu perk?" | fix}}</label>
              <md-textarea v-model="perkEdit.description" required md></md-textarea>
              <span class="md-error">{{"PERKS::Informe a descrição!" | fix}}</span>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100">
            <md-field :class="{'md-invalid': $v.perkEdit.name.$invalid && $v.perkEdit.name.$dirty}">
              <md-icon>title</md-icon>
              <label>{{"PERKS::Qual o nome da sua recompensa?" |fix}}</label>
              <md-input v-model="perkEdit.name" required></md-input>
              <span class="md-error">{{"PERKS::Informe o titulo da sua recompensa" | fix}}</span>
            </md-field>
            <md-field :class="{'md-invalid': $v.perkEdit.price.$invalid && $v.perkEdit.price.$dirty}" class="md-focused money-input">
              <md-icon>attach_money</md-icon>
              <label>{{"PERKS::Qual o valor do seu perk?" | fix}}</label>
              <money class="md-input" v-model.number="perkEdit.price" required></money>
              <span class="md-error">{{"PERKS::Informe o valor" | fix}}</span>
              <span class="md-helper-text">{{"PERKS::Insira o valor mínimo a ser doado em dólares para receber o perk" | fix}}</span>
            </md-field>
            <md-field :class="{'md-invalid': $v.perkEdit.stock.$invalid && $v.perkEdit.stock.$dirty}">
              <md-icon>store</md-icon>
              <label>{{"PERKS::Qual o estoque do seu perk?" | fix}}</label>
              <md-input v-mask="'######'" v-model="perkEdit.stock" required></md-input>
              <span class="md-error">{{"PERKS::Informe o estoque" | fix}}</span>
              <span class="md-helper-text">{{"PERKS::Informe quantas pessoas devem podem resgatar esse prêmio" | fix}}</span>
            </md-field>
            <md-field :class="{'md-invalid': $v.perkEdit.discount.$invalid && $v.perkEdit.discount.$dirty}">
              <md-icon>money_off</md-icon>
              <label>
                {{"PERKS::Há um valor de desconto?" | fix}}
              </label>
              <span class="md-helper-text">{{"PERKS::Este valor é uma porcentagem de desconto para o valor de doação do seu perk" | fix}}</span>
              <md-input v-mask="'###'" v-model.number="perkEdit.discount"></md-input>
              <span class="md-error ">{{"PERKS::Informe uma porcentagem válida!" | fix}}</span>

            </md-field>
          </div>
        </div>
        <input type="checkbox" id="id-name--1" name="set-name" class="switch-input" @change="mudou()" :checked="perkEdit.haveFrete">
        <label for="id-name--1" class="switch-label">{{"PERKS::Seu produto será enviado pelos correios?" | fix}}</label>
        
        <div v-show="perkEdit.haveFrete">
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-datepicker class="datepicker-correct-icon" :class="{'md-invalid': $v.perkEdit.shipping_date.$invalid}" md-immediately v-model="perkEdit.shipping_date" required>
                <label>{{"PERKS::Informe a data estimada de entrega da sua recompensa" | fix}}</label>
                <span class="md-helper-text">{{"PERKS::O usuário será informado que receberá o prêmio aproximadamente nessa data" | fix}}</span>
              </md-datepicker>
            </div>
          </div>
          <div>
            <b>{{"PERKS::Opções de envio:" | fix}}</b>
          </div>
          <div>
            <md-radio v-model="perkEdit.shipping_worldwide" value="only_country">{{"PERKS::Meu produto será enviado apenas para o país" | fix}}</md-radio>
            <md-radio v-model="perkEdit.shipping_worldwide" value="world_wide">{{"PERKS::Meu produto será enviado para diversos países" | fix}}</md-radio>
          </div>
          <div v-if="perkEdit.shipping_worldwide == 'only_country'" class="md-layout-item md-small-size-100">
            <md-field :class="{'md-invalid': $v.perkEdit.shipping_price.$invalid}" style="margin-top: 1rem;">
              <md-icon>commute</md-icon>
              <label>{{"PERKS::Qual o valor do frete?" | fix}}</label>
              <md-input v-model.number="perkEdit.shipping_price" required></md-input>
              <span class="md-error">{{"PERKS::Informe o valor do frete em dólares!" | fix}}</span>
            </md-field>
          </div>
          <div v-else-if="perkEdit.shipping_worldwide == 'world_wide'" class="md-layout-item md-small-size-100">
            <h4>{{"PERKS::Lista de frete:" | fix}} <span v-if="perkEdit.shipping_data.length == 0"> {{"PERKS::Vazia!" | fix}}</span> </h4>
            <div class="shipping-list">
              <div v-for="(shipping, index) in perkEdit.shipping_data" :key="index" class="shipping-added" @click="removeShippingPerk(index, perkEdit.shipping_data)">
                <div class="shipping-added-text">
                  {{"PERKS::Remover" | fix}}
                </div>
                <div>
                  <md-icon>commute</md-icon>
                  {{shipping.country_name}} - {{shipping.price | currency}}
                </div>
              </div>
            </div>

            <div class="multiple-shipping-container">
              <div style="display: flex; flex-direction: column; width:90%;">
                <div style="text-align: center; margin: 1rem; 0">
                  <div>{{"PERKS::Escolha os países que você deseja entregar sua recompensa e seus respectivos valores de frete" | fix}}</div>
                  <small><strong>{{"PERKS::É possível definir o mesmo valor de frete para países diferentes!" | fix}}</strong></small>
                </div>
                <multiselect v-model="countriesSelecteds" :placeholder="$f('MULTISELECT::Pesquise um país')" label="country_name" track-by="id" :options="countries" :multiple="true" :max-height="210" :hideSelected="true" :selectLabel="$f('MULTISELECT::Clique para selecionar')" :selectedLabel="$f('MULTISELECT::Selecionado')" :close-on-select="false">
                  <template slot="noResult">
                    <span><strong>{{"MULTISELECT::Sua pesquisa não encontrou nenhum país, tente novamente" | fix}}</strong></span>
                  </template>
                  <template slot="noOptions">
                    <span><strong>{{"MULTISELECT::Nenhum país encontrado, tente recarregar a página ou contate o administrador" | fix}}</strong></span>
                  </template>
                </multiselect>
                <div style="text-align: center">
                  <small><strong>{{"PERKS::Para editar o valor do frete de um país ja adicionado, pesquise-o acima e o insira um novo valor para sobrescrever o antigo!" | fix}}</strong></small>
                </div>
                <md-field>
                  <md-icon>commute</md-icon>
                  <label class="input-label-selected">{{"PERKS::Qual o valor do frete para o(s) país(es) selecionados?" | fix}}</label>
                  <money class="md-input" v-model.number="multipleShippingValue"></money>
                  <span class="md-error">{{"PERKS::Informe o valor do frete em dólares!" | fix}}</span>
                </md-field>
              </div>
              <md-button :disabled="multipleShippingValue <= 0 || countriesSelecteds.length <= 0" class="md-raised md-icon-button" @click="addMultipleShippingPerk(perkEdit.shipping_data)">
                <md-icon style="color: white">add</md-icon>
              </md-button>

            </div>

          </div>
        </div>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button class="md-acent md-raised close-btn" @click="resetEditPerk()">{{"COMMON::Fechar" | fix}}</md-button>
        <md-button class="md-primary md-raised" :disabled="parentCall && parentCall.loadingState()" @click="editPerk()">{{"COMMON::Salvar" | fix}}</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
  <md-dialog-confirm class="delete-dialog" :md-active.sync="showDeleteConfirmation" :md-title="$f('PERKS::Tem certeza que deseja deletar este perk?')" :md-content="$f('PERKS::Ao clicar em \'OK\', não será possível recuperá-lo.')" :md-confirm-text="$f('COMMON::Ok')" :md-cancel-text="$f('COMMON::Fechar')"
    @md-cancel="showDeleteConfirmation = false" @md-confirm="deletePerk()" />
</main>
</template>

<script>
import {
  mapState
} from 'vuex';
import {
  required
} from "vuelidate/lib/validators";
import CardItems from '@/components/CardItems'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Multiselect from 'vue-multiselect'

export default {
  components: {
    Multiselect,
    CardItems
  },
  data() {
    return {
      alertError: false,
    	alertErrorMsg: null,
      countries: [],
      countriesSelecteds: [],
      multipleShippingValue: 0,
      showDeleteConfirmation: false,
      perkIdToDelete: null,
      parentCall: null,
      base64FilePerk: false,
      base64FilePerkEdit: false,
      perkDialog: false,
      perkEditDialog: false,
      perkEdit: {
        name: "",
        discount: 0,
        stock: "",
        newImage: null,
        cover_url: null,
        price: null,
        shipping_price: 0.0,
        shipping_date: null,
        description: "",
        haveFrete: false,
        shipping_worldwide: "world_wide",
        shipping_data: []
      },
      allow: true,
      perk: {
        name: "",
        stock: "",
        newImage: null,
        discount: 0,
        price: null,
        shipping_price: 0.0,
        shipping_date: null,
        description: "",
        haveFrete: false,
        shipping_worldwide: "world_wide",
        shipping_data: []
      },
      perkList: [],
    };
  },
  validations: {
    perkEdit: {
      name: {
        required
      },
      discount: {
        validPercent: function() {
          if(this.perkEdit.discount > 100 || this.perkEdit.discount < 0)
            return false;
          return true;
        }
      },
      cover_url: {
        required
      },
      stock: {
        required
      },
      price: {
        required
      },
      description: {
        required
      },
      shipping_price: {
        checkFrete: function() {
          if (this.perkEdit.haveFrete && (!this.perkEdit.shipping_price || this.perkEdit.shipping_price <= 0)) {
            return false
          }
          return true
        },
      },
      shipping_date: {
        checkDate: function() {
          if (this.perkEdit.haveFrete && !this.perkEdit.shipping_date) {
            return false
          }
          if(this.perkEdit.haveFrete && this.perkEdit.shipping_date < Date.now())
            return false

          return true
        },
      }
    },
    perk: {
      name: {
        required
      },
      discount: {
        validPercent: function() {
          if(this.perk.discount > 100 || this.perk.discount < 0)
            return false;
          return true;
        }
      },
      stock: {
        required
      },
      image: {
        required
      },
      price: {
        required
      },
      description: {
        required
      },
      shipping_price: {
        checkFrete: function() {
          if (this.perk.haveFrete && this.perk.shipping_worldwide == "only_country" && (!this.perk.shipping_price || this.perk.shipping_price <= 0)) {
            return false
          }
          return true
        }
      },
      shipping_date: {
        checkDate: function() {
          if (this.perk.haveFrete && !this.perk.shipping_date) {
            return false
          }
          // if(this.perk.shipping_date < Date.now())
          //   return false
          return true
        }
      }
    },
  },
  computed: {
    ...mapState(["user"]),
  },
  methods: {
    addMultipleShippingPerk(arr) {
      //verifica se tem um frete digitado
      this.countriesSelecteds.forEach((elem) => {
        let elemPosition = this.checkPerkshipping_data(elem, arr)
        if(!elemPosition)
          arr.push({...elem, price: this.multipleShippingValue})
        else
          this.$set(arr, elemPosition, {...elem, price: this.multipleShippingValue})
      })
      this.countriesSelecteds = []
      this.multipleShippingValue = 0
    },
    checkPerkshipping_data(objToCheck, arr) {
      for (const key in arr) {
        const element = arr[key];
        if(element.id == objToCheck.id)
          return key
      }
      return false
    },
    removeShippingPerk(index, arr) {
      arr.splice(index, 1)
    },
    //  addMultipleShippingPerkEdit() {
    //    //verifica se tem um frete digitado
    //    console.log(this.countriesSelecteds)
    //   this.countriesSelecteds.forEach((elem) => {
    //     let elemPosition = this.checkPerkEditshipping_data(elem)
    //     console.log("pos", this.perkEdit.shipping_data)
    //     if(!elemPosition)
    //       this.perkEdit.shipping_data.push({...elem, price: this.multipleShippingValue})
    //     else
    //       this.$set(this.perkEdit.shipping_data, elemPosition, {...elem, price: this.multipleShippingValue})
    //   })
    //   this.countriesSelecteds = []
    //   this.multipleShippingValue = 0
    // },
    // checkPerkEditshipping_data(objToCheck) {
    //   for (const key in this.perkEdit.shipping_data) {
    //     const element = this.perkEdit.shipping_data[key];
    //     if(element.id == objToCheck.id)
    //       return key
    //   }
    //   return false
    // },
    // removeShippingPerkEdit(index) {
    //   this.perkEdit.shipping_data.splice(index, 1)
    // },
    mudou() {
      this.perkEdit.haveFrete = !this.perkEdit.haveFrete
      if (!this.perkEdit.haveFrete) {
        this.perkEdit.shipping_price = 0
        this.perkEdit.shipping_date = null

      }

    },
    showModalEditPerk(perkToEdit) {
      this.perkEditDialog = true;
      if (perkToEdit.shipping_date == "0000-00-00" && perkToEdit.shipping_price == 0) {
        this.perkEdit = {
          ...perkToEdit,
          haveFrete: false,
          shipping_date: null,
          // shipping_data: [] //comentar essas duas linhas após o back ter sido feito!!!!!!
        };
      } else {
        this.perkEdit = {
          ...perkToEdit,
          haveFrete: true,
          // shipping_data: [] //comentar essas duas linhas após o back ter sido feito!!!!!!
        };
      }
      if (this.perkEdit.shipping_price > 0) {
        this.perkEdit.haveFrete = true;
      }
    },
    loadPerk() {
      global
        .$get(
          "/Content/getperk?campaign_id=" + this.$route.params.id, {},
          this.user.token
        )
        .then(res => {
          this.perkList = res.data;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
    },
    uploadNewPerk() {
      this.$v.perk.$touch();
      this.$v.perk.image.$touch();
      if (!this.$v.perk.$invalid && !this.$v.perk.image.$invalid) {
        this.$v.perk.$reset();
        this.perk.campaign_id = this.$route.params.id;
        this.perk.shipping_data = JSON.stringify(this.perk.shipping_data)
        if (this.perk.haveFrete) {
          this.perk.shipping_date = this.perk.shipping_date.toISOString().split('T')[0]
        } else {
          this.perk.shipping_price = 0
        }

        this.perkDialog = false;

        this.parentCall.showLoading();
        console.log(this.perk)
        global
          .$post("/Content/addperk", this.perk, this.user.token)
          .then(response => {
            this.loadPerk();
            this.perk = {};
            // this.imageToUploadPerk = "";
            this.base64FilePerk = "";
				  })
				  .catch(err => {
            let validErr =
              err && err.response && err.response.data && err.response.data.error;
            this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
            this.alertError = true;
          })
          .finally(() => {
            this.parentCall.hideLoading()
          });
      }
    },

    editPerk() {
      this.$v.perkEdit.$touch();
      if (!this.$v.perkEdit.$invalid) {
        this.$v.perkEdit.$reset();
        this.perkEdit.campaign_id = this.$route.params.id;
        this.perkEditDialog = false;
        this.perkEdit.shipping_data = JSON.stringify(this.perkEdit.shipping_data)
        this.parentCall.showLoading()
        console.log(this.perkEdit)
        global
          .$post("/Content/editperk", this.perkEdit, this.user.token)
          .then(response => {
            this.loadPerk();
            this.base64FilePerkEdit = null;
            this.perkEdit = {};
          })
          .catch(err => {
            let validErr =
              err && err.response && err.response.data && err.response.data.error;
            this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
            this.alertError = true;
          })
          .finally(() => {
            this.parentCall.hideLoading();

          });
      } else {
        console.log('ndeu')
      }
    },
    openDeleteConfirmation(id) {
      this.perkIdToDelete = id
      this.showDeleteConfirmation = true
    },
    deletePerk() {
      this.parentCall.showLoading();
      global.$post("/Content/deleteperk", {
          id: this.perkIdToDelete
        }, this.user.token)
        .then(res => {
          this.loadPerk();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
        .finally(() => {
          this.parentCall.hideLoading();
        });
    },
    resetEditPerk() {
      this.perkEditDialog = false;
      this.base64FilePerkEdit = null
      this.perkEdit = {};
      this.$v.perkEdit.$reset();
    },
    resetPerk() {
      this.perkDialog = false;
      this.perk.image = null;
      this.perk.stock = null;
      this.perk.price = null;
      this.perk.name = null;
      this.$v.perk.$reset();
    },
    clickOnFileInputPerk() {
      document.getElementById("input-file-perk").click();
    },
    clickOnFileInputPerkEdit() {
      document.getElementById("edit-input-file-perk").click();
    },
    pickImgPerk(evt) {
      let reader = new FileReader();
      this.perk.image = evt.target.files[0];
      reader.onload = e => {
        this.base64FilePerk = e.target.result;
      };
      reader.readAsDataURL(evt.target.files[0]);
    },
    pickImgPerkEdit(evt) {
      let reader = new FileReader();
      this.perkEdit.newImage = evt.target.files[0];
      reader.onload = e => {
        this.base64FilePerkEdit = e.target.result;
      };
      reader.readAsDataURL(evt.target.files[0]);
    },
    loadCountries() {
      global.$get("/Donation/countries")
      .then(res => {
        this.countries = res.data;
      })
      .catch(err => {
        let validErr =
          err && err.response && err.response.data && err.response.data.error;
        this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
        this.alertError = true;
      })
    }
  },
  mounted() {
    this.loadPerk()
    this.loadCountries()
    this.parentCall = this.$parent.$parent.$parent
  }
}
</script>

<style lang="scss" >
.shipping-list {
  display: flex;
  flex-wrap: wrap;
  .shipping-added {
    display: flex;
    align-items: center;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: .25rem;
    padding: .25rem;
    position: relative;
    .shipping-added-text {
      text-shadow: 2px 1px black;
      font-weight: 500;
      color: rgb(255, 255, 255);
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    &:not(:last-child) {
      margin-right: .5rem;
    }
    &:hover {
      background-color: rgba(105,105,105, 1);
      cursor: pointer;
      .shipping-added-text {
        display: block;
      }

    }
  }
}
.multiple-shipping-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  .input-label-selected {
    pointer-events: auto;
    top: 0;
    opacity: 1;
    font-size: 12px;
  }
}
.tooltip-perk {
    background-color: #707070 !important;
    color: white;
    font-size: 0.85rem;
}
.helper-icon {
    // font-size: 1.5rem !important;
    &:hover {
        cursor: pointer;
    }
}
.close-btn {
    background-color: #707070 !important;
}
.overlap-btn {
    position: absolute;
    right: 0;
}
.delete-dialog {
    .md-dialog {
        width: 30%;
    }
}
.md-dialog {
    width: 70%;
}
.switch-input {
    display: none;
}
.switch-label {
    position: relative;
    display: inline-block;
    min-width: 112px;
    cursor: pointer;
    font-weight: 500;
    text-align: left;
    margin: 16px;
    padding: 16px 0 16px 44px;
}
.switch-label:after,
.switch-label:before {
    content: "";
    position: absolute;
    margin: 0;
    outline: 0;
    top: 50%;
    -ms-transform: translate(0, -50%);
    -webkit-transform: translate(0, -50%);
    transform: translate(0, -50%);
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.imagePerk {
 max-height:160px;
}
.switch-label:before {
    left: 1px;
    width: 34px;
    height: 14px;
    background-color: #9e9e9e;
    border-radius: 8px;
}
.switch-label:after {
    left: 0;
    width: 20px;
    height: 20px;
    background-color: #fafafa;
    border-radius: 50%;
    box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14), 0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
}
.switch-label .toggle--on {
    display: none;
}
.switch-label .toggle--off {
    display: inline-block;
}
.switch-input:checked + .switch-label:before {
    background-color: rgba(255,82,82,0.38);
}
.switch-input:checked + .switch-label:after {
    background-color: #ff5252;
    -ms-transform: translate(80%, -50%);
    -webkit-transform: translate(80%, -50%);
    transform: translate(80%, -50%);
}
.switch-input:checked + .switch-label .toggle--on {
    display: inline-block;
}
.switch-input:checked + .switch-label .toggle--off {
    display: none;
}
.md-empty-state-container > i {
    font-size: 70px!important;
}
.md-empty-state-icon {
    height: 70px!important;
}
</style>
