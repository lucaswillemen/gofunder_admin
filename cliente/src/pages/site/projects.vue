<template>
<div>
  <main-header></main-header>
  <div class="projects">
    <div class="header" :style="{ backgroundImage: 'url(' + bgHeader + ')' }">
      <div class="container">

        <div class="title center-obj-v">
          <i style="color:#a3640d; font-size:54px;" :class="category.icon"></i> <span>{{category.name}}</span>
        </div>
      </div>
    </div>
    <div class="body">
      <div class="top">
        <div class="container">
          <b-row>
            <b-col lg="3" sm="12"></b-col>
            <b-col lg="9" sm="12">
              <div class="input-search">
                <b-form-input v-model="searchText" type="text" placeholder="Digite o que procura aqui" class="in-border-transp mt-2">
                </b-form-input>
                <font-awesome-icon  v-on:click='newSearch()' icon="search" class="icon-search" />
              </div>
              <div class="select-order">
                <b-dropdown id="ddown2" text="Ordenar Por" class="m-md-2 fullwi btn-noborder-transp lbl-on-corner no-radius-right" style="">
                  <b-dropdown-item @click="changeOrder('relevamce')">Relevância</b-dropdown-item>
                  <b-dropdown-item @click="changeOrder('price')">Preço</b-dropdown-item>
                  <b-dropdown-item @click="changeOrder('sells')">Vendas</b-dropdown-item>
                </b-dropdown>
              </div>
            </b-col>
          </b-row>
        </div>
      </div>
      <div class="content">
        <div class="container">
          <b-row>
            <b-col lg="3">
              <sidebar></sidebar>
            </b-col>
            <b-col lg="9">
              <project-card :projects="projects"></project-card>
              <div class="btn-showmore btn-border">
                <b-button v-on:click='newPage()'>Mostrar mais</b-button>
              </div>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
  </div>
  <pre-footer></pre-footer>
  <main-footer></main-footer>
</div>
</template>

<script>
export default {
  mounted() {
    this.getCategory(this.category_id)
  },
  data() {
    return {
      ascOrder: false,
      orderBy: 'relevance',
      category_id: !this.$route.params.category ? 0 : this.$route.params.category,
      projectType: !this.$route.params.type ? 'all' : this.$route.params.type,
      searchText: !this.$route.params.search ? '' : this.$route.params.search,
      category: {
        icon: "fab fa-searchengin",
        name: "Procurar projetos",
        id: 0
      },
      iconHeader: require('Img/telefone.png'),
      bgHeader: require('Img/projetos/bg-header.png'),
      projects: []
    }
  },
  methods: {
    changeType(type) {
      if(type !== this.projectType) {
        this.projectType = type
        this.projects = []
        this.getSearchItems()
      }
    },
    changeOrder(order) {
      this.ascOrder = (order == this.orderBy)
      this.orderBy = order
      this.projects = []
      this.getSearchItems()
    },
    newPage() {
      this.curPage += 1
      this.getSearchItems()
    },
    newSearch() {
      this.projects = []
      this.getSearchItems()
    },
    getSearchItems() {
      this.$awn.asyncBlock(global.$post("/Campaign/search_list", {
          search: this.searchText,
          limit_page: this.curPage,
          category_id: this.category_id,
          order_by: this.orderBy,
          asc_order: this.ascOrder,
          type_project: this.projectType
        }))
        .then(response => {
          for (var i in response.data.MSG) {
            let percent = ((100 / response.data.MSG[i].cash) * response.data.MSG[i].cash_received)
            response.data.MSG[i].percent = percent > 100 ? 100 : percent
            this.projects.push(response.data.MSG[i])
          }
        })
        .catch(err => {})
    },
    getCategory(id) {
      this.curPage = 0
      this.category_id = id
      this.projects = []
      this.$awn.asyncBlock(global.$post("/Campaign/category_list", {}, ""))
        .then(response => {
          this.getSearchItems()
          for (var i in response.data.MSG)
            if (response.data.MSG[i].id == id)
              this.category = response.data.MSG[i]
        })
        .catch(err => {})
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/projects.scss";
</style>
