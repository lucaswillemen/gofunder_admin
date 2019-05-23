<template>
  <main>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-status">Campanhas</h1>
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
        <md-table-cell md-label="Usuario" md-sort-by="user">{{ item.user }}</md-table-cell>
        <md-table-cell md-label="Recompensa" md-sort-by="reward">{{ item.reward }}</md-table-cell>
        <md-table-cell md-label="Cota" v-if="item.quota != 'NONE'" md-sort-by="quota">
           <md-button class="md-icon-button" >
             <md-icon >{{item.quota}}</md-icon></md-button>
           </md-table-cell>
          <md-table-cell md-label="Cota" v-if="item.quota == 'NONE'" md-sort-by="quota">
        Não
          </md-table-cell>
      </md-table-row>
     
       
    </md-table>
  </main>
</template>

<script>
export default {
  name: 'WithdrawExtract',
  data: () => ({
    search: null,
    searched: [],
    users: [
      {
        date: '31/10/1995 23:52:01',
        value: '$100,00',
        user: "Anônimo",
        reward: "Não",
        quota: 'NONE'
      },
      
       {
        date: '31/10/1995 23:52:01',
        value: '$100,00',
        user: "Anônimo",
        reward: "Não",
        quota: 'info'
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
