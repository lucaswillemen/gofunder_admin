<template>
<div class="paymentContribution">
  <main-header></main-header>
  <b-modal id="login-modal" ref="login-modal" :no-close-on-backdrop="validation.isCotaOrPerk" :hide-header="true" :hide-footer="true" centered>
    <div class="container wrap-login center">
      <b-row>
        <b-col lg="12">
          <div class="login">
            <div class="title mtop mbottom">
              <span class="blue" style="font-weight: 500">{{"LOGIN::Você precisa estar logado para receber a sua recompensa!"|fix}}</span>
            </div>
            <div @keyup.enter="login()">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <font-awesome-icon :icon="['fas', 'user']" />
                  </span>
                </div>
                <b-form-input v-model="loginForm.email" type="email" :placeholder="$f('LOGIN::Digite seu e-mail')"></b-form-input>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <font-awesome-icon :icon="['fas', 'lock']" />
                  </span>
                </div>
                <b-form-input type="password" v-model="loginForm.password" :placeholder="$f('LOGIN::Digite sua senha')"></b-form-input>
              </div>

            </div>
            <div class="title mtop mbottom">
              <span>{{"LOGIN::Novo no Portal?"|fix}} <a href="/#/register" class="orange"><b>{{"LOGIN::Cadastre-se"|fix}}</b></a></span>
            </div>
            <div class="btn-border-blue">
              <b-button>
                <font-awesome-icon :icon="['fab', 'facebook']" />{{"LOGIN::Entrar com Facebook"|fix}}</b-button>
            </div>
            <b-button variant="primary" :disabled="!loginForm.email || !loginForm.password" class="float-right" @click="login()">Login</b-button>
          </div>
        </b-col>
      </b-row>
    </div>
  </b-modal>
  <div class="container mt-5 mb-5">
    <b-row>
      <b-col cols="12" md="7" class="wrap-left pageContribution">
        <b-row>
          <b-col>
            <div class="mb-5">
              <small>Você está contribuindo com <span class="blue" style="font-weight: 600;">{{campaign.owner_name}}</span></small>
              <h4>{{campaign.title}}</h4>
            </div>


            <div>
              <div class="userTab" v-if="user.token">
                <h6>
                  Checkout com conta autenticada
                </h6>
                <div class="userImg">
                  <img style="border-radius: 100px;height:75px;width:75px;margin-top:5px" :src="(user && user.img ? $apiEndpoint+user.img : '/static/anonymous-icon.svg')  "> </div>
                <div class="user">
                  <div class="name">{{user.name}}</div>
                  <div class="email">{{user.email}}</div>
                </div>
              </div>
              <h6 v-if="!user.token">
                Checkout como convidado ou <a style="cursor:pointer;" @click="showModalLogin()"><span class="orange">Log-in</span></a>
                <br />
              </h6>

              <div v-if="selectedDonationTitleInfo == 'public'">
                Nome e email que aparecerão na doação:
                <b-row>
                  <b-col cols="12" md="6">
                    <b-input-group prepend="<i class='fa fa-user'></i>">
                      <b-form-input :disabled="validation.processingPayment" type="text" v-model="donator.name" placeholder="Nome do doador"></b-form-input>
                    </b-input-group>
                  </b-col>
                  <b-col cols="12" md="6">
                    <b-input-group prepend="<i class='fa fa-envelope'></i>">
                      <b-form-input :disabled="validation.processingPayment" type="text" v-model="donator.email" placeholder="E-mail doador"></b-form-input>
                    </b-input-group>
                  </b-col>
                </b-row>
              </div>
            </div>
          </b-col>
        </b-row>
        <b-row class="mt-4">
          <b-col lg="6" class="mt-4">
            <div>
              <h6>Exibição da contribuição</h6>
              <small>Escolha um nome para ser exibido publicamente ao lado de sua contribuição na página da campanha.</small>
            </div>
            <b-form-group>
              <b-form-radio-group stacked class="radios radio-block" v-model="selectedDonationTitleInfo">
                <b-form-radio v-if="!validation.forceIdentifyContribution" value="private">
                  Doação anônima
                </b-form-radio>
                <b-form-radio value="public">
                  Doação com meu nome
                </b-form-radio>
              </b-form-radio-group>
            </b-form-group>
          </b-col>
          <b-col lg="6" class="mt-4">
            <div>
              <h6>Método de pagamento</h6>
              <small>Escolha um método de pagamento para ser utilizado na doação da campanha.</small>
            </div>
            <b-form-group>
              <b-form-radio-group stacked class="radios radio-block" v-model="selectedMethodPayment">
                <b-form-radio v-if="campaign.payment_method && campaign.payment_method.includes('bitcoin','dollar_and_bitcoin')" name="some-radios1" value="bitcoin">
                  Bitcoin
                </b-form-radio>
                <b-form-radio v-if="campaign.payment_method && campaign.payment_method.includes('dollar','dollar_and_bitcoin')" name="some-radios2" value="card">
                  Cartão de Crédito
                </b-form-radio>
              </b-form-radio-group>
            </b-form-group>
          </b-col>
        </b-row>
        <div class="mt-5" v-show="selectedMethodPayment =='card'">

          <b-row class="mt-5">
            <b-col cols="12" md="6">
              <!--<h6 v-if="!user.token">Cartão de Crédito</h6>
                <h6 v-if="user.token">Pagar com outro cartão de crédito</h6>!-->
              <div class="card-wrapper"></div>
            </b-col>
            <b-col cols="12" lg="6" class="card-form">
              <h6 class="mb-4">Insira os dados do cartão</h6>
              <b-form-group>
                <b-input-group prepend="<i class='fa fa-user'></i>">
                  <b-form-input id="card-form-name" type="text" placeholder="Nome titular cartão" name="name" v-model="card.name"></b-form-input>
                </b-input-group>
              </b-form-group>
              <b-form-group>
                <b-input-group prepend="<i class='fa fa-credit-card'></i>">
                  <b-form-input id="card-form-number" type="text" placeholder="Número de Cartão de Crédito" name="number" v-model="card.number"></b-form-input>
                </b-input-group>
              </b-form-group>
              <b-row>
                <b-col cols="12" lg="6">
                  <b-form-group>
                    <b-input-group prepend="<i class='fa fa-calendar'></i>">
                      <b-form-input id="card-form-expiry" size="md" type="text" placeholder="01/2019" name="expiry" v-model="card.expiry"></b-form-input>
                    </b-input-group>
                  </b-form-group>
                </b-col>
                <b-col cols="12" lg="6">
                  <b-form-group>
                    <b-input-group prepend="<i class='fa fa-lock'></i>">
                      <b-form-input id="card-form-cvc" size="md" placeholder="XXX" type="text" name="cvc" v-model="card.cvc"></b-form-input>
                    </b-input-group>
                  </b-form-group>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </div>
        <div class="mt-5" v-show="validation.haveShipping">
          <div class="mb-3">
            <h6>Detalhes para entrega</h6>
            <small>Os detalhes da entrega servirão para receber o produto de recompensa após a doação.</small>
          </div>
          <b-row>
            <b-col cols="12" lg="6" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-user'></i>">
                <b-form-input type="text" v-model="delivery.name" placeholder="Nome destinatário"></b-form-input>
              </b-input-group>
            </b-col>
            <b-col cols="12" lg="6" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-phone'></i>">
                <b-form-input type="text" v-model="delivery.phone" placeholder="Telefone para Contato"></b-form-input>
              </b-input-group>
            </b-col>
          </b-row>
          <b-row class="mt-3">
            <b-col cols="12" lg="4" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-flag'></i>">
                <b-form-select v-model="delivery.country" label="label">
                  <option :value="null" disabled>Selecione o País</option>
                  <option v-for="(item, index) in worldCountries" :key="index" v-bind:value="item.id">{{item.country_name}}</option>
                </b-form-select>
              </b-input-group>
            </b-col>
            <b-col cols="12" lg="4" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-map-marked'></i>">
                <b-form-input type="text" v-model="delivery.state" placeholder="Estado"></b-form-input>
              </b-input-group>
            </b-col>
            <b-col cols="12" lg="4" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-city'></i>">
                <b-form-input type="text" v-model="delivery.city" placeholder="Cidade"></b-form-input>
              </b-input-group>
            </b-col>
          </b-row>
          <b-row class="mt-3">
            <b-col cols="12" lg="8" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-font'></i>">
                <b-form-input type="text" v-model="delivery.address" placeholder="Endereço"></b-form-input>
              </b-input-group>
            </b-col>
            <b-col cols="12" lg="4" style="padding-right:2px;padding-left:2px;">
              <b-input-group prepend="<i class='fa fa-list-ol'></i>">
                <b-form-input type="text" v-model="delivery.zipcode" placeholder="Zipcode"></b-form-input>
              </b-input-group>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col v-show="!bitcoinPaymentProcessing && !cardProcessing" cols="12" md="5" class="wrap-right pageContribution">
        <div class="buy-wrap">
          <div class="mt-3">
            <h5 class="mb-2 reward-info-title">
              Valor de contribuição
            </h5>

            <b-input-group size="sm" prepend="$" class="mb-1">
              <money class="form-control" v-model="donator.value" placeholder="Valor para Doação" v-bind="moneyConfig" :min="validation.minDonationValue"></money>
            </b-input-group>

            <div class="subtitle">

            </div>

            <div v-if="validation.minDonationValue > 0" class="subtitle">Doando o valor mínimo de {{validation.minDonationValue | currency}} você terá direito a receber a recompensa
            </div>

          </div>


          <!-- PERK -->
          <div v-if="campaign.perk != null">
            <div style="margin-top:50px;">
              <h5 class="reward-info-title">Dados da Recompensa
              </h5>
              <div>
                <div class="reward-title" style="font-size:15px;font-weight:500">{{campaign.perk.name}}
                </div>
                <div class="reward-description" style="font-size:13px;">{{campaign.perk.description}}
                </div>
              </div>

              <div v-if="campaign.perk.shipping_price > 0">
                <div class="mb-2 reward-info-title" style="margin-top:50px;font-size:15px;">
                  Dados da Entrega
                </div>
                <div style="font-size:12px;">
                  Data estimada de entrega <b>{{campaign.perk.shipping_date | formatShippingDate}}</b>
                </div>
                <div style="font-size:12px;">
                  Preço do frete <b>{{campaign.perk.shipping_price | currency}}</b>
                </div>

              </div>
              <div class="mt-2 no-shipping" v-else>
                Esta recompensa não possui entrega!
              </div>
            </div>
          </div>

          <!-- COTAS -->
          <div v-if="campaign.cota != null">
            <div style="margin-top:50px;">
              <h5 class="reward-info-title">Doando esse valor você irá ter direito a uma cota
              </h5>
              <div>
                <div class="reward-description" style="font-size:13px;">Isso significa que {{campaign.cota.percent}}% do valor de todas vendas desse produto serão divididos entre {{campaign.cota.stock}} pessoas que fizeram a doação mínima
                </div>
                <br>
                <div class="reward-description" style="font-size:13px;">Tempo de validade da cota: <b>{{campaign.cota.expiry}}</b></div>

              </div>
            </div>
          </div>


          <hr class="mt-3 mb-3">
          <b-row v-show="validation.haveShipping">
            <b-col cols="7">
              <div>
                <span v-if="campaign.perk != null" style="font-size:14px;font-weight:450">Total: {{(Number(donator.value) + Number(campaign.perk.shipping_price)) | currency}}</span>
                <span v-if="campaign.cota != null" style="font-size:14px;font-weight:450">Total: {{Number(donator.value) | currency}}</span>
              </div>
            </b-col>
          </b-row>
          <b-row class="mt-5" v-show="!validation.haveShipping">

            <b-col cols="8">
              <h5>VALOR</h5>
            </b-col>
            <b-col cols="4">
              <h5>Total {{donator.value | currency}}</h5>
            </b-col>
          </b-row>
          <b-row class="ml-1 mt-4">
            <small style="font-size:10px;">
              O valor real cobrado pelo emissor do seu cartão pode diferir da nossa estimativa com base na taxa de câmbio e nas taxas aplicáveis.
              Ao clicar em Enviar pagamento, você também concorda com nossos <a class="orange" href="/#//terms">Termos de Uso e Privacidade</a>
            </small>
          </b-row>
          <b-row class="mt-5">
            <div class="btn-noborder-blue ml-3">
              <b-button @click="payment()">REALIZAR PAGAMENTO</b-button>
            </div>
          </b-row>
        </div>
      </b-col>
      <b-col v-show="bitcoinPaymentProcessing" cols="12" md="5" class="wrap-right pageContribution">
        <b-row class="pay-info-wrap">
          <b-col cols="12" v-show="bitcoinPayedProcessed">
            <div style="font-size:15px;">
              <h3>Sucesso <span class="text-success"><i class="fas fa-check"></i></span></h3><br>
              Seu pagamento em Bitcoin foi recebido<br>
              Para ver seu comprovante <a target="_blank" :href="'https://www.blockchain.com/pt/btc/address/'+bitcoinPaymentInfo.address">clique aqui</a><br><br>
              Obrigado pela sua doação
            </div>
          </b-col>
          <b-col cols="8" v-show="!bitcoinPayedProcessed">
            <div class="header">
              <div class="title">
                <span>Pague com Bitcoin</span>

              </div>
              <div class="subtitle">
                <span>Por favor, envie <span class="text-warning" @click="copyToClipboard(bitcoinPaymentInfo.amount)" style="cursor:pointer">Ƀ {{bitcoinPaymentInfo.amount}}</span> para:</span>
              </div>
            </div>
            <b-input-group class="wallet-input">
              <b-form-input id="wallet" type="text" v-model="bitcoinPaymentInfo.address"></b-form-input>
              <b-input-group-append>
                <div class="clipboard" @click="copyToClipboard(bitcoinPaymentInfo.address)">
                  <font-awesome-icon :icon="['far', 'copy']" />
                </div>
              </b-input-group-append>
            </b-input-group>

            <div class="mt-3 waiting-payment">
              <span><b>{{ bitcoinPaymentInfo.timeout | formatDate}}</b> Restante Esperando pagamento</span>
            </div>
          </b-col>
          <b-col cols="4" v-show="!bitcoinPayedProcessed">
            <div class="qrcode">
              <div class="qrcode-wrap">
                <qrcode-vue :value='bitcoinPaymentInfo.address' :size="100" level="H"></qrcode-vue>
              </div>
              <div class="price">
                <div class="price-wrap">
                  <span class="bit">1 BTC</span>
                  <font-awesome-icon :icon="['fas', 'exchange-alt']" />
                  <span class="qtd">{{Math.round(donator.value/bitcoinPaymentInfo.amount) | currency}} </span>
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-col>
      <b-col v-show="cardProcessing" cols="12" md="5" class="wrap-right pageContribution">
        <b-row class="pay-info-wrap">
          <div class="d-flex justify-content-center w-100">
            <clip-loader :loading="!cardPayed && !cardError" size="60" color="#1a2953"></clip-loader>
          </div>
          <b-col cols="12" v-show="cardPayed">
            <div style="font-size:15px;">
              <h3>Sucesso <span class="text-success"><i class="fas fa-check"></i></span></h3><br>
              Seu pagamento com cartão de crédito foi recebido<br><br>
              <b>Obrigado pela sua doação</b>
            </div>
          </b-col>
          <b-col cols="12" v-show="cardError">
            <div style="font-size:15px;">
              <h3>Ops <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span></h3><br>
              Seu pagamento com cartão de crédito foi recusado<br><br>
              <a @click="retryCardPay()" style="cursor:pointer;color:blue;">Clique aqui para tentar novamente</a>
            </div>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </div>
  <main-footer></main-footer>
</div>
</template>

<script>
import QrcodeVue from 'qrcode.vue'
import moment from 'moment'
import { ClipLoader } from 'vue-spinner/dist/vue-spinner.min.js'

const Card = require('card')

import {
  mapActions,
  mapState,
  mapGetters
} from 'vuex'

export default {
  computed: {
    ...mapState(['user'])
  },
  components: {
    QrcodeVue,
    ClipLoader

  },
  filters: {
    formatDate(value) {
      return value ? moment("2015-01-01").startOf('day').seconds(value).format('H:mm:ss') : false
    },
    formatShippingDate(value) {
      return moment(value).format('DD/MM/YYYY')

    }
  },
  mounted() {
    this.mountCardComponent()
    this.loadCountries()
    this.loadCampaignData()
    if (this.user.token) {
      this.donator.email = this.user.email
      this.donator.name = this.user.name
    }
  },
  beforeDestroy() {
    if (this.intervalRecheckBitcoinPayment) {
      clearInterval(this.intervalRecheckBitcoinPayment)
    }
  },
  data() {
    return {
      moneyConfig: {
				decimal: ",",
				thousands: ".",
				prefix: "$ ",
				suffix: "",
				precision: 2,
				masked: false
			},
      loginForm: {
        email: '',
        password: '',
      },
      validation: {
        isCotaOrPerk: false,
        minDonationValue: 0.0,
        processingPayment: false,
        forceIdentifyContribution: false,
        haveShipping: false
      },
      cardProcessing: false,
      cardError: false,
      cardPayed: false,
      intervalRecheckBitcoinPayment: null,
      selectedMethodPayment: 'card',
      selectedDonationTitleInfo: 'public',
      bitcoinPaymentProcessing: false,
      bitcoinPayedProcessed: false,
      bitcoinPaymentInfo: {
        amount: 0.0,
        txn_id: '',
        address: '',
        timeout: 0
      },
      campaign: {},
      card: {
        name: null,
        number: null,
        expiry: null,
        cvc: null
      },
      donator: {
        name: '',
        email: '',
        value: 50.00
      },
      delivery: {
        name: '',
        phone: '',
        zipcode: '',
        address: '',
        city: '',
        state: '',
        country: null
      },
      perkItems: [],
      perkInfo: [],
      itemsSelected: {},
      donationTitleInfo: [{
          text: 'Nome Completo',
          value: 'public'
        },
        {
          text: 'Anônimo',
          value: 'anonymous'
        }
      ],
      worldCountries: []
    }
  },
  watch: {
    selectedDonationTitleInfo: function(newVal) {
      if(newVal == 'private') 
        this.donator.name = "anonymous"
      else 
        this.donator.name = this.user.name
      
    }
  },
  methods: {
    ...mapActions('user', ['userSet']),
    showModalLogin() {
      this.$refs['login-modal'].show()
    },
    copyToClipboard(value) {
      this.$copyText(value).then((e) => {
        this.$awn.success("COPIADO")
      }, (e) => {})
    },
    payment() {
      // Validar entradas aqui
      // Se alguma tiver errado dá um return e alerta o usuário
      if (this.validation.haveShipping) {
        if (!this.delivery.name) return this.$awn.alert("Por favor digite um nome no campo entrega!")
        if (!this.delivery.phone) return this.$awn.alert("Por favor digite um telefone no campo de entrega")
        if (!this.delivery.zipcode) return this.$awn.alert("Por favor digite um código postal no campo de entrega")
        if (!this.delivery.address) return this.$awn.alert("Por favor digite um endereço no campo de entrega")
        if (!this.delivery.city) return this.$awn.alert("Por favor digite uma cidade no campo de entrega")
        if (!this.delivery.state) return this.$awn.alert("Por favor digite um estado no campo de entrega")
        if (!this.delivery.country) return this.$awn.alert("Por favor escolha um pais no campo de entrega")
      }
      // Validar doação se tiver errado dá return e acaba
      if (!this.donator.value || this.donator.value < 5) return this.$awn.alert("Por favor digite um valor para doação!")
      if (this.selectedMethodPayment == 'card') {
        // Validar cartao se tiver algum dado não preenchido ele dá return e alerta o usuário
        if (!this.card.name) return this.$awn.alert("Por favor digite o nome do titular do cartão")
        if (!this.card.number) return this.$awn.alert("Por favor digite o número do cartão corretamente!")
        if (!this.card.expiry) return this.$awn.alert("Por favor digite a data de expiração da cartão!")
        if (!this.card.cvc) return this.$awn.alert("Por favor digite o código segurança do cartão")

        // estando tudo certo chama função de fazer pagamento
        return this.getCardPayment()
      }

      if (this.selectedMethodPayment == 'bitcoin') {
        // aqui selecionando bitcoin e estando tudo certo ele chama função de pagar com Bitcoin
        return this.getBitcoinPayment()
      }

      this.$awn.alert("Selecione um método pagamento!")
    },
    login() {
      global.$post("/Auth/login", this.loginForm)
        .then(response => {
          this.$refs['login-modal'].hide()
          this.$awn.success("Bem vindo " + response.data.name)
          this.userSet(response.data)
          this.donator.email = this.user.email
          this.donator.name = this.user.name
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          this.$awn.alert(validErr ? err.response.data.error : "INVALID_ERROR")
        })
    },
    /*
     * Parte responsável pelo pagamento com Bitcoin
     * Após pagar ele fica requisitando para verificar se o pagamento foi aprovado na blockchain
     */
    getDonationFormBitcoin() {
      return {
        perk_id: this.$route.params.perk_id ? this.$route.params.perk_id : 0,
        cota_id: this.$route.params.cota_id ? this.$route.params.cota_id : 0,
        campaign_id: this.$route.params.campaign_id,
        perk_shipping_address: JSON.stringify(this.delivery),
        perk_shipping_country: this.delivery.country,
        payment_type: 'bitcoin',
        usd: this.donator.value,
        name: this.donator.name,
        email: this.donator.email
      }
    },
    recheckBitcoinPayment() {
      var self = this
      this.intervalRecheckBitcoinPayment = setInterval((self) => {
        if (self.bitcoinPaymentInfo.timeout > 0) {
          self.bitcoinPaymentInfo.timeout = self.bitcoinPaymentInfo.timeout - 1
          if (!(self.bitcoinPaymentInfo.timeout % 3)) {
            global.$post("/Donation/checkState", {
                invoice: self.bitcoinPaymentInfo.server_code
              })
              .then(response => {
                self.bitcoinPayedProcessed = true
                self.bitcoinPaymentProcessing = true
              })
          }
        }
      }, 1000, this)
    },
    getBitcoinPayment() {
      this.$awn.asyncBlock(global.$post("/Donation/makeBtcDonation", this.getDonationFormBitcoin(), this.user.token))
        .then(response => {
          if (response.data.error !== "ok") {
            return this.$awn.alert(response.data.error)
          }
          this.bitcoinPaymentProcessing = true
          this.bitcoinPaymentInfo = response.data.result
          this.bitcoinPaymentInfo.server_code = response.data.server_code
          this.recheckBitcoinPayment()
        })
        .catch(err => {
          return this.$awn.alert("Não foi possível processar pagamento!")
        })
    },
    /*
     * Parte responsável pelo sistema de pagamentos em cartão
     * Precisa ser feita duas requisições. Uma pra gerar um token seguro pro cartão e outra para fazer o pagamento
     */
    mountCardComponent() {
      let card = new Card({
        form: '.card-form',
        container: '.card-wrapper',
        placeholders: {
          number: '0000 0000 0000 0000',
          name: "Nome titular",
          expiry: '00/00',
          cvc: '000'
        }
      })
    },
    getCardFormInfo() {
      return {
        name: this.card.name,
        number: this.card.number,
        exp_month: this.card.expiry ? this.card.expiry.replace(/ /g, '').split('/')[0] : null,
        exp_year: this.card.expiry ? this.card.expiry.replace(/ /g, '').split('/')[1] : null,
        cvc: this.card.cvc
      }
    },
    getDonationFormCard(cardToken) {
      return {
        perk_id: this.$route.params.perk_id ? this.$route.params.perk_id : 0,
        cota_id: this.$route.params.cota_id ? this.$route.params.cota_id : 0,
        campaign_id: this.$route.params.campaign_id,
        perk_shipping_address: JSON.stringify(this.delivery),
        perk_shipping_country: this.delivery.country,
        payment_type: 'dollar',
        card_token: cardToken,
        usd: this.donator.value,
        name: this.donator.name,
        email: this.donator.email
      }
    },
    getCardPayment() {
      this.cardProcessing = true
      global.$post("/Donation/createCardToken", this.getCardFormInfo())
        .then(response => {
          global.$post("/Donation/makeCardDonation", this.getDonationFormCard(response.data.id), this.user.token)
            .then(data => {
              this.showSucceffulPaymentCard("Muito obrigado por sua doação!")
            })
            .catch(err => {
              /*
              * Se tiver algum erro como falta de estoque ou outras informações do backend vai retornar aqui nesse catch
              * Nesse caso precisa fazer o tratamento futuramente dessas informações que vem de lá
              * Ex:
              * INVALID_MIN_DONATION (é verificada no front.. só se ele tentar burlar no inspecionar elemento)
              * INVALID_COTA_STOCK|INVALID_PERK_STOCK: Se não tiver cota disponível... aí pode acontecer de estar faltnado 1 cota e outro usuário comprar antes que ele
              * INVALID_COUNTRY_SHIPPING se ele escolher um pais que não é o mesmo pais que o perk entrega
              */
              this.showTryagainCard('O cartão digitado é inválido')
            })
        })
        .catch(err => {
          this.showTryagainCard('O cartão digitado é inválido')
        })
    },
    retryCardPay() {
      this.cardProcessing = false
      this.cardPayed = false
      this.cardError = false
    },
    showSucceffulPaymentCard(msg) {
      this.$awn.success(msg)
      this.cardError = false
      this.cardPayed = true
    },
    showTryagainCard(msg) {
      this.$awn.alert(msg)
      this.cardError = true
      this.cardPayed = false
    },
    /*
     * Parte responsável por carregar os dados na tela
     * Aqui é geralmente chamado após mounted
     */
    loadCountries() {
      global.$post("/Donation/countries", {}, this.user.token)
        .then(response => {
          this.worldCountries = response.data
        })
        .catch(err => {})
    },
    loadCampaignData() {
      global.$post("/Donation/info", {
          campaign_id: this.$route.params.campaign_id,
          perk_id: this.$route.params.perk_id,
          cota_id: this.$route.params.cota_id
        }, this.user.token)
        .then(response => {
          this.campaign = response.data
          if (this.campaign.payment_method == 'bitcoin') {
            this.selectedMethodPayment = 'bitcoin'
          }
          if (this.$route.params.perk_id) {
            this.validation.isCotaOrPerk = true
            this.validation.minDonationValue = response.data.perk.price
            if (response.data.perk.shipping_price > 0) {
              this.validation.haveShipping = true
            }
          }
          if (this.$route.params.cota_id) {
            this.validation.isCotaOrPerk = true
            this.validation.minDonationValue = response.data.cota.min_donation
          }
          if (this.validation.isCotaOrPerk) {
            this.selectedDonationTitleInfo = 'private'
            this.validation.forceIdentifyContribution = true
            this.donator.value = this.validation.minDonationValue
            if (!this.user.token) {
              this.showModalLogin()
            }
          }
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao resgatar as informações")
        })
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
.paymentContribution {

    $gray: #616060;

    .adjustCountriesSelect {
        display: inline!important;
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
        .dropdown-toggle::after {
            display: none;
        }
        .dropdown-menu {
            width: 200px;
            li > a {
                font-size: 10px!important;
            }
        }
        .dropdown-toggle {
            .form-control_aqui,
            .vs__selected-options {
                height: 38px;
                white-space: nowrap;
                max-width: 80%!important;
            }
            .selected-tag {
                margin-top: 7px!important;
                max-width: 90%!important;
                text-overflow: ellipsis!important;
                white-space: nowrap;
                overflow: hidden;
            }
            .open-indicator:before {
                border-color: rgba(60,60,60,.5);
                border-style: solid;
                border-width: 2px 2px 0 0;
                content: "";
                display: inline-block;
                height: 7.5px!important;
                width: 7.5px!important;
                vertical-align: text-top;
                transform: rotate(133deg);
                box-sizing: inherit;
            }
            .vs__actions {
                right: 10px;
                margin-top: 5px;

                position: absolute;
                button,
                span {
                    margin-top: 5px!important;
                    font-size: 18px!important;
                }
            }
            .form-control_aqui {
                background-color: rgba(255, 255, 255,0.0);
                width: 80%;
                margin-top: 0;
            }
            color: gray;
            font-weight: 500;
            height: 38px!important;
            font-size: 14px;
            font-weight: 300;
            border-radius: 2;
            border: 1px;
            background-color: rgba(200, 200, 200,0.1);

        }

    }

    .removeBorderSelect {

        select {
            width: auto;
            display: inline;
            height: 17px;
            margin-left: 2px;
            padding: 1px 2px 2px;
            font-size: 9px;
            color: #333;
            background-color: #ffffff;
            background-image: none;
            border: 1px solid #cccccc;
            -ms-word-break: normal;
            word-break: normal;
        }
    }

    .container {

        .pageContribution {
            .pay-info-wrap {
                width: 100%;
                padding: 20px 35px;
                background-color: white;
                border-radius: 5px;
                box-shadow: 0 0 7px;
                margin-top: 30px;
                .waiting-payment {
                    font-size: 11px!important;
                }
                .header {
                    width: 100%;
                    height: 30px;
                    font-weight: 500;
                    margin-bottom: 10px;
                    .subtitle {
                        float: left;
                        margin-top: 5px;
                        margin-bottom: 5px;
                    }
                    .radios {
                        margin-left: 10px;
                    }
                }

                .wallet-input {
                    input {
                        border: 1px solid #80808033!important;
                        background-color: white!important;
                        color: gray;
                        font-size: 9px;
                        font-weight: 500;
                        height: 30px;
                    }

                    .clipboard {
                        height: 30px;
                        width: 30px;
                        border: 1px solid #80808033;
                        background-color: white!important;
                        position: relative;
                        cursor: pointer;

                        svg {
                            position: absolute;
                            top: 0;
                            bottom: 0;
                            left: 0;
                            right: 0;
                            margin: auto;
                            color: gray;

                        }
                    }

                    .clipboard:hover {
                        border-width: 2px;
                    }
                }

                .bottom {
                    margin-top: 20px;
                    font-size: 12px;
                }

            }
            .qrcode {
                margin-top: 15px;
                width: 100%;
                .price {
                    margin-top: 5px;
                    font-size: 9px;
                    svg {
                        margin: 0 5px;
                    }
                    .qtd {
                        color: #158cb1;
                        font-weight: 500;
                    }
                }
            }

            width: 100%;
            color: $gray;

            .smallDescription {
                font-size: 10px;
                margin-left: 0;

            }
            h6 {
                font-weight: 510;
                font-size: 15px;
            }
            h5 {
                font-weight: 500;
                font-size: 15px;
            }
            h4 {
                font-weight: 400;
                font-size: 23px;
            }
            .wrap-right {
                .row {
                    margin-bottom: 20px;
                }
                hr {
                    margin-bottom: 30px;
                }
            }
            ::placeholder {

                font-size: 14px;
                font-weight: 300;
            }
            .input-group-text,
            input, select,
            input:focus {
                border-radius: 2;
                // border: 1px;
                background-color: rgba(200, 200, 200,0.1);
            }
            .userTab {
                margin-top: 30px;
                margin-bottom: 50px;
                .userImg {
                    .img {
                        width: 60px;
                        height: 60px;
                        background-size: cover;
                        background-repeat: no-repeat;
                        margin-right: 10px;
                        float: left;
                    }
                }
                .user {
                    padding-top: 5px;
                    line-height: 17px;
                    .name {
                        font-weight: 500;
                        font-size: 15px;
                    }
                    .email {
                        font-size: 12px;
                    }
                    .logout {
                        font-size: 12px;
                    }
                }
            }

            .buy-wrap {
                width: 100%;
                padding: 20px 35px;
                background-color: white;
                border-radius: 5px;
                box-shadow: 0 0 7px;
                .reward-info-title {
                    color: $blue;
                    font-weight: 600;
                }
                .no-shipping {
                    color: $orange;
                    font-size: 1rem;
                    font-weight: 600;
                    margin-bottom: 0;
                }
            }
        }
    }
    @media only screen and (max-width: 800px) {
        .container {
            .wrap-right {
                margin-top: 50px;
            }
        }
    }
}
</style>
