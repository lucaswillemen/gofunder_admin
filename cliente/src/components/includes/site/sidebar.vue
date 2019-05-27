<template>
<div class="my-sidebar">
  <p class="title mt-0">Pesquisa Avançada</p>
  <div class="level0">
    <b-label v-b-toggle.collapse1 variant="primary">Tipo de Projeto</b-label>
  </div>
  <b-collapse visible id="collapse1" class="level1 mt-1">
    <p><a @click="changeType('all');" style="cursor:pointer;">Todos</a></p>
    <p><a @click="changeType('funding');" style="cursor:pointer;">Funding</a></p>
    <p><a @click="changeType('marketplace');" style="cursor:pointer;">Marketplace</a></p>
  </b-collapse>
  <div class="level0 mt-5">
    <b-label v-b-toggle.collapse2 variant="primary">Categorias</b-label>
  </div>
  <b-collapse visible id="collapse2" class="level1 mt-1">
    <p v-for="(item, index) in categories" :key="index"><a @click="changeCategory(item.id)" style="cursor:pointer">{{'HOME::'+item.name | fix}}</a></p>
  </b-collapse>
  <!--
		<small>Publicidade</small>
<b-img class="publicity" :scr="publicity"></b-img>
  <div class="publicity" v-bind:style="{ backgroundImage: 'url(' + publicity  + ')' }"></div>
  !-->
</div>
</template>

<script>
export default {
  data() {
    return {
      categories: []
    }
  },
  methods: {
    getCategories() {
      global.$get("/Campaign/option")
      .then(response => {
        this.categories = response.data.category
      })
      .catch(err => {
        this.$awn.alert("Ocorreu um erro ao resgatar as informações das categorias!")
      })
    },
    changeCategory(category) {
      this.$emit('changeCategory', category)
    },
    changeType(type) {
      this.$emit('changeType', type)
    }
  },
  mounted() {
    this.getCategories()
  },
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.my-sidebar {

    $font: 19px;

    .title {
        font-size: $font;
        font-weight: 600;
        color: $blue;
        margin-top: 25px;
    }

    .level0 {

        border-bottom: 1px dotted $blue;
        padding: 3px 0;

        b-label {
            font-size: $font - 2;
            color: $blue;
            font-weight: 500;
        }

    }
    .level1 {

        p {
            margin-bottom: 5px;
            margin-left: 15px;
            border-bottom: 1px dotted $orange;

            a {
                font-size: $font - 6;
                color: $orange;
            }
            a:hover {
                text-decoration: none!important;
            }
        }

    }

    .custom-checkbox {
        .custom-control-label::before {
            border-radius: 11px;
            border: 1px solid $orange;
            background-color: transparent;
        }

        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: $orange;
        }
    }

    .checkboxes {
        span {
            font-size: $font - 6;
            font-weight: 500;
            color: $blue;
        }
    }

    .publicity {
        height: 150px;
        width: 100%;
    }
}

@media only screen and (max-width: 768px) {}
</style>
