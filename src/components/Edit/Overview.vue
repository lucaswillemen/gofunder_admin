<template>
	<div class="md-layout md-grutter md-alignment-center-center maxHeight">
		<md-dialog-alert
			:md-active.sync="dadosSalvos"
			md-content="Os dados iniciais da sua campanhas foram salvos!"
			md-confirm-text="Ok"
		/>

		<div class="md-layout-item md-small-size-100 md-size-100">
			<md-card>
				<md-empty-state
					md-icon="card_giftcard"
					md-label="Informações Básicas"
					md-description="Nessa guia você irá alterar configurações básicas para sua campanha! Avance para os próximos itens para editar mais informações"
				></md-empty-state>
				<md-card-content>
					<md-field :class="{'md-invalid': $v.title.$invalid && $v.title.$dirty}">
						<md-icon class="mdi mdi-card-text"></md-icon>
						<label for="campaignTitle">Titulo da campanha: *</label>
						<md-input id="campaignTitle" v-model="campaign.title"></md-input>
						<span class="md-error" v-if="!$v.title.required">Seu titulo da campanha é obrigatório</span>
					</md-field>

					<md-field :class="{'md-invalid': $v.title.$invalid && $v.title.$dirty}">
						<md-icon class="mdi mdi-text"></md-icon>
						<label for="campaignDesc">Descrição da campanha: *</label>
						<md-input id="campaignDesc" v-model="campaign.description"></md-input>
						<span class="md-error" v-if="!$v.title.required">A descrição da campanha é obrigatório</span>
					</md-field>

					<md-field>
						<md-icon class="mdi mdi-instagram"></md-icon>
						<label>Perfil do Instagram</label>
						<md-input v-model="campaign.instagram_page"></md-input>
					</md-field>
					<md-field>
						<md-icon class="mdi mdi-facebook"></md-icon>
						<label>Perfil do Facebook</label>
						<md-input v-model="campaign.facebook_page"></md-input>
					</md-field>
					<md-field>
						<md-icon class="mdi mdi-youtube"></md-icon>
						<label>Canal do Youtube</label>
						<md-input v-model="campaign.youtube_page"></md-input>
					</md-field>

					<br>
					<br>

					<label for="campaignHtml" style="opacity:0.9;">Conteúdo informativo da campanha: *</label>
	
					<ckeditor :editor="editor" v-model="campaign.html" :config="editorConfig"></ckeditor>
				</md-card-content>

				<md-card-actions>
					<md-button class="md-primary md-raised" @click="saveCampaign()">Salvar modificações</md-button>
				</md-card-actions>
			</md-card>
		</div>
	</div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { required, numeric } from "vuelidate/lib/validators";
import { mapState } from "vuex";

export default {
	computed: {
		...mapState(["user"])
	},
	validations: {
		title: { required }
	},
	methods: {
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
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				});
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
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				});
		}
	},
	data() {
		return {
			dadosSalvos: false,
			parentCall: null,
			editorData: null,
			campaign: {
				title: "",
				description: "",
				html: "",
				youtube_page: "",
				instagram_page: "",
				facebook_page: ""
			},
			editor: ClassicEditor,
			editorConfig: {
				extraPlugins: [
					editor => {
						editor.plugins.get(
							"FileRepository"
						).createUploadAdapter = loader => {
							return new interceptUploadAdapter(loader);
						};
					}
				]
			}
		};
	},
	mounted() {
		this.loadCampaign();
	}
};

class interceptUploadAdapter {
	constructor(loader) {
		this.loader = loader;
		this.endpoint = "http://25.20.68.69/";
	}
	upload() {
		return this.loader.file.then(
			file =>
				new Promise((resolve, reject) => {
					const xhr = (this.xhr = new XMLHttpRequest());
					xhr.open("POST", this.endpoint + "index.php?/Image/send", true);
					xhr.responseType = "json";

					const data = new FormData();
					data.append("upload", file);
					xhr.send(data);

					xhr.addEventListener("error", () => alert("genericErrorText"));
					xhr.addEventListener("abort", () => alert());
					xhr.addEventListener("load", () => {
						const response = xhr.response;
						if (!response || response.error) {
							// alert pra quando não conseguir enviar mensagem
							return false;
						}
						resolve({
							default: this.endpoint + response.url
						})
					})
					xhr.addEventListener("progress", evt => {
						this.progress(evt);
					})
				})
		);
	}
	abort() {
		if (this.xhr) {
			this.xhr.abort();
		}
	}
	progress(evt) {
		if (evt.lengthComputable) {
			this.loader.uploadTotal = evt.total;
			this.loader.uploaded = evt.loaded;
		}
	}
}
</script>

<style>
.md-empty-state-container > i {
	font-size: 70px !important;
}
.md-empty-state-icon {
	height: 70px !important;
}
</style>
