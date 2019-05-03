<template>
<section id="add-credit-card">

  <b-container class="card-wrapper" v-show="this.name||this.number||this.expiry||this.cvc">
  </b-container>

  <br />

  <b-container>
    <b-row>

      <b-col class="mb-1" cols="12" sm="12" md="12" lg="12" xl="12">
        <b-form class="card-form">
          <b-form-group label-size="sm" label="Nome titular do Cartão" label-for="card-form-name">
            <b-form-input id="card-form-name" type="text" placeholder="Nome titular" name="name" v-model="name" required>
            </b-form-input>
          </b-form-group>
          <b-form-group label-size="sm" label="Número de Cartão de Crédito" label-for="card-form-number">
            <b-form-input id="card-form-number" type="text" placeholder="0000 0000 0000 0000" name="number" v-model="number" required>
            </b-form-input>
          </b-form-group>
          <b-row>
            <b-col cols="12" sm="12" md="6" lg="6" xl="6">
              <b-form-group label-size="sm" label="Expiração" label-for="card-form-expiry">
                <b-form-input id="card-form-expiry" type="text" placeholder="01/2019" name="expiry" v-model="expiry" required>
                </b-form-input>
              </b-form-group>
            </b-col>
            <b-col cols="12" sm="12" md="6" lg="6" xl="6">
              <b-form-group label-size="sm" label="Código Segurança" label-for="card-form-cvc">
                <b-form-input id="card-form-cvc" placeholder="000" type="text" name="cvc" v-model="cvc" required>
                </b-form-input>
              </b-form-group>
            </b-col>
          </b-row>
          <div class="buttons">
            <div class="btn-noborder">
              <b-button @click="addCreditCard" :disabled="!isComplete()">Adicionar Cartão</b-button>
            </div>
          </div>
        </b-form>
      </b-col>

    </b-row>
  </b-container>

</section>
</template>

<script>
const Card = require('card')

import {
  mapActions,
  mapState,
  mapGetters
} from 'vuex'


export default {
  name: 'AddCreditCard',
  data() {
    return {
      name: null,
      number: null,
      expiry: null,
      cvc: null,
      complete: false
    }
  },
  computed: {
    ...mapState(['user'])
  },
  mounted() {
    this.mountCardComponent()
  },
  methods: {

    isComplete() {
      return this.name && this.number && this.expiry && this.cvc
    },
    addCreditCard() {
      let arrayExpiry = this.expiry.replace(/ /g, '').split('/')
      let objPost = {
        name: this.name,
        number: this.number,
        exp_month: arrayExpiry[0],
        exp_year: arrayExpiry[1],
        cvc: this.cvc
      }
      this.$awn.asyncBlock(global.$post("/Card/createToken", objPost, this.user.token))
        .then(response => {
          return this.$awn.asyncBlock(global.$post("/Card/addCard", {
              tokenCard: response.data.MSG.id
            }, this.user.token))
            .then(data => {
              this.$root.$emit('listAllCardsUpdate')
              this.$awn.success("O cartão foi adicionado com sucesso!")
              this.resetCardForm()
            })
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao gerar o cartão!")
        })
    },

    resetCardForm() {
      this.name = ''
      this.number = ''
      this.expiry = ''
      this.cvc = ''
      this.complete = false
      document.getElementsByClassName("jp-card")[0].classList = "jp-card"
      document.getElementsByClassName("jp-card-number")[0].innerHTML = "0000 0000 0000 0000"
      document.getElementsByClassName("jp-card-name")[0].innerHTML = "Nome titular"
      document.getElementsByClassName("jp-card-expiry")[0].innerHTML = "00/0000"
      document.getElementsByClassName("jp-card-cvc")[0].innerHTML = "000"
    },
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
    }
  }
}
</script>

<style lang="scss" scoped>


</style>
