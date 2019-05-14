<template>
	<div>
		<div id="toolbar-container"></div>
		<div id="editor" ref="editorHTMLref"></div>
	</div>
</template>

<script>
export default {
	name: "VueCkeditor",
	props: ["htmlCampaign"],
	methods: {
		getValue() {
			let el = document.querySelector("#editor");
			return el ? el.innerHTML : null;
		},
		loadCKEditor() {
			DecoupledEditor.create(document.querySelector("#editor"), {
				extraPlugins: [
					editor => {
						editor.plugins.get(
							"FileRepository"
						).createUploadAdapter = loader => {
							return new interceptUploadAdapter(loader);
						};
					}
				]
			}).then(editor => {
				editor.model.document.on("change", () => {
					this.$emit("changeHtmlValue", editor.getData());
				});
				editor.setData(this.htmlCampaign);
				const toolbarContainer = document.querySelector("#toolbar-container");
				toolbarContainer.appendChild(editor.ui.view.toolbar.element);
			});
		}
	},
	watch: {
		htmlCampaign: function(newvalue, oldvalue) {
			if (oldvalue == null) {
				console.log("carregou o ckeditor", oldvalue);
				this.loadCKEditor();
			}
		}
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
						});
					});
					xhr.addEventListener("progress", evt => {
						this.progress(evt);
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
}
</script>
