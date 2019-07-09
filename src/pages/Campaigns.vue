<template>
  <main>
    <md-dialog-alert :md-active.sync="alertError" :md-title="$f('CAMPAIGN::Erro!')" :md-content="alertErrorMsg" />
    <div class="loading-overlay" v-if="loading">
      <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
    </div>
    <md-tabs class="md-primary">
      <md-tab id="tab-lancadas" :md-label="$f('CAMPAIGN::Lançadas')" md-icon="check_circle">
        <div class="md-layout md-grutter">
          <div v-if="lancadas.length == 0">
            <h2>Você não possui campanhas lançadas</h2>
          </div>
          <card-items v-else :items="lancadas" :hideDelete="true" hideFooter="true">
            <template v-slot:body="itemProp">
              <div class="item-body">
                <div class="item-title">
                  <h2>{{itemProp.item.title}}</h2>
                </div>
                <div class="md-subhead">
                  <md-icon>group</md-icon>
                  <span>{{itemProp.item.number_of_investor}} {{"CAMPAIGN::investidores" | fix}}</span>
                </div>
                <div class="item-description" style="margin-top: 1rem;">
                  <p>{{itemProp.item.description}}
                  </p>
                </div>
                <h3 class="md-subheading" style="margin-bottom: 0">{{"CAMPAIGN::Progresso" | fix}}</h3>
                <div class="card-reservation">
                  <div class="md-button-group md-layout md-alignment-center-center">
                    <md-button class="md-layout-item">${{itemProp.item.arrecadation}}</md-button>de
                    <md-button class="md-layout-item">${{itemProp.item.amount}}</md-button>
                  </div>
                </div>
                <md-progress-bar
                  md-mode="determinate"
                  :md-value="(itemProp.item.arrecadation/itemProp.item.amount)*100"
                ></md-progress-bar>
              </div>
            </template>
          </card-items>
        </div>
      </md-tab>
      <md-tab id="tab-rascunhos" :md-label="$f('CAMPAIGN::Rascunhos')" md-icon="create">
      <div v-if="rascunhos.length == 0">
        <h2>Você não possui campanhas em rascunho</h2>
      </div>
      <card-items :items="rascunhos"></card-items>
      </md-tab>
      <md-tab id="tab-analise" :md-label="$f('CAMPAIGN::Em Análise')" md-icon="timeline">
      <div v-if="analysis.length == 0">
        <h2>Você não possui campanhas em análise</h2>
      </div>
      <card-items :items="analysis" hideDelete="true" hideFooter="true"></card-items>

        <!-- <div class="md-layout md-grutter">
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
        </div> -->
      </md-tab>
    </md-tabs>
    <md-dialog-confirm
			:md-active.sync="showDeleteConfirmation"
			:md-title="$f('CAMPAIGN::Tem certeza que deseja deletar esta campanha?')"
			:md-content="$f('CAMPAIGN::Ao clicar em \'OK\', não será possível recuperar nenhum dos dados já cadastrados nessa campanha.')"
			:md-confirm-text="$f('COMMON::Ok')"
			:md-cancel-text="$f('COMMON::Fechar')"
			@md-cancel="showDeleteConfirmation = false"
			@md-confirm="deleteCampaign()"
		/>
  </main>

</template>
<script>
import CardItems from '@/components/CardItems'
import { mapState } from "vuex";
export default {
  components: {
    CardItems
  },
  data() {
    return {
      alertError: false,
    	alertErrorMsg: null,
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
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
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
      //deletar campanha codigo
      alert("Deletar campanha ainda não implementado")
    }
  },
  mounted() {
    this.listCampaigns();
  }
};
</script>
<style lang="scss" scoped>
// .cards-container {
//   display: flex;
//   flex-wrap: wrap;
//   // display: grid;
//   // grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
//   // grid-gap: 20px;
//   @media (max-width: 679px) {
//     justify-content: center;
//   }

//   .card-container {
//     box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);
//     margin-top: 1rem;
//     margin-right: 1rem;
//     display: flex;
//     flex-direction: column;
//     background-color: white;
//     // margin-bottom: 1rem;
//     width: 350px;
//     @media (max-width: 330px) {
//       width: 295px;
//       margin-right: 0;
//     }
//     .img-container {
//       position: relative;
//       img {
//         width: 100%;
//         height: 225px;
//       }
//       .delete-btn {
//         position: absolute;
//          right: 0;
//       }
//     }
//     .campaign-body {
//       display: flex;
//       flex-direction: column;
//       flex-wrap: wrap;
//       padding: 1rem;
//       .campaign-title {
//         h2 {
//           font-weight: 500;
//         }
//       }
//       .campaign-description {
//         p {
//           margin: 0;
//         }
//       }
//     }
//     .campaign-footer {
//       display: flex;
//       position: relative;
//       margin-top: auto; 
//       justify-content: center;
//       &::before {
//         position: absolute;
//         content: '';
//         border-bottom: 1px solid rgba(0,0,0,0.12);;
//         width: 90%;
//         transform: translateX(-50%);
//         left: 50%;
//       }
//     }
//   }
// }

// .campaign-container {
//   .card-container {
//     margin-bottom: 1.5rem;
//   }
//   .overlap-btn {
//     position: absolute;
//     right: 0;
//   }
// }

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
// .md-card-actions.md-alignment-right {
//   i {
//     font-size: 23px !important;
//   }
// }
</style>

