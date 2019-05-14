<template>
  <main>
    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>
    <md-tabs class="md-primary">
      <md-tab id="tab-lancadas" md-label="Lançadas" md-icon="check_circle">
        <div class="md-layout md-grutter">
          <div v-for="(campaign, index) in lancadas" :key="index" class="md-layout-item md-size-100 md-medium-size-50 md-large-size-33 md-xlarge-size-25">
            <md-card>
              <md-card-area md-inset>
                <md-card-media md-ratio="16:9">
                  <img
                    :src="$url +campaign.cover_url"
                    onerror="this.src='https://via.placeholder.com/150'"
                  >
                </md-card-media>


                <md-card-header>
                  <h2 class="md-title">{{campaign.title}}</h2>
                  <div class="md-subhead">
                    <md-icon>group</md-icon>
                    <span>{{campaign.number_of_investor}} investidores</span>
                  </div>
                </md-card-header>

                <md-card-content>{{campaign.description}}</md-card-content>
              </md-card-area>

              <md-card-content>
                <h3 class="md-subheading">Progresso</h3>
                <div class="card-reservation">
                  <div class="md-button-group md-layout md-alignment-center-center">
                    <md-button class="md-layout-item">${{campaign.arrecadation}}</md-button>de
                    <md-button class="md-layout-item">${{campaign.amount}}</md-button>
                  </div>
                </div>
                <md-progress-bar
                  md-mode="determinate"
                  :md-value="(campaign.arrecadation/campaign.amount)*100"
                ></md-progress-bar>
              </md-card-content>

              <md-card-actions v-if="campaign.status == 0">
                <router-link :to="'/edit/'+campaign.id">
                  <md-button class="md-primary">
                    <md-icon>edit</md-icon>Editar
                  </md-button>
                </router-link>
                <md-button class="md-primary">
                  <md-icon>send</md-icon>Publicar
                </md-button>
              </md-card-actions>
            </md-card>
          </div>
        </div>
      </md-tab>
      <md-tab id="tab-rascunhos" md-label="Rascunhos" md-icon="create">
        <div class="md-layout md-grutter">
          <div v-for="(campaign, index) in rascunhos" :key="index" class="md-layout-item md-size-100 md-medium-size-50 md-large-size-33 md-xlarge-size-25">
            <md-card>
              <md-card-area md-inset>
                <md-card-media md-ratio="16:9">
                  <img
                    :src="$url +campaign.cover_url"
                    onerror="this.src='https://via.placeholder.com/150'"
                  >
                </md-card-media>


                <md-card-header>
                  <h2 class="md-title">{{campaign.title}}</h2>
                  <div class="md-subhead">
                    <md-icon>group</md-icon>
                    <span>{{campaign.number_of_investor}} investidores</span>
                  </div>
                </md-card-header>

                <md-card-content>{{campaign.description}}</md-card-content>
              </md-card-area>


              <md-card-actions v-if="campaign.status == 0">
                <router-link :to="'/edit/'+campaign.id">
                  <md-button class="md-primary">
                    <md-icon>edit</md-icon>Editar
                  </md-button>
                </router-link>
                <md-button class="md-primary">
                  <md-icon>send</md-icon>Publicar
                </md-button>
              </md-card-actions>
            </md-card>
          </div>
        </div>
      </md-tab>
    </md-tabs>
  </main>

</template>
<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      loading: false,
      lancadas: [],
      rascunhos: [],
    };
  },
  computed: {
    ...mapState(["user"])
  },
  methods: {
    listCampaigns() {
      this.loading = true;
      global
        .$get("/campaign/getList?user_id=" + this.user.id, {}, this.user.token)
        .then(response => {
          response.data.forEach(element => {
            if(element.status == 1)
              this.lancadas.push(element)
            else
              this.rascunhos.push(element)
          });
        })
        .catch(err => {
          let validErr =
            err && err.response && err.response.data && err.response.data.error;
          alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
          this.loading = false;
        })
        .finally(() => {
          this.loading = false;
        });
    }
  },
  mounted() {
    this.listCampaigns();
  }
};
</script>
<style lang="scss" scoped>
.loading-overlay {
  z-index: 10;
  top: 0;
  left: 0;
  right: 0;
  position: absolute;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

