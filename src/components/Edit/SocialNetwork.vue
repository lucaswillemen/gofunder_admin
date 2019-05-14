<template>
  <main>
  	<div class="md-layout-item md-small-size-100 md-size-100">
      <md-card>
        <md-card-header>
          <div class="md-title">Perfil de redes sociais</div>
        </md-card-header>
        <md-card-content>
          <md-field>
            <md-icon class="mdi mdi-instagram"></md-icon>
            <label>Perfil do Instagram</label>
            <md-input v-model="social.instagram"></md-input>
          </md-field>
          <md-field>
            <md-icon class="mdi mdi-facebook"></md-icon>
            <label>Perfil do Facebook</label>
            <md-input v-model="social.facebook"></md-input>
          </md-field>
          <md-field>
            <md-icon class="mdi mdi-youtube"></md-icon>
            <label>Canal do Youtube</label>
            <md-input v-model="social.youtube"></md-input>
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button class="md-primary md-raised" @click="saveSocial()" >
            Salvar
          </md-button>
        </md-card-actions>
      </md-card>
    </div>
  
  </main>
</template>

<script>
import {mapState} from 'vuex'
export default {
	data() {
    return {
      social: {
			  parentCall: null,
				instagram: null,
				facebook: null,
				youtube: null
			},
    }
  },
  computed: {
  ...mapState(['user'])
  },
  methods: {
    saveSocial() {
			let data = {
				facebook: this.social.instagram,
				instagram: this.social.facebook,
				youtube: this.social.youtube,
				campaign_id: this.$route.params.id
			};
			global
				.$post("/Content/updatesocial", data, this.user.token)
				.then(res => {
					console.log(res);
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {});
		}
  },
  mounted() {
		this.parentCall = this.$parent.$parent.$parent.$parent

  }
}
</script>

<style>
.md-empty-state-container > i {
	font-size:70px!important;
}
.md-empty-state-icon {
	height:70px!important;
}
</style>
