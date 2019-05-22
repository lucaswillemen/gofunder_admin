<template>
  <main>
    <div id="donation-table">
       <div class="d-flex justify-content-end mt-3 mb-3">
         <b-input-group class=" search-group" size="sm">
           <b-form-input v-model="keyword" placeholder="Search" type="text"></b-form-input>
           <b-input-group-text slot="append">
           <b-btn class="p-0" :disabled="!keyword" variant="link" size="sm" @click="keyword = ''">
             <i class="fa fa-search"></i>
           </b-btn>
           </b-input-group-text>
         </b-input-group>
       </div>

      <b-table :fields="fields" :items="items" :keyword="keyword" :current-page="currentPage" :per-page="perPage"></b-table>
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          class="my-0" 
        ></b-pagination>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      keyword: "",
      totalRows: 3,
      currentPage: 1,
      perPage: 2,
      dataArray: [
        { value: "$ 150.00", campaign: "Campanha test", date: "05/06/2019", reward: "Sim", quota: "Não" },
        { value: "$ 220.00", campaign: "Eu gosto de cafe", date: "12/09/2019", reward: "Não", quota: "Não" },
        { value: "$ 567.00", campaign: "Coffee when", date: "15/06/2019", reward: "Não", quota: "Sim" },
        { value: "$ 4500.00", campaign: "Capacete inflável", date: "25/12/2020", reward: "Não", quota: "Não" },
      ],
      fields: [
        { key: "value", label: "Valor", sortable: true },
        { key: "campaign", label: "Campanha", sortable: true },
        { key: "date", label: "Data", sortable: true },
        { key: "reward", label: "Recompensa", sortable: true },
        { key: "quota", label: "Cota", sortable: true },

      ]
    };
  },
  computed: {
    items() {
      return this.keyword ? this.dataArray.filter(item => item.firstname.includes(this.keyword)
       || item.lastname.includes(this.keyword) || item.email.includes(this.keyword)): this.dataArray;
    }
  }
};
</script>

<style lang="scss" scoped>
#donation-table {
    overflow-x: auto;
    width: 100%;
  .input-group-text {
    padding: 0 0.5em 0 0.5em;

    .fa {
      font-size: 12px;
    }
  }
  .search-group {
      width: 250px;
      button {
          width: 30px;
      }
  }
}
</style>

