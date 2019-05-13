<template>
  <main>
    <div class="md-layout md-grutter md-alignment-center-center">
      <md-card style="min-width: 50%">
        <md-card-header>
          <div class="md-title">Social networks profiles</div>
        </md-card-header>
        <md-card-content>
          <md-field>
            <md-icon class="mdi mdi-instagram"></md-icon>
            <label>Instagram profile</label>
            <md-input v-model="social.instagram"></md-input>
          </md-field>
          <md-field>
            <md-icon class="mdi mdi-facebook"></md-icon>
            <label>Facebook profile</label>
            <md-input v-model="social.facebook"></md-input>
          </md-field>
          <md-field>
            <md-icon class="mdi mdi-youtube"></md-icon>
            <label>Youtube channel</label>
            <md-input v-model="social.youtube"></md-input>
          </md-field>
        </md-card-content>
      </md-card>
    </div>
    <div class="md-layout md-grutter md-alignment-center">
      <md-button @click="saveSocial()" class="md-fab md-primary" style="background:green">
        <md-icon>save</md-icon>
      </md-button>
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

</style>
