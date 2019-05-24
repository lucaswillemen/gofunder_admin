<template>
  <main>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-status">Usuário</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Procurar por nome .." v-model="search" @input="searchOnTable" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="Nenhum usuário encontrado"
        :md-description="`Nenhum retorno para '${search}'. Tente uma busca diferente.`">
        <md-button class="md-primary md-raised" @click="newUser">Buscar</md-button>
      </md-table-empty-state>

      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="Data" md-sort-by="date" md-numeric>{{ item.date }}</md-table-cell>
        <md-table-cell md-label="Valor" md-sort-by="value">{{ item.value }}</md-table-cell>
        <md-table-cell md-label="Tipo" md-sort-by="type">{{ item.type }}</md-table-cell>
        <md-table-cell md-label="Referencia" md-sort-by="referer">{{ item.referer }}</md-table-cell>
      </md-table-row>
    </md-table>
  </main>
</template>

<script>
export default {
  name: 'UserExtract',
  data: () => ({
    search: null,
    searched: [],
    users: [
      {
        date: '31/10/1995 23:52:01',
        value: '$100,00',
        type: 'Cota de Produto', // [cota, doacao, saque, afiliados]
        referer: 'Bicileta Ergonomica' // cota [nome produto], doacao [nome campanha], [saque bitcoin ou swift], afiliados [nome afiliado]
      }
    ]
  }),
  methods: {
    newUser () {
      window.alert('Noop')
    },
    searchOnTable () {
      this.searched = this.searchByName(this.users, this.search)
    },
    searchByName (items, term) {
      if (term) {
        return items.filter(item => this.toLower(item.name).includes(this.toLower(term)))
      }
      return items
    },
    toLower(text) {
      return text.toString().toLowerCase()
    }
  },
  created () {
    this.searched = this.users
  }
}
</script>

<style lang="scss" scoped>
.md-card.md-table.md-theme-default {
  overflow-x: auto !important; 
}
</style>
