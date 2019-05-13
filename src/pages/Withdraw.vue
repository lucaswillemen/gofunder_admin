<template class=" md-grutter">
  <div class="md-layout md-grutter">
    <form novalidate class="md-layout" @submit.prevent="validateUser">
      <md-card class="md-layout-item">
        <md-card-header>
          <div class="md-title">Saque</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.agency.$invalid && $v.agency.$dirty}">
                <label for="bankAcc">Agência: * </label>
                <md-input id="bankAcc" v-model="agency"></md-input>
                <span class="md-error" v-if="!$v.agency.required">A agência é obrigatória</span>
                <span class="md-error" v-if="!$v.agency.numeric">Insira apenas números!</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.bank.$invalid && $v.bank.$dirty}">
                <label for="bankAcc">Banco: * </label>
                <md-input id="bankAcc" v-model="bank"></md-input>
                <span class="md-error" v-if="!$v.bank.required">O banco é obrigatório</span>
                <span class="md-error" v-if="!$v.bank.numeric">Insira apenas números!</span>

              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.operation.$invalid && $v.operation.$dirty}">
                <label for="bankAcc">Operação: * </label>
                <md-input id="bankAcc" v-model="operation"></md-input>
                <span class="md-error" v-if="!$v.operation.required">A operação é obrigatória</span>
                <span class="md-error" v-if="!$v.operation.numeric">Insira apenas números!</span>

              </md-field>
            </div>
           
          </div>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.bankAccount.$invalid && $v.bankAccount.$dirty}">
                <label for="bankAcc">Conta Bancária: *</label>
                <md-input id="bankAcc" v-model.number="bankAccount"></md-input>
                <span class="md-error" v-if="!$v.bankAccount.required">A conta bancária é obrigatória</span>
                <span class="md-error" v-if="!$v.bankAccount.numeric">Insira apenas números!</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.cpf.$invalid && $v.cpf.$dirty}">
                <label for="bankAcc">CPF: *</label>
                <md-input id="bankAcc" v-model="cpf" v-mask="'###.###.###-##'"></md-input>
                <span class="md-error" v-if="!$v.cpf.required">A conta bancária é obrigatória</span>
              </md-field>
            </div>
          </div>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-50">
              <md-field :class="{'md-invalid': $v.value.$invalid && $v.value.$dirty}">
                <label for="value"></label>
                <money id="value" v-model="value" class="md-input" v-bind="moneyConfig"></money> 
                <span class="md-error" v-if="!$v.value.required">O valor é obrigatória</span>
              </md-field>
            </div>
            <div class="md-layout-item md-size-50" >
              Valor total: $ 10
            </div>
          </div>
          <div class="md-layout md-gutter">
          </div>
        </md-card-content>
        <md-card-actions >
          <md-button :disabled="value <= 0" type="submit" @click.prevent="withdraw()" class="md-primary">Sacar</md-button>
        </md-card-actions>
      </md-card>

    </form>
  </div>
</template>
<script>
import {mapState} from 'vuex'
import { required, numeric } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      agency: null,
      bank: null,
      operation: null,
      bankAccount: null,
      cpf: null,
      value: null,
      taxes: null,
      moneyConfig: {
				decimal: ",",
				thousands: ".",
				prefix: "$ ",
				suffix: "",
				precision: 2,
				masked: false
			}
    }
  },
  validations: {
    agency: {
      required,
      numeric
    },
    bank: {
      required,
      numeric
    },
    operation: {
      required,
      numeric
    },
    cpf: {
      required
    },
    bankAccount: {
      required,
      numeric
    },
    value: {
      required,
      numeric
    },
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {    
    withdraw() {
      this.$v.$touch()
    }
  },
  mounted() {

  }
}
</script>

