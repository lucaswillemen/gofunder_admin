<template>
  <main>
    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>
    <md-dialog-alert
      :md-active.sync="alertError"
      md-title="Erro ao tentar efetuar saque!"
      :md-content="alertErrorMsg" />
      <section>
        <md-table v-model="searched" md-card>
          <md-table-toolbar>

            <div class="md-toolbar-section-start">
              <h1 class="md-status">Usuário</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
              <md-input placeholder="Procurar por nome .." v-model="search" @input="searchOnTable" />
            </md-field>
          </md-table-toolbar>
          <md-table-row>
            <md-table-head>
              <div @click="changeOrdenation('created_at')" style="width: 100%">
                Data
                <md-icon class="custom-icon" v-if="orderType=='desc' && orderBy=='created_at'">arrow_downward</md-icon>
                <md-icon class="custom-icon" v-else-if="orderType=='asc' && orderBy=='created_at'">arrow_upward</md-icon>
                <md-icon class="custom-icon" v-else>arrow_downward</md-icon>
              </div>
            
            </md-table-head>
            <md-table-head>
              <div @click="changeOrdenation('amount')" style="width: 100%">
                Valor
                <md-icon class="custom-icon" v-if="orderType=='desc' && orderBy=='amount'">arrow_downward</md-icon>
                <md-icon class="custom-icon" v-else-if="orderType=='asc' && orderBy=='amount'">arrow_upward</md-icon>
                <md-icon class="custom-icon" v-else>arrow_downward</md-icon>
              </div>
            </md-table-head>
            <md-table-head>
              <div @click="changeOrdenation('msg')" style="width: 100%">
                Mensagem
                <md-icon class="custom-icon" v-if="orderType=='desc' && orderBy=='msg'">arrow_downward</md-icon>
                <md-icon class="custom-icon" v-else-if="orderType=='asc' && orderBy=='msg'">arrow_upward</md-icon>
                <md-icon class="custom-icon" v-else>arrow_downward</md-icon>
              </div>
            </md-table-head>
            <md-table-head>
              <div @click="changeOrdenation('referer_id')" style="width: 100%">
                Referência
                <md-icon class="custom-icon" v-if="orderType=='desc' && orderBy=='referer_id'">arrow_downward</md-icon>
                <md-icon class="custom-icon" v-else-if="orderType=='asc' && orderBy=='referer_id'">arrow_upward</md-icon>
                <md-icon class="custom-icon" v-else>arrow_downward</md-icon>
              </div>
            </md-table-head>
          </md-table-row>
          <md-table-row v-for="(row, index) in tableData" :key="index">
            <md-table-cell>{{ row.created_at }}</md-table-cell>
            <md-table-cell>{{ row.amount }}</md-table-cell>
            <md-table-cell>{{ row.msg }}</md-table-cell>
            <md-table-cell>{{ row.referer_id }}</md-table-cell>
          </md-table-row>
        </md-table>
      </section>
    <section class="pagination" v-if="!loading && tableData.length != 0">
        <md-button class="md-raised md-primary md-dense" v-for="(pagOpt, index) in paginationController" :key="index"  :class="pagOpt == currentPage ? 'activePage' :''" @click="selectPage(pagOpt)">{{ (pagOpt+1) }}</md-button>  
    </section>
  </main>
</template>

<script>
import {mapState} from 'vuex'
export default {
  name: 'UserExtract',
  data: () => ({
    maxPages: 5,
    numberPages: null,
    numberOfRows: 10,
    paginationController: [],
    loading: false,
    alertError: false,
    alertErrorMsg: null,
    currentPage: 0,
    orderType: 'desc',
    orderBy: 'amount',
    search: null,
    searched: [],
    tableData: []
  }),
  computed: {
    ...mapState(['user'])
  },
  methods: {
    getUserExtract() {
      this.loading = true
				global.$post("/Extract/user",{ page: this.currentPage, order_type: this.orderType, order_by: this.orderBy}, this.user.token)
				.then(response => {
          console.log('foi', response)
          this.numberPages = Math.ceil(response.data.rows/this.numberOfRows)
          this.tableData = response.data.data
          this.paginationController = []
          for (let i = 0; i < this.numberPages; i++) {
            this.paginationController.push(i)
          }
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
        })
        .finally(() => {
          this.loading = false
        })

    }, 
    changeOrdenation(column) {
      if(column != this.orderBy)
        this.orderType = 'asc'
      else
        this.orderType = this.orderType == 'asc' ? 'desc' : 'asc' 
      this.orderBy = column
      this.getUserExtract()
    },
    newUser () {
      window.alert('Noop')
    },
    selectPage(pagOpt) {
      this.currentPage = pagOpt
      this.buildPagination()
      this.getUserExtract()
    },
    searchOnTable () {
      this.searched = this.searchByName(this.tableData, this.search)
    },
    searchByName (items, term) {
      if (term) {
        return items.filter(item => this.toLower(item.name).includes(this.toLower(term)))
      }
      return items
    },
    toLower(text) {
      return text.toString().toLowerCase()
    },
    buildPagination() {
      if(this.numberPages < this.maxPages) {
        this.maxPages = this.numberPages
      }
      if (this.currentPage < 0) {
        this.currentPage = 0;
      } else if (this.currentPage > this.numberPages) {
          this.currentPage = this.numberPages;
      }
      let halfArray = Math.ceil(this.maxPages/2)
      let lefts = []
      let rights = []
      for (let i = 1; i < 3; i++) {
        if(this.currentPage + i < this.numberPages) {
          rights.push(this.currentPage + i)
        }
        if(this.currentPage - i >= 0) {
          lefts.unshift(this.currentPage - i)
        }
      }
      if(lefts.length <  rights.length) {
        while(lefts.length + rights.length < (this.maxPages - 1)) {
          rights.push(rights[rights.length-1] + 1)
        }
      }
      if(rights.length < lefts.length) {
        while(lefts.length + rights.length < (this.maxPages - 1)) {
          lefts.unshift(lefts[0] - 1)
        }
      }
      console.log('right', rights, 'LEFTS:', lefts)
      let newArrayPag = lefts.map(elem => {
        return elem
      })
      newArrayPag.push(this.currentPage)
      rights.forEach(element => {
        newArrayPag.push(element)
      });

      this.paginationController = newArrayPag
    },
  },
  created () {
    this.searched = this.tableData
  },
  mounted() {
    this.getUserExtract()
  }
}
</script>

<style lang="scss" scoped>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 16px;
  padding: .75rem;
  border-radius: 0.25rem;
  background-color: white;
  color: black;
  button {
    min-width: 35px !important;
  }
  
  .activePage {
    pointer-events: none;
    background-color: rgba(95, 30, 4, 0.774) !important;
  }
  button:focus {
    outline: 0 !important;
    box-shadow: none !important;
  }
  button:not(:last-child) {
    margin-right: 0.5rem;
  }
}
.loading-overlay {
  z-index: 10;
  top: 0;
  left: 0;
  right: 0;
  position: absolute;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
}
.custom-icon {
  cursor: pointer;
  font-size: 1rem !important;
}
.md-card.md-table.md-theme-default {
  overflow-x: auto !important; 
}

</style>
