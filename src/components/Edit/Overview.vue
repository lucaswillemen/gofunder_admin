<template>
	<div class="md-layout md-grutter md-alignment-center-center maxHeight">
		<md-dialog-alert :md-active.sync="alertError" :md-title="$f('OVERVIEW::Erro!')" :md-content="alertErrorMsg" />
		<md-dialog-alert
			:md-active.sync="dadosSalvos"
			:md-content="$f('OVERVIEW::Os dados iniciais da sua campanhas foram salvos!')"
			:md-confirm-text="$f('COMMON::Ok')"
		/>
		<div class="md-layout-item md-small-size-100 md-size-100">
			<md-card>
				<md-empty-state
					md-icon="card_giftcard"
					:md-label="$f('OVERVIEW::Informações Básicas')"
					:md-description="$f('OVERVIEW::Nessa guia você irá alterar configurações básicas para sua campanha! Avance para os próximos itens para editar mais informações')"
				></md-empty-state>
				<md-card-content>
					<div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
							<md-field :class="{'md-invalid': $v.title.$invalid && $v.title.$dirty}">
								<md-icon class="mdi mdi-card-text"></md-icon>
								<label for="campaignTitle">{{"OVERVIEW::Titulo da campanha:" | fix}} *</label>
								<md-input id="campaignTitle" v-model="campaign.title"></md-input>
								<span class="md-error" v-if="!$v.title.required">{{"OVERVIEW::Seu titulo da campanha é obrigatório" | fix}}</span>
							</md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
							<md-field :class="{'md-invalid': $v.title.$invalid && $v.title.$dirty}">
								<md-icon class="mdi mdi-text"></md-icon>
								<label for="campaignDesc">{{"OVERVIEW::Descrição da campanha:" | fix}} *</label>
								<md-input id="campaignDesc" v-model="campaign.description"></md-input>
								<span class="md-error" v-if="!$v.title.required">{{"OVERVIEW::A descrição da campanha é obrigatório" | fix}}</span>
							</md-field>
            </div>
					</div>
					<div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
							<md-field>
								<md-icon class="mdi mdi-instagram"></md-icon>
								<label>{{"OVERVIEW::Perfil do Instagram" | fix}}</label>
								<md-input v-model="campaign.instagram_page"></md-input>
							</md-field>
            </div>
            <div class="md-layout-item md-small-size-100">

							<md-field>
								<md-icon class="mdi mdi-facebook"></md-icon>
								<label>{{"OVERVIEW::Perfil do Facebook" | fix}}</label>
								<md-input v-model="campaign.facebook_page"></md-input>
							</md-field>
            </div>
            <div class="md-layout-item md-small-size-100">

							<md-field>
								<md-icon class="mdi mdi-youtube"></md-icon>
								<label>{{"OVERVIEW::Canal do Youtube" | fix}}</label>
								<md-input v-model="campaign.youtube_page"></md-input>
							</md-field>
						</div>
						<div class="md-layout-item md-small-size-100">
							<md-field>
								<md-icon class="mdi mdi-linkedin"></md-icon>
								<label>{{"OVERVIEW::Perfil do Linkedin" | fix}}</label>
								<md-input v-model="campaign.linkedin_page"></md-input>
							</md-field>
						</div>
					</div>


					<br>
					<br>
					<label for="campaignHtml" style="opacity:0.9;">{{"OVERVIEW::Conteúdo informativo da campanha:" | fix}} *</label>
				<!--	<VueCkeditor @changeHtmlValue="changeHtml" :htmlCampaign="campaign.html"></VueCkeditor>!-->
				<editor api-key="d982mabgtf21gq12p8992913q3pvqu3scbukpoxl623jdr9b"  :init="{}" v-model="campaign.html"></editor>
				</md-card-content>
				<md-card-actions>
					<md-button class="md-primary md-raised" @click="saveCampaign()">{{"OVERVIEW::Salvar modificações" | fix}}</md-button>
				</md-card-actions>
			</md-card>
		</div>
	</div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'
import { required, numeric } from "vuelidate/lib/validators";
import { mapState } from "vuex";

export default {
	components: {
		Editor
	},
	computed: {
		...mapState(["user"])
	},
	validations: {
		title: { required }
	},
	methods: {
		changeHtml(html) {
			this.campaign.html = html
		},
		loadCampaign() {
			global
				.$get(
					"/Campaign/getoverview?campaign_id=" + this.$route.params.id,
					{},
					this.user.token
				)
				.then(response => {
					this.campaign = response.data;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
		},
		saveCampaign() {
			global
				.$post(
					"/Campaign/saveoverview?campaign_id=" + this.$route.params.id,
					this.campaign,
					this.user.token
				)
				.then(response => {
					this.dadosSalvos = true;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
		}
	},
	data() {
		return {
			alertError: false,
    	alertErrorMsg: null,
			dadosSalvos: false,
			parentCall: null,
			editorData: null,
			campaign: {
				title: "",
				description: "",
				html: null,
				youtube_page: "",
				instagram_page: "",
				facebook_page: ""
			}
		};
	},
	mounted() {
		this.loadCampaign()
	}
};

</script>

<style>
.md-empty-state-container > i {
	font-size: 70px !important;
}
.md-empty-state-icon {
	height: 70px !important;
}
</style>
