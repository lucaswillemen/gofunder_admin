<template>
<main>
  <md-dialog-alert :md-active.sync="alertError" :md-title="$f('COTAS::Erro ao criar cota!')" :md-content="alertErrorMsg" />
  <md-dialog-alert :md-active.sync="alertSuccess" :md-title="$f('COTAS::Cota criada!')" :md-content="$f('COTAS::Cota adicionada com sucesso!')" />
  <md-dialog :md-active.sync="createQuota">
    <md-dialog-title>{{"COTAS::Criar uma cota" | fix}}</md-dialog-title>

    <md-card-content style="display:flex; flex-direction: column;">
      <p>{{"COTAS::Olá, para criar sua cota preencha as informações a seguir corretamente abaixo." | fix}}<br/> {{"COTAS::Lembrando que se a soma de suas cotas superar 70% não será possível criar novas cotas uma vez que 30% das vendas do marketplace é obrigatóriamente reservado ao inventor..." | fix}}</p>
      <div class="md-layout md-gutter" style="margin-bottom: 1.5rem;">
        <div class="md-layout-item md-size-50">
          <md-field :class="{'md-invalid': $v.cotaAdd.percent.$invalid && $v.cotaAdd.percent.$dirty}">
            <md-icon>show_chart</md-icon>
            <label>{{"COTAS::Porcentagem da cota" | fix}}</label>
            <md-input v-model="cotaAdd.percent" max="100" min="1"></md-input>
            <span class="md-helper-text">{{"COTAS::Digite aqui de 0 a 70% do quanto das suas vendas você quer distrubir nessa cota" | fix}}</span>
            <span class="md-error">{{"COTAS::Sua cota deve ficar entre 0% e 70%. Atualmente você tem:" | fix}} {{totalPercentage}}% {{"COTAS::reservado das vendas em outras cotas" | fix}}</span>
          </md-field>
        </div>
        <div class="md-layout-item md-size-50">
          <md-field :class="{'md-invalid': $v.cotaAdd.stock.$invalid && $v.cotaAdd.stock.$dirty}">
            <md-icon>people</md-icon>
            <label>{{"COTAS::Número de pessoas" | fix}}</label>
            <md-input v-model="cotaAdd.stock" max="1000" min="1"></md-input>
            <span class="md-error">{{"COTAS::Digite o número de pessoas que poderão garantir a essa cota" | fix}}</span>
            <span class="md-helper-text">{{"COTAS::Coloque aqui o número de pessoas que vão poder adquirir essa cota. A porcetagem da cota é dividido entre essas pessoas" | fix}}</span>
          </md-field>
        </div>
      </div>
      <div class="md-layout md-gutter">
        <div class="md-layout-item md-size-50">
          <md-field :class="{'md-invalid': $v.cotaAdd.expiry.$invalid && $v.cotaAdd.expiry.$dirty}">
            <md-icon>event</md-icon>
            <label>{{"COTAS::Qual tempo de expiração da cota?" | fix}}</label>
            <md-select v-model="cotaAdd.expiry" name="movie" id="movie" style="margin-left: 14px;">
              <md-option value="12months">{{"DB::12months" | fix}}</md-option>
              <md-option value="24months">{{"DB::24months" | fix}}</md-option>
              <md-option value="36months">{{"DB::36months" | fix}}</md-option>
            </md-select>
            <span class="md-helper-text">{{"COTAS::Você pode definir o tempo de expiração pras cotas vendidas vigorando a partir do lançamento no marketplace" | fix}}</span>
          </md-field>
        </div>
        <div class="md-layout-item md-size-50">
          <md-field :class="{'md-invalid': $v.cotaAdd.min_donation.$invalid && $v.cotaAdd.min_donation.$dirty}">
            <md-icon>monetization_on</md-icon>
            <label>{{"COTAS::Qual doação mínima?" | fix}}</label>
            <md-input v-model.lazy="cotaAdd.min_donation" min="1" v-money="money"></md-input>
            <span class="md-helper-text">{{"COTAS::Coloque aqui a doação mínima que a pessoa deve doar para ter direito à essa cota" | fix}}</span>
          </md-field>
        </div>
      </div>
    </md-card-content>

    <md-dialog-actions>
      <md-button class="md-primary" @click="createQuota = false">{{"COMMON::Fechar" | fix}}</md-button>
      <md-button class="md-primary md-raised" @click="addCota()">
        <md-icon style="color:white;">save</md-icon> {{"COTAS::Criar Cota" | fix}}
      </md-button>
    </md-dialog-actions>


  </md-dialog>

  <div class="md-layout-item md-small-size-100 md-size-100">
    <md-card>
      <md-empty-state style="padding-bottom: 0 !important;" md-icon="find_in_page" :md-label="$f('COTAS::Criar uma cota!')" :md-description="$f('COTAS::Você pode criar cotas para pessoas que realizarem doações para seu produto. Cada vez que você vender este seu produto no marketplace (após ele ser lançado) parte do valor do produto vendido será revertido para o usuário que doou pra você e ganhou uma cota')"></md-empty-state>
      <md-card-content style="display:flex; align-items: center; flex-direction: column;">
        <md-button :disabled="totalPercentage == 70" class="md-primary md-raised" @click="createQuota = true">{{"COTAS::Criar uma cota" | fix}}</md-button>
        <div v-if="totalPercentage == 70">
          <p style="color: #ff1744">{{"COTAS::Você já atingiu 70% do valor do seu produto em cotas, não é possível adicionar mais cotas no momento!" | fix}}</p>
        </div>
        <br>
        <br>
        <span class="md-title" v-if="cotaList.length > 0">
          {{"COTAS::Cotas Criadas" | fix}}
        </span>
        <span class="total-percentage" v-if="totalPercentage">{{"COTAS::Soma das porcentagens das cotas:" | fix}} {{this.totalPercentage}}%</span>

        <md-table v-if="cotaList.length > 0" class="tabela-cotas">
          <md-table-row>
            <md-table-head md-numeric>{{"COTAS::Doação Mínima" | fix}}</md-table-head>
            <md-table-head>{{"COTAS::Porcentagem" | fix}}</md-table-head>
            <md-table-head>{{"COTAS::Número máximo de cotistas" | fix}}</md-table-head>
            <md-table-head>{{"COTAS::Expiração" | fix}}</md-table-head>
            <md-table-head>{{"COTAS::Apagar" | fix}}</md-table-head>
          </md-table-row>
          <md-table-row slot="md-table-row" v-for="(item, index) in cotaList" :key="index">
            <md-table-cell :md-label="$f('COTAS::Doação Mínima')" md-sort-by="value">{{ item.min_donation }}</md-table-cell>
            <md-table-cell :md-label="$f('COTAS::Porcentagem')" md-sort-by="value">{{ item.percent }}%</md-table-cell>
            <md-table-cell :md-label="$f('COTAS::Número máximo de cotistas')" md-sort-by="value">{{ item.stock }}</md-table-cell>
            <md-table-cell :md-label="$f('COTAS::Expiração')" md-sort-by="value">{{ $f(`DB::${item.expiry}`) }}</md-table-cell>
            <md-table-cell :md-label="$f('COTAS::Ação')" md-sort-by="value">
              <md-button class="md-accent" @click="delCota(item.id)">
                <md-icon class="md-mini-xs">delete</md-icon>
              </md-button>
            </md-table-cell>
          </md-table-row>
        </md-table>

      </md-card-content>
      <md-card-actions>

      </md-card-actions>
    </md-card>
  </div>
</main>
</template>

<script>
import {
  mapState
} from "vuex";
import {
  required
} from "vuelidate/lib/validators";
export default {
  data: () => ({
    alertError: false,
    alertErrorMsg: null,
    alertSuccess: false,
    money: {
      decimal: ',',
      thousands: '.',
      precision: 2,
    },
    search: null,
    createQuota: false,
    searched: [],
    cotaAdd: {
      stock: null,
      min_donation: null,
      percent: null,
      expiry: '12months'
    },
    totalPercentage: 0,
    cotaList: []
  }),
  validations: {
    cotaAdd: {
      stock: {
        required
      },
      min_donation: {
        required
      },
      percent: {
        required,
        percentInterval: function(params) {
          if (this.cotaAdd.percent >= 0 && this.cotaAdd.percent <= 70 && (Number(this.cotaAdd.percent) + Number(this.totalPercentage)) <= 70) {
            return true
          }
          return false
        }
      },
      expiry: {
        required
      }
    }
  },
  computed: {
    ...mapState(["user"])
  },
  methods: {
    delCota(cota_id) {
      global
        .$post("/CampaignInfo/Cota/delete", {
          id: cota_id
        }, this.user.token)
        .then(response => {})
        .catch(err => {})
        .finally(err => {
          this.listCotas()
        })
    },
    listCotas() {
      global
        .$get("/CampaignInfo/Cota/get?campaign_id=" + this.$route.params.id, {}, this.user.token)
        .then(response => {
          this.cotaList = response.data
          this.totalPercentage = 0
          response.data.forEach(element => {
            this.totalPercentage += Number(element.percent)
          });
          console.log(total)

        })
        .catch(err => {})
    },
    addCota() {
      this.$v.cotaAdd.$touch();
      if (!this.$v.cotaAdd.$invalid) {
        let params = this.cotaAdd
        params.campaign_id = this.$route.params.id
        global
          .$post("/CampaignInfo/Cota/add", params, this.user.token)
          .then(response => {
            this.alertSuccess = true
          })
          .catch(err => {
            let validErr =
              err && err.response && err.response.data && err.response.data.error;
            this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
            this.alertError = true;
          })
          .finally(err => {
            this.createQuota = false
            this.$resetObj(this.cotaAdd)
            this.$v.$reset()
            this.listCotas()
          })
      } else {
        console.log('deu err')
      }
    },
    searchOnTable() {
      this.searched = this.searchByName(this.users, this.search)
    },
    searchByName(items, term) {
      if (term) {
        return items.filter(item => this.toLower(item.name).includes(this.toLower(term)))
      }
      return items
    },
    toLower(text) {
      return text.toString().toLowerCase()
    }
  },
  created() {
    this.searched = this.users
  },
  mounted() {
    this.listCotas()
  }
}
</script>

<style lang="scss" scoped>
@media (max-width: 860px) {
    .tabela-cotas {
        overflow-x: auto;
    }
}
.tabela-cotas {
    max-width: 85%;

}
.total-percentage {
    font-size: 14px;
    color: #707070;
}
.md-dialog {
    width: 70%;
}
.md-mini-xs {
    cursor: pointer;
    width: 15px!important;
}
</style>
