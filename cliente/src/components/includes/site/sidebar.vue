<template>
<div class="my-sidebar">
  <p class="title mt-0">Pesquisa Avançada</p>
  <div class="level0">
    <b-label v-b-toggle.collapse1 variant="primary">Tipo de Projeto</b-label>
  </div>
  <b-collapse visible id="collapse1" class="level1 mt-1">
    <p><a @click="$parent.changeType('all');" style="cursor:pointer;">Todos</a></p>
    <p><a @click="$parent.changeType('funding');" style="cursor:pointer;">Funding</a></p>
    <p><a @click="$parent.changeType('marketplace');" style="cursor:pointer;">Marketplace</a></p>
  </b-collapse>
  <div class="level0 mt-5">
    <b-label v-b-toggle.collapse2 variant="primary">Categorias</b-label>
  </div>
  <b-collapse visible id="collapse2" class="level1 mt-1">
    <p v-for="item in campaignsCategory"><a @click="$parent.getCategory(item.id)" style="cursor:pointer">{{item.name}}</a></p>
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
  mounted() {
    this.$awn.asyncBlock(global.$post("/Campaign/category_list", {}))
      .then(response => {
        this.campaignsCategory = response.data.MSG
      })
      .catch(err => {})
  },
  data() {
    return {
      campaignsCategory: []
    }
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
