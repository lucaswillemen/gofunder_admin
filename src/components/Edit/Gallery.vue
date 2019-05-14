<template>
  <main>
    <span class="no-pic-message md-layout md-alignment-center-center" v-if="pictures.length == 0">
      <md-card class="mt-layout-item">
        <md-empty-state
          md-icon="add_a_photo"
          md-label="Adicione sua primeira imagem!"
          md-description="As imagens serão mostradas na sua galeria de fotos da campanha">
          <md-button class="md-primary md-raised" @click="showAddImg = true">Escolher Imagem</md-button>
        </md-empty-state>
      </md-card>
    </span>
    <div class="md-layout md-grutter" v-else>
      <div
        class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25"
        v-for="(picture, index) in pictures"
        :key="index"
      >
        <md-card>
          <md-card-actions>
            <md-button class="md-fab md-mini" @click="deleteImage(picture.id)">
              <md-icon>delete</md-icon>
            </md-button>
          </md-card-actions>
            <md-card-media md-ratio="1:1">
              <img v-if="picture.picture_url" :src="$url + picture.picture_url" onerror="this.src='https://via.placeholder.com/150'">
            </md-card-media>
            <md-card-content>
              <div class="image-description">
                <p>{{picture.name}}</p>
              </div>
            </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
        <br>
        <md-button
          :disabled="parentCall && parentCall.loadingState()"
          class="md-fab md-primary"
          @click="showAddImg = true"
          v-if="pictures.length != 0"
        >
          <md-icon>add</md-icon>
        </md-button>
      </div>
    </div>
    <md-dialog :md-active.sync="showAddImg">
      <md-dialog-title>Escolha uma imagem</md-dialog-title>
      <md-dialog-content>
        <input type="file" style="display: none" id="input-file" @change="pickImg($event)">
        <md-button v-if="!imageToUpload" @click="clickOnFileInput()" class="md-fab md-primary">
          <md-icon>add_a_photo</md-icon>
        </md-button>
        <div v-else class="dialog-picture">
          <img :src="base64File">
          <md-button @click="clickOnFileInput()" class="md-fab md-primary">
            <md-icon>add_a_photo</md-icon>
          </md-button>
        </div>
        <md-field v-if="imageToUpload" style="margin-top: 1rem;">
          <label>Insira a descrição da imagem</label>
          <md-input v-model="imgCaption" required maxlength="100"></md-input>
        </md-field>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button class="md-acent md-raised" @click="closeAddImgModal()">Close</md-button>
        <md-button
          :disabled="!imageToUpload || !imgCaption"
          class="md-primary md-raised"
          @click="uploadNewImage()"
        >Add</md-button>
      </md-dialog-actions>
    </md-dialog>
  </main>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {
			parentCall: null,
			pictureUrl: null,
			imageToUpload: null,
			base64File: null,
			imgCaption: null,
      showAddImg: false,
			pictures: []
    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {
    loadGallery() {
			global.$get("/Content/getgalery?campaign_id=" + this.$route.params.id, {}, this.user.token)
				.then(response => {
					this.pictures = response.data;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				});

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
		},
		uploadNewImage() {
			this.showAddImg = false;
			this.parentCall.showLoading()
			let data = {
				image: this.imageToUpload,
				title: this.imgCaption
			};
			global.$post("/Content/upload_gallery", data, this.user.token)
				.then(response => {
					this.pictureUrl = response.data.gallery_url;
					let data = {
						picture_url: this.pictureUrl,
						campaign_id: this.$route.params.id,
						legend: this.imgCaption
					};
					global.$post("/Content/addgalery", data, this.user.token)
						.then(res => {
							this.loadGallery();
						})
						.catch(err => {
							let validErr =
								err &&
								err.response &&
								err.response.data &&
								err.response.data.error;
							alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
						});
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
          this.parentCall.hideLoading();
				});
		},
		deleteImage(id) {
			this.parentCall.showLoading()
			let data = {
				id: id
			};
			global.$post("/Content/deletegalery", data, this.user.token)
				.then(res => {
					this.loadGallery();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
          this.parentCall.hideLoading();
				});
		},
		closeAddImgModal() {
			this.showAddImg = false;
			this.imageToUpload = null;
			this.base64File = null;
			this.imgCaption = null;
		},
  },
  mounted() {
    this.loadGallery();
		this.parentCall = this.$parent.$parent.$parent.$parent
    
  }
}
</script>

<style lang="scss" scoped>
.no-pic-message {
	font-weight: bold;
}
.image-description {
	text-align: center;
	font-weight: bold;

	// p {
	// 	color: white;
	// }
}
.dialog-picture {
	position: relative;
	img {
		width: 300px;
		height: auto;
	}
	button {
		position: relative;
	}
}
.md-dialog {
	width: 40%;
}
.md-card.md-theme-default {
	height: 503px;
}

</style>

