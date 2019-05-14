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
<!-- 
              <md-card-actions v-if="campaign.status == 0">
                <router-link :to="'/edit/'+campaign.id">
                  <md-button class="md-primary">
                    <md-icon>edit</md-icon>Editar
                  </md-button>
                </router-link>
                <md-button class="md-primary">
                  <md-icon>send</md-icon>Publicar
                </md-button>
              </md-card-actions> -->
            </md-card>
          </div>
        </div>
      </md-tab>
      <md-tab id="tab-rascunhos" md-label="Rascunhos" md-icon="create">
        <div class="md-layout md-grutter">
          <div v-for="(campaign, index) in rascunhos" :key="index" class="md-layout-item md-size-100 md-medium-size-50 md-large-size-33 md-xlarge-size-25">
            <md-card>
              <md-card-actions class="overlap-btn">
                <md-button class="md-fab md-mini" @click="openDeleteConfirmation(campaign.id)">
                  <md-icon>delete</md-icon>
                </md-button>
              </md-card-actions>
              <md-card-area md-inset>
                <md-card-media md-ratio="16:9">
                  <img
                    :src="$url +campaign.cover_url"
                    onerror="this.src='https://via.placeholder.com/150'"
                  >
                </md-card-media>


                <md-card-header>
                  <h2 class="md-title">{{campaign.title}}</h2>
                </md-card-header>

                <md-card-content>{{campaign.description}}</md-card-content>
              </md-card-area>


              <md-card-actions>
                <router-link :to="'/edit/'+campaign.id">
                  <md-button class="md-primary" style="color: rgba(0,0,0,0.87) !important">
                    <md-icon>edit</md-icon>Editar
                  </md-button>
                </router-link>
                <md-button class="custom-color-2">
                  <md-icon>find_in_page</md-icon>Prévia
                </md-button>
                <md-button class="custom-color">
                  <md-icon>send</md-icon>Publicar
                </md-button>
              </md-card-actions>
            </md-card>
          </div>
        </div>
      </md-tab>
      <md-tab id="tab-analise" md-label="Em Análise" md-icon="timeline">
        <div class="md-layout md-grutter">
          <div v-for="(campaign, index) in analysis" :key="index" class="md-layout-item md-size-100 md-medium-size-50 md-large-size-33 md-xlarge-size-25">
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
                </md-card-header>

                <md-card-content>{{campaign.description}}</md-card-content>
              </md-card-area>
            </md-card>
          </div>
        </div>
      </md-tab>
    </md-tabs>
    <md-dialog-confirm
			:md-active.sync="showDeleteConfirmation"
			md-title="Tem certeza que deseja deletar esta camapanha?"
			md-content="Ao clicar em 'OK', não será possível recuperar nenhum dos dados já cadastrados nessa campanha."
			md-confirm-text="Ok"
			md-cancel-text="Fechar"
			@md-cancel="showDeleteConfirmation = false"
			@md-confirm="deleteCampaign()"
		/>
  </main>

</template>
<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      campaignIdToDelete: null,
      showDeleteConfirmation: false,
      loading: false,
      lancadas: [],
      rascunhos: [],
      analysis: [],
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
          console.log(response.data)
          response.data.forEach(element => {
            if(element.status == 'approved')
              this.lancadas.push(element)
            if(element.status == 'draft')
              this.rascunhos.push(element)
            if(element.status.includes('pending')) {
              this.analysis.push(element)
            }
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
    },
    openDeleteConfirmation(id) {
      this.campaignIdToDelete = id
      this.showDeleteConfirmation = true
    },
    deleteCampaign() {
      alert('deletado, id:' + this.campaignIdToDelete)
    }
  },
  mounted() {
    this.listCampaigns();
  }
};
</script>
<style lang="scss" scoped>
.overlap-btn {
	position: absolute;
	right: 0;
}
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
.md-card-actions.md-alignment-right {
  i {
    font-size: 23px !important;
  }
}
.custom-color {
  .md-icon.md-icon-font.md-theme-default{
    color: #31a235;
  }
}
.custom-color-2 {
  .md-icon.md-icon-font.md-theme-default{
    color: #244584;
  }
}
</style>

