<template class=" md-grutter">
  <div class="md-layout md-grutter">
    <div v-for="(campaing, index) in campaings" :key="index" class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25"> 
      <md-card>
        <md-card-area md-inset>
          <md-card-media md-ratio="16:9">
            <img :src="'http://25.20.118.56/gofunder/'+campaing.cover_url">
          </md-card-media>

          <md-card-header>
            <h2 class="md-title">{{campaing.title}}</h2>
            <div class="md-subhead">
              <md-icon>group</md-icon>
              <span>{{campaing.number_of_investor}} investidores</span>

            </div>
          </md-card-header>

          <md-card-content>
            {{campaing.description}}
          </md-card-content>
        </md-card-area>

        <md-card-content>
          <h3 class="md-subheading">Progresso</h3>
          <div class="card-reservation">
            <div class="md-button-group md-layout md-alignment-center-center">
              <md-button class="md-layout-item">${{campaing.arrecadation}}</md-button>de
              <md-button class="md-layout-item">${{campaing.amount}}</md-button>
            </div>
          </div>
          <md-progress-bar md-mode="determinate" :md-value="(campaing.arrecadation/campaing.amount)*100"></md-progress-bar>
        </md-card-content>

        <md-card-actions>
          <md-button class="md-primary"><md-icon>list</md-icon> Detalhes</md-button>
           <router-link :to="'/edit/'+campaing.id"><md-button class="md-primary" ><md-icon>edit</md-icon> Editar</md-button></router-link>
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
      campaings: [],

    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {
    listCampaings() {
      global.$get("/Campaing/getList?user_id="+this.user.id, {}, this.user.token)
        .then(response => {
            this.campaings = response.data
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
    }
  },
  mounted() {
    this.listCampaings()
  }
}
</script>

