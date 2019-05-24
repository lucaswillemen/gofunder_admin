<template>
<main>

  <md-dialog :md-active.sync="createQuota">
    <md-dialog-title>Criar uma cota</md-dialog-title>

    <md-card-content style="display:flex; flex-direction: column;">
      <p>Olá, para criar sua cota preencha as informações a seguir corretamente abaixo. <br />
        Lembrando que se a soma de suas cotas superar 70% não será possível criar novas cotas uma
        vez que 30% das vendas do marketplace é obrigatóriamente reservado ao inventor..</p>
      <div class="md-layout md-gutter">
        <div class="md-layout-item md-size-50">
          <md-field>
            <md-icon>show_chart</md-icon>
            <label>Porcentagem da cota</label>
            <md-input v-model="number" max="100" min="0"></md-input>
            <span class="md-helper-text">Digite aqui de 0 a 70% do quanto das suas vendas você quer distrubir nessa cota</span>
          </md-field>
        </div>
        <div class="md-layout-item md-size-50">
          <md-field>
            <md-icon>people</md-icon>
            <label>Número de pessoas</label>
            <md-input v-model="number" max="1000" min="0"></md-input>
            <span class="md-helper-text">Coloque aqui o número de pessoas que vão poder adquirir essa cota. A porcetagem da cota é dividido entre essas pessoas</span>
          </md-field>
        </div>
      </div>
      <div class="md-layout md-gutter">
        <div class="md-layout-item md-size-50">
          <md-field>
            <md-icon>event</md-icon>
            <label>Qual tempo de expiração da cota?</label>
            <md-select v-model="movie" name="movie" id="movie">
              <md-option value="fight-club">12 meses</md-option>
              <md-option value="godfather">24 meses</md-option>
              <md-option value="godfather-ii">36 meses</md-option>
            </md-select>
            <span class="md-helper-text">Você pode definir tempo de expiração pras cotas vendidas vigorando a partir do lançamento no marketplace</span>
          </md-field>
        </div>
        <div class="md-layout-item md-size-50">
          <md-field>
            <md-icon>monetization_on</md-icon>
            <label>Qual doação mínima?</label>
            <md-input v-model="number" min="0"></md-input>
            <span class="md-helper-text">Coloque aqui a doação mínima que a pessoa deve doar para ter direito à essa cota</span>
          </md-field>
        </div>
      </div>
    </md-card-content>

    <md-dialog-actions>
      <md-button class="md-primary" @click="createQuota = false">Fechar</md-button>
      <md-button class="md-primary md-raised" @click="createQuota = false">
        <md-icon style="color:white;">save</md-icon> Criar Cota
      </md-button>
    </md-dialog-actions>


  </md-dialog>

  <div class="md-layout-item md-small-size-100 md-size-100">
    <md-card>
      <md-empty-state style="padding-bottom: 0 !important;" md-icon="find_in_page" md-label="Criar uma cota!" md-description="Você pode criar cotas para pessoas que realizarem doações para seu produto.
					Cada vez que você vender este seu produto no marketplace (após ele ser lançado) parte do valor do produto vendido
					 será revertido para o usuário que doou pra você e ganhou uma cota"></md-empty-state>
      <md-card-content style="display:flex; align-items: center; flex-direction: column;">
        <md-button class="md-primary md-raised" @click="createQuota = true">Criar uma cota</md-button>

        <br />
        <br />
        <span class="md-title">
          Cotas Criadas
        </span>
        <md-table>
          <md-table-row>
            <md-table-head md-numeric>Doação Mínima</md-table-head>
            <md-table-head>Porcentagem</md-table-head>
            <md-table-head>Número Cotistas Máximo</md-table-head>
            <md-table-head>Expiração</md-table-head>
            <md-table-head>Apagar</md-table-head>
          </md-table-row>
          <md-table-row slot="md-table-row" v-for="(item, index) in users" :key="index">
            <md-table-cell md-label="Doação mínima" md-sort-by="value">{{ item.value }}</md-table-cell>
            <md-table-cell md-label="Porcentagem" md-sort-by="value">{{ item.percent }}</md-table-cell>
            <md-table-cell md-label="Número máximo de cotistas" md-sort-by="value">{{ item.quotas }}</md-table-cell>
            <md-table-cell md-label="Expiração" md-sort-by="value">{{ item.expiry }}</md-table-cell>
            <md-table-cell md-label="Expiração" md-sort-by="value">
              <md-icon class="md-mini-xs" @click="deleteQuota(item.id)">delete</md-icon>
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
export default {
  data: () => ({
    search: null,
    createQuota: false,
    searched: [],
    quota: {
      stock: 0,
      amount: 0,
      percent: 0,
      stock: 0,
      expiry: null
    },
    users: [{
        percent: '10%',
        value: '$100,00',
        quotas: 1500,
        expiry: '12 meses'
      },
      {
        percent: '30%',
        value: '$1000,00',
        quotas: 1500,
        expiry: '12 meses'
      },
      {
        percent: '50%',
        value: '$10000,00',
        quotas: 1500,
        expiry: '36 meses'
      }
    ]
  }),
  methods: {
    deleteQuota() {
      alert("Cota deletada")
    },
    newUser() {
      window.alert('Noop')
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
  }
}
</script>

<style lang="scss" scoped>
.md-dialog {
    width: 70%;
}
.md-mini-xs {
    cursor: pointer;
    width: 15px!important;
}
</style>
