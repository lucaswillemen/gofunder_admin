<template>
  <main>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-status">{{"PRODUCT_EXTRACT::Produtos" | fix}}</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input :placeholder="$f('PRODUCT_EXTRACT::Procurar por nome...')" v-model="search" @input="searchOnTable" />
        </md-field>
      </md-table-toolbar>

      <!-- <md-table-empty-state
        md-label="Nenhum usuário encontrado"
        :md-description="`Nenhum retorno para '${search}'. Tente uma busca diferente.`">
        <md-button class="md-primary md-raised" @click="newUser">Buscar</md-button>
      </md-table-empty-state> -->

      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Data')" md-sort-by="name">{{ item.date }}</md-table-cell>
        <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Valor Bruto')" md-sort-by="value">{{ item.value }}</md-table-cell>
        <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Valor Liquído')" md-sort-by="value_liquid">{{ item.value_liquid }}</md-table-cell>
        <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Nome Produto')" md-sort-by="product_name">{{ item.product_name }}</md-table-cell>
        <md-table-cell v-if="item.user == 'anonymous'" :md-label="$f('PRODUCT_EXTRACT::Usuário')" md-sort-by="user">{{ $f('DB::anonymous') }}</md-table-cell>
        <md-table-cell v-else :md-label="$f('PRODUCT_EXTRACT::Usuário')" md-sort-by="user">{{ item.user }}</md-table-cell>

                <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Entrega')" v-if="item.shipping != 'NONE'" md-sort-by="shipping">
           <md-button class="md-icon-button" >
             <md-icon >{{item.shipping}}</md-icon></md-button>
           </md-table-cell>
          <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Entrega')" v-if="item.shipping == 'NONE'" md-sort-by="shipping">
        {{"PRODUCT_EXTRACT::Não há"}}
          </md-table-cell>

                   <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Comissões')" v-if="item.quota != 'NONE'" md-sort-by="quota">
           <md-button class="md-icon-button" >
             <md-icon >{{item.quota}}</md-icon></md-button>
           </md-table-cell>
          <md-table-cell :md-label="$f('PRODUCT_EXTRACT::Comissões')" v-if="item.quota == 'NONE'" md-sort-by="quota">
        {{"PRODUCT_EXTRACT::Não há"}}
          </md-table-cell>

      </md-table-row>
    </md-table>
  </main>
</template>

<script>
export default {
  name: 'AffiliateExtract',
  data: () => ({
    search: null,
    searched: [],
    users: [
      {
        date: 'Arthur',
        value: '$100,00',
        value_liquid: '$90,00',
        product_name: 'Bicicleta Ergonomica', // link pro produto,
        user: 'Bruno S',
        shipping: 'info',
        quota: 'info'
      }
    ]
  }),
  methods: {
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
