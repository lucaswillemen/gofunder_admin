<template>
  <main>
    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>
    <md-dialog-alert
      :md-active.sync="alertError"
      md-title="Erro ao tentar efetuar saque!"
      :md-content="alertErrorMsg" />

       <md-dialog-alert v-if="perkInfo"
        :md-active.sync="showPerk"
        md-title="Informações do Perk!"
        :md-content="`Adiquirido em: <strong>${perkInfo.create_at}</strong> <br><br>
                      Informações de entrega: Para <strong>${perkInfo.shipping_address.name}</strong> no endereço ${perkInfo.shipping_address.address} - ${perkInfo.shipping_address.city} (${perkInfo.shipping_address.state}) <br>
                      Preço do frete: <strong>$${perkInfo.shipping_price}</strong>`" />
    <section>
        <md-table md-card>
          <md-table-toolbar>

            <div class="md-toolbar-section-start">
              <h1 class="md-status">Campanhas</h1>
            </div>

            <!-- <md-field md-clearable class="md-toolbar-section-end">
              <md-input placeholder="Procurar por valor .."  />
            </md-field> -->
          </md-table-toolbar>
          <md-table-row>
            <md-table-head>
              <div @click="changeOrdenation('date_donation')" style="width: 100%">
                Data
                <md-icon class="custom-icon" v-if="orderType=='desc' && orderBy=='created_at'">arrow_downward</md-icon>
                <md-icon class="custom-icon" v-else-if="orderType=='asc' && orderBy=='created_at'">arrow_upward</md-icon>
                <md-icon class="custom-icon" v-else>arrow_downward</md-icon>
              </div>
            
            </md-table-head>
            <md-table-head>
              <div @click="changeOrdenation('value_donation')" style="width: 100%">
                Valor
                <md-icon class="custom-icon" v-if="orderType=='desc' && orderBy=='amount'">arrow_downward</md-icon>
                <md-icon class="custom-icon" v-else-if="orderType=='asc' && orderBy=='amount'">arrow_upward</md-icon>
                <md-icon class="custom-icon" v-else>arrow_downward</md-icon>
              </div>
            </md-table-head>
            <md-table-head>
              <div style="width: 100%">
                  Usuário
                </div>
            </md-table-head>
            <md-table-head>
              <div style="width: 100%">
                Recompensa
              </div>
            </md-table-head>
            <md-table-head>
              <div style="width: 100%">
                Cota  
              </div>
            </md-table-head>
          </md-table-row>
          <md-table-row v-for="(row, index) in tableData" :key="index">
            <md-table-cell>{{ row.date_donation }}</md-table-cell>
            <md-table-cell>{{ row.value_donation }}</md-table-cell>
            <md-table-cell>{{ row.DonatorName }}</md-table-cell>
            <md-table-cell v-if="row.IdRecompensa">
              <md-button @click="getRewardById(row.IdRecompensa)" class="md-icon-button md-dense">
                <md-icon>info</md-icon>
              </md-button>
            </md-table-cell>
            <md-table-cell v-if="!row.IdRecompensa">Não há!
            </md-table-cell>
            <md-table-cell v-if="row.IdCota">
              <md-button @click="getCotaById(row.IdCota)" class="md-icon-button md-dense">
                <md-icon>info</md-icon>
              </md-button>
            </md-table-cell>
            <md-table-cell v-if="!row.IdCota">Não há!
            </md-table-cell>
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
import moment from 'moment'
export default {
  
  name: 'CampaignExtract',
  data: () => ({
    maxPages: 5,
    showPerk: false,
    showCota: false,
    perkInfo: null,
    cotaInfo: null,
    numberPages: null,
    numberOfRows: 10,
    paginationController: [],
    loading: false,
    alertError: false,
    alertErrorMsg: null,
    currentPage: 0,
    orderType: 'desc',
    orderBy: 'date_donation',
    search: null,
    tableData: []
  }),
  computed: {
    ...mapState(['user'])
  },
  methods: {
    getCampaignExtract() {
      this.loading = true
				global.$post("/Extract/campaign",{ page: this.currentPage, order_type: this.orderType, order_by: this.orderBy}, this.user.token)
				.then(response => {
          console.log('foi camapi', response)
          this.numberPages = Math.ceil(response.data.rows/this.numberOfRows)
          this.tableData = response.data.data
          this.paginationController = []
          for (let i = 0; i < this.numberPages; i++) {
            this.paginationController.push(i)
          }
          this.buildPagination()

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
      this.getCampaignExtract()
    },
    getRewardById(id) {
      global.$post("/Extract/perkDonationInfo",{perk_id: id}, this.user.token)
				.then(response => {
          this.perkInfo = response.data.data[0]
          this.perkInfo.create_at = moment(this.perkInfo.create_at).format('DD/MM/YYYY - HH:mm')
          try {
          this.perkInfo.shipping_address =  JSON.parse(JSON.parse(this.perkInfo.shipping_address))            
          } catch (error) {
          this.perkInfo.shipping_address = 'Não foi possível resgatar os dados de entrega do nosso banco de dados!'
          }
          this.showPerk = true
				})
				.catch(err => {
          let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
        })
    },
    getCotaById(id) {
      	global.$post("/Extract/cotaDonationInfo",{cota_id: id}, this.user.token)
				.then(response => {
          this.cotaInfo = response.data.data[0]
          this.showCota = true; 
				})
				.catch(err => {
          let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
        })
    },
    selectPage(pagOpt) {
      this.currentPage = pagOpt
      this.getCampaignExtract()
    },
    //quando fazer o search, botar o reset pagination
    // searchOnTable () {
    //   this.searched = this.searchByName(this.tableData, this.search)
    // },
    // searchByName (items, term) {
    //   if (term) {
    //     return items.filter(item => this.toLower(item.amount).includes(this.toLower(term)))
    //   }
    //   return items
    // },
    // toLower(text) {
    //   return text.toString().toLowerCase()
    // },
    buildPagination() {
      //seta o numero de pgs caso o max pages n seja atingido
      if(this.numberPages < this.maxPages) {
        this.maxPages = this.numberPages
      }
      //controla o current page pra n fugir dos limites
      if (this.currentPage < 0) {
        this.currentPage = 0;
      } else if (this.currentPage > this.numberPages) {
          this.currentPage = this.numberPages;
      }

      let halfArray = Math.ceil(this.maxPages/2)
      let lefts = []
      let rights = []
      console.log('right', rights, 'LEFTS:', lefts)

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
    resetPagination() {
      this.maxPages = 5
      this.paginationController = []
      this.currentPage = 0
    }
  },
  mounted() {
    this.resetPagination()
    this.getCampaignExtract()

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
    background-color: #080033!important;
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
