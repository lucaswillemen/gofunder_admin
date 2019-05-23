<template>
  <main>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-status">Cotas</h1>
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
        <md-table-cell md-label="Nome" md-sort-by="name">{{ item.name }}</md-table-cell>
        <md-table-cell md-label="Data" md-sort-by="date" md-numeric>{{ item.date }}</md-table-cell>
        <md-table-cell md-label="Valor" md-sort-by="value">{{ item.value }}</md-table-cell>
      </md-table-row>
    </md-table>
  </main>
</template>

<script>
export default {
  name: 'QuotaExtract',
  data: () => ({
    search: null,
    searched: [],
    users: [
      {
        name: 'Arthur',
        date: 1,
        value: "sdubbin0@geocities.com",
      },
      {
        name: 'Arthur',
        date: 2,
        value: "odemageard1@spotify.com",
      },
      {
        name: 'Arthur',
        date: 3,
        value: "vtaleworth2@google.ca",
      },
      {
        name: 'Arthur',
        date: 4,
        value: "lizkovitz3@youtu.be",
      },
      {
        name: 'Arthur',
        date: 5,
        value: "tstave4@reference.com",
      },
      {
        name: 'Arthur',
        date: 6,
        value: "kchipping5@scribd.com",
      },
      {
        name: 'Arthur',
        date: 7,
        value: "hholyard6@howstuffworks.com",
      },
      {
        name: 'Arthur',
        date: 8,
        value: "rtitterton7@nydailynews.com",
      },
      {
        name: 'Arthur',
        date: 9,
        value: "gapplewhite8@reverbnation.com",
      },
      {
        name: 'Arthur',
        date: 10,
        value: "nmulgrew9@plala.or.jp",
      },
      {
        name: 'Arthur',
        date: 11,
        value: "crimingtona@usnews.com",
      },
      {
        name: 'Arthur',
        date: 12,
        value: "megglesonb@elpais.com",
      },
      {
        name: 'Arthur',
        date: 13,
        value: "ccaulketc@cbsnews.com",
      },
      {
        name: 'Arthur',
        date: 14,
        value: "sswynfend@cpanel.net",
      },
      {
        name: 'Arthur',
        date: 15,
        value: "iragglese@cbc.ca",
      },
      {
        name: 'Arthur',
        date: 16,
        value: "kminesf@topsy.com",
      },
      {
        name: 'Arthur',
        date: 17,
        value: "sjudrong@jigsy.com",
      },
      {
        name: 'Arthur',
        date: 18,
        value: "cmarietonh@theatlantic.com",
      },
      {
        name: 'Arthur',
        date: 19,
        value: "plotteringtoni@netvibes.com",
      },
      {
        name: 'Arthur',
        date: 20,
        value: "mthomsj@webeden.co.uk",
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
