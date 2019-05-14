<template>
  <main>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-status">Doações</h1>
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
        <md-table-cell md-label="Nome" md-sort-by="name">{{ item.name }}</md-table-cell>
        <md-table-cell md-label="Campanha" md-sort-by="campaign">{{ item.campaign }}</md-table-cell>
        <md-table-cell md-label="Título" md-sort-by="title">{{ item.title }}</md-table-cell>
        <md-table-cell md-label="Status" md-sort-by="status">{{ item.status }}</md-table-cell>
      </md-table-row>
    </md-table>
  </main>
</template>

<script>
export default {
  name: 'DonationExtract',
  data: () => ({
    search: null,
    searched: [],
    users: [
      {
        date: 1,
        value: "sdubbin0@geocities.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Assistant Media Planner"
      },
      {
        date: 2,
        value: "odemageard1@spotify.com",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Account Coordinator"
      },
      {
        date: 3,
        value: "vtaleworth2@google.ca",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Community Outreach Specialist"
      },
      {
        date: 4,
        value: "lizkovitz3@youtu.be",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Operator"
      },
      {
        date: 5,
        value: "tstave4@reference.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Software Test Engineer III"
      },
      {
        date: 6,
        value: "kchipping5@scribd.com",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Safety Technician II"
      },
      {
        date: 7,
        value: "hholyard6@howstuffworks.com",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Internal Auditor"
      },
      {
        date: 8,
        value: "rtitterton7@nydailynews.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Technical Writer"
      },
      {
        date: 9,
        value: "gapplewhite8@reverbnation.com",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "GIS Technical Architect"
      },
      {
        date: 10,
        value: "nmulgrew9@plala.or.jp",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Staff Scientist"
      },
      {
        date: 11,
        value: "crimingtona@usnews.com",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Assistant Professor"
      },
      {
        date: 12,
        value: "megglesonb@elpais.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Recruiting Manager"
      },
      {
        date: 13,
        value: "ccaulketc@cbsnews.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Safety Technician IV"
      },
      {
        date: 14,
        value: "sswynfend@cpanel.net",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Environmental Specialist"
      },
      {
        date: 15,
        value: "iragglese@cbc.ca",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "VP Sales"
      },
      {
        date: 16,
        value: "kminesf@topsy.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Administrative Officer"
      },
      {
        date: 17,
        value: "sjudrong@jigsy.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Staff Scientist"
      },
      {
        date: 18,
        value: "cmarietonh@theatlantic.com",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Paralegal"
      },
      {
        date: 19,
        value: "plotteringtoni@netvibes.com",
        name: 'Arthur',
        campaign: "Female",
        title: "title test",
        status: "Marketing Assistant"
      },
      {
        date: 20,
        value: "mthomsj@webeden.co.uk",
        name: 'Arthur',
        campaign: "Male",
        title: "title test",
        status: "Actuary"
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
