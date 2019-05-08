<template class=" md-grutter">
  <div class="md-layout md-grutter">
    <div v-for="(campaign, index) in campaigns" :key="index" class="md-layout-item md-size-100 md-medium-size-50 md-large-size-33 md-xlarge-size-25"> 
      <md-card>
        <md-card-area md-inset>
          <md-card-media md-ratio="16:9">
            <img :src="'http://25.20.118.56/gofunder/'+campaign.cover_url">
          </md-card-media>

          <md-card-header>
            <h2 class="md-title">{{campaign.title}}</h2>
            <div class="md-subhead">
              <md-icon>group</md-icon>
              <span>{{campaign.number_of_investor}} investidores</span>

            </div>
          </md-card-header>

          <md-card-content>
            {{campaign.description}}
          </md-card-content>
        </md-card-area>

        <md-card-content>
          <h3 class="md-subheading">Progresso</h3>
          <div class="card-reservation">
            <div class="md-button-group md-layout md-alignment-center-center">
              <md-button class="md-layout-item">${{campaign.arrecadation}}</md-button>de
              <md-button class="md-layout-item">${{campaign.amount}}</md-button>
            </div>
          </div>
          <md-progress-bar md-mode="determinate" :md-value="(campaign.arrecadation/campaign.amount)*100"></md-progress-bar>
        </md-card-content>

        <md-card-actions>
          <md-button class="md-primary"><md-icon>list</md-icon> Detalhes</md-button>
           <router-link :to="'/edit/'+campaign.id"><md-button class="md-primary" ><md-icon>edit</md-icon> Editar</md-button></router-link>
        </md-card-actions>
    </md-card> 
  </div>
</div>
</template>
<script>
import {mapState} from 'vuex'
export default {
  data() {
    return {
      campaigns: [],

    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {
    listCampaigns() {
      global.$get("/campaign/getList?user_id="+this.user.id, {}, this.user.token)
        .then(response => {
            this.campaigns = response.data
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
    }
  },
  mounted() {
    this.listCampaigns()
  }
}
</script>

