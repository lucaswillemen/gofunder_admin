<template>
<div class="table">
    <table class="table">
      <thead>
        <tr>
          <th v-for="(item, index) in items[0]">{{index}}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items">
          <td  v-for="col in item" v-html="col"></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
    }
  },
  props: ['items', 'html', 'campos'],
  mounted() {

  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

table {
    background-color: rgba(0, 0, 0, 0.0)!important;
    border-collapse: separate;
    border-spacing: 0;

    thead {
        th {
            border-top: none!important;
            border-bottom: none!important;
            padding-left: 25px!important;
            font-size: 13px;
            font-weight: 600;
            color: $blue;
        }
    }
    tbody {
        td {
            border-bottom: none!important;
            padding-left: 25px!important;
            font-size: 12px;
            color: gray;
            font-weight: 400;
        }
    }
    .acoes {
        font-weight: 500;
    }
    .separator {
        padding: 0 5px;
    }
}

@media only screen and (max-width: 768px) {
    .table {
        overflow-x: scroll;
    }

}
</style>
