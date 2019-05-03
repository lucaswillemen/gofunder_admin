<template>
<div class="my-sidebar">
  <small>Rascunho</small>
  <p class="title mt-0">{{campaing}}</p>
  <div class="level0">
    <span variant="primary">Editor Campanha</span>
  </div>
  <b-collapse visible id="submenu1" class="level1 mt-1">
    <p>
      <a :href="'/#/user/campaing/edit/'+this.$route.params.id">Geral</a>
    </p>
    <p>
      <a :href="'/#/user/campaing/content/'+this.$route.params.id">Conteúdo</a>
    </p>
    <p>
      <a :href="'/#/user/campaing/reward/'+this.$route.params.id">Recompensas</a>
    </p>
    <p>
      <a :href="'/#/user/campaing/publish/'+this.$route.params.id">Publicar Campanha</a>
    </p>
  </b-collapse>

</div>
</template>

<script>
import {
  mapState,
  mapActions
} from 'vuex'
export default {
	computed: {
		...mapState(['user'])
	},
  mounted() {
    this.$awn.asyncBlock(global.$post("/Campaign/info", {
        id: this.$route.params.id
      }, this.user.token))
      .then(response => {
        this.campaing = response.data.MSG.title
        if(response.data.MSG.status !== 'draft') {
          location.href = "/#/project-info/"+this.$route.params.id
          this.$awn.alert("Sua campanha já foi lançada")
        }
      })
      .catch(err => {
        location.href = "/"
      })
  },
  data() {
    return {
      campaing: ""
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
        color: $orange;
        margin-top: 25px;
    }
    .level0 {
        border-bottom: 1px dotted $blue;
        padding: 3px 0;
        cursor: pointer;
        span {
            font-size: $font - 2;
            color: $blue;
            font-weight: 500;
        }
    }
    .level1 {
        cursor: pointer;
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

}

@media only screen and (max-width: 768px) {}
</style>
