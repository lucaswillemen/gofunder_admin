<template>
<div>
  <main-header></main-header>
  <div class="projects">
    <div class="header" :style="{ backgroundImage: 'url(' + bgHeader + ')' }">
      <div class="container">

        <div class="title center-obj-v">
          <i style="color:#a3640d; font-size:54px;" class="material-icons">{{headerIcon.icon_name}}</i> <span>{{"HOME::"+headerIcon.name | fix}}</span>
        </div>
      </div>
    </div>
    <div class="body">
      <div class="top">
        <div class="container">
          <b-row>
            <b-col lg="3" sm="12"></b-col>
            <b-col lg="9" sm="12">
              <div class="input-search" >
                <b-form-input v-model="searchInput" @keyup.enter="searchProject()" type="text" placeholder="Digite o que procura aqui" class="in-border-transp mt-2">
                </b-form-input>
                <font-awesome-icon @click="searchProject()" icon="search" class="icon-search"/>
              </div>
              <div class="select-order">
                <b-dropdown id="ddown2" text="Ordenar Por" class="m-md-2 fullwi btn-noborder-transp lbl-on-corner no-radius-right" style="">
                  <b-dropdown-item @click="changeOrder('relevance')">Relevância</b-dropdown-item>
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
              <sidebar @changeCategory="changeCategory" @changeType="changeType"></sidebar>
            </b-col>
            <b-col lg="9">
              <project-card :projects="projects"></project-card>
              <div class="btn-showmore btn-border">
                <b-button :click='newPage()'>Mostrar mais</b-button>
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
import {mapState} from 'vuex'
export default {
  data() {
    return {
      currentPage: 0,
      searchInput: null,
      ordenation: 'relevance',
      activeType: 'funding',
      activeCategory: 0,
      iconHeader: require('Img/telefone.png'),
      bgHeader: require('Img/projetos/bg-header.png'),
      headerIcon: {
        icon_name: "search",
        name: "Procurar projetos",
        id: 0
      },
      categories: [],
      projects: []
    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {
    searchProject() {
      global.$post("/Campaign/search", {type: this.activeType, category: this.activeCategory, name: this.searchInput, orderBy: this.ordenation, page: this.currentPage }, this.user.token)
      .then(response => {
        this.projects = response.data
      })
      .catch(err => {
        this.$awn.alert("Ocorreu um erro ao resgatar as informações das categorias!")
      })
    },
    newPage() {

    },
    changeOrder(order) {
      this.ordenation = order
      this.projects = []
      // this.searchProject()
    },
    changeType(type) {
      if(type !== this.activeType) {
        this.activeType = type
        this.projects = []
        this.searchProject()
      }
    },
    changeCategory(category) {
      this.activeCategory = category.id
      this.headerIcon = category
      this.projects = []
      // this.searchProject()
    }
  },
  mounted() {
  },
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/projects.scss";
</style>