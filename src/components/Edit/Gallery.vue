<template>
	<main>
		<div class="md-layout-item md-small-size-100 md-size-100">
			<md-card class="mt-layout-item">
				<md-empty-state
					md-icon="add_a_photo"
					md-label="Faça sua galeria!"
					md-description="As imagens serão mostradas na sua galeria de fotos da campanha!"
				>
					<input type="file" style="display: none" id="input-file" @change="pickImg($event)" accept="image/*">
					<md-button v-if="!imageToUpload" @click="clickOnFileInput()" class="md-fab md-primary" >
						<md-icon>add_a_photo</md-icon>
					</md-button>
				</md-empty-state>

				<md-card-content>
					<div class="flexBox">
						<div
							class="flexGallery"
							v-for="(picture, index) in pictures"
							:key="index"
							:style="{backgroundImage: 'url(\''+$url + picture.picture_url+'\')' }"
						>
							<md-button class="md-fab md-mini-mini" @click="openDeleteConfirmation(picture.id)">
								<md-icon>delete</md-icon>
							</md-button>
						</div>
					</div>
				</md-card-content>
			</md-card>
		</div>

		<md-dialog-confirm
			:md-active.sync="showDeleteConfirmation"
			md-title="Tem certeza que deseja deletar esta imagem da galeria?"
			md-content="Ao clicar em 'OK', não será possível recuperar a imagem deletada da galeria."
			md-confirm-text="Ok"
			md-cancel-text="Fechar"
			@md-cancel="showDeleteConfirmation = false"
			@md-confirm="deleteImage()"
		/>
	</main>
</template>

<script>
import { mapState } from "vuex";
export default {
	data() {
		return {
			alertError: false,
    	alertErrorMsg: null,
			picIdToDelete: null,
			showDeleteConfirmation: false,
			parentCall: null,
			imageToUpload: null,
			base64File: null,
			pictures: []
		};
	},
	computed: {
		...mapState(["user"])
	},
	methods: {
		loadGallery() {
			global
				.$get(
					"/Content/getgalery?campaign_id=" + this.$route.params.id,
					{},
					this.user.token
				)
				.then(response => {
					this.resetImgData();
					this.pictures = response.data;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
		},
		clickOnFileInput() {
			document.getElementById("input-file").click();
		},
		pickImg(evt) {
			let reader = new FileReader();
			this.imageToUpload = evt.target.files[0];
			reader.onload = e => {
				this.base64File = e.target.result;
			};
			reader.readAsDataURL(evt.target.files[0]);
			this.uploadNewImage();
		},
		uploadNewImage() {
			this.parentCall.showLoading();
			global
				.$post(
					"/Content/upload_gallery",
					{
						image: this.imageToUpload,				
						campaign_id: this.$route.params.id
					},
					this.user.token
				)
				.then(response => {
					this.loadGallery()
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
				.finally(() => {
					this.parentCall.hideLoading();
				});
		},
		openDeleteConfirmation(id) {
			this.picIdToDelete = id;
			this.showDeleteConfirmation = true;
		},
		deleteImage() {
			this.parentCall.showLoading();
			let data = {
				id: this.picIdToDelete
			};
			global
				.$post("/Content/deletegalery", data, this.user.token)
				.then(res => {
					this.loadGallery();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
				.finally(() => {
					this.parentCall.hideLoading();
				});
		},
		resetImgData() {
			this.imageToUpload = null;
			this.base64File = null;
			this.picIdToDelete = null;
		}
	},
	mounted() {
		this.loadGallery();
		this.parentCall = this.$parent.$parent.$parent;
	}
};
</script>


<style lang="scss" scoped>
.md-empty-state-container > i {
	font-size: 70px !important;
}
.md-empty-state-icon {
	height: 70px !important;
}
.md-mini-mini {

	right: 0px;
	height:30px;
	width:30px;
}
.flexBox {
	display:flex;
	width: 90%;
	margin: auto;
	flex-wrap: wrap;
}
.flexGallery {
	flex-basis: 9%;
  	margin: 5px;
	height: 90px !important;
	background-size: 100% 100% !important;

}
</style>