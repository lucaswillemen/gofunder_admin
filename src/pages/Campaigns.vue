<template class=" md-grutter">
    <md-tabs>
      <md-tab id="tab-lancadas" md-label="Lançadas">
        <div class="md-layout md-grutter">
          <div v-if="lancadas.length == 0">
            <p>Nenhuma campanha lançada atualmente, finalize e publique algum de seus rascunhos para lançar...</p>
          </div>
          <div v-else v-for="(campaign, index) in lancadas" :key="index" class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25"> 
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
                    <md-button class="md-layout-item">{{campaign.arrecadation | currency}}</md-button>de
                    <md-button class="md-layout-item">{{campaign.amount | currency}}</md-button>
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
      </md-tab>
      <md-tab id="tab-rascunho" md-label="Rascunhos">
        <div class="md-layout md-grutter">
          <div v-for="(campaign, index) in rascunhos" :key="index" class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25"> 
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
                    <md-button class="md-layout-item">{{campaign.arrecadation | currency}}</md-button>de
                    <md-button class="md-layout-item">{{campaign.amount | currency}}</md-button>
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
      </md-tab>
    </md-tabs>
</template>
<script>
import {mapState} from 'vuex'
export default {
  data() {
    return {
      rascunhos: [],
      lancadas: []

    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {
    listCampaigns() {
      global.$get("/Campaign/getList?user_id="+this.user.id, {}, this.user.token)
        .then(response => {
          console.log(response)
            this.rascunhos = response.data.rascunho
            this.lancadas = response.data.lancadas

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

