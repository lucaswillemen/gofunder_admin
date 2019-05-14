<template>
	<div class="md-layout md-grutter md-alignment-center-center maxHeight">
		<div class="md-layout-item md-small-size-100 md-size-100">
			<md-card>
				<md-card-content>
					<md-field :class="{'md-invalid': $v.title.$invalid && $v.title.$dirty}">
						<label for="campaignTitle">Titulo da campanha: *</label>
						<md-input id="campaignTitle" v-model="campaign.title"></md-input>
						<span class="md-error" v-if="!$v.title.required">Seu titulo da campanha é obrigatório</span>
					</md-field>

					<md-field :class="{'md-invalid': $v.title.$invalid && $v.title.$dirty}">
						<label for="campaignDesc">Descrição da campanha: *</label>
						<md-input id="campaignDesc" v-model="campaign.description"></md-input>
						<span class="md-error" v-if="!$v.title.required">A descrição da campanha é obrigatório</span>
					</md-field>

					<label for="campaignHtml">Conteúdo informativo da campanha: *</label>
					<ckeditor :editor="editor" v-model="campaign.overview" :config="editorConfig"></ckeditor>
				</md-card-content>

				<md-card-actions>
					<md-button class="md-primary md-raised" @click>Salvar modificações</md-button>
				</md-card-actions>
			</md-card>
		</div>
	</div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { required, numeric } from "vuelidate/lib/validators";
export default {
	validations: {
		title: { required }
	},
	data() {
		return {
			parentCall: null,
			editorData: null,

			campaign: {
				title: "",
				description: ""
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
	mounted() {}
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

					xhr.addEventListener("error", () => reject("genericErrorText"));
					xhr.addEventListener("abort", () => reject());
					xhr.addEventListener("load", xhr => {
						this.load(xhr);
					});
					xhr.addEventListener("progress", evt => {
						this.load(evt);
					});
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
	load(xhr) {
		const response = xhr.response;
		if (!response || response.error) {
			return reject(
				response && response.error
					? response.error.message
					: "Não foi possível enviar seu arquivo!"
			);
		}
		resolve({
			default: this.endpoint + response.url
		});
	}
}
</script>

<style>
</style>
