<template>
	<div>
		<div class="loading-overlay" v-if="loading">
			<md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
		</div>
		<md-tabs class="md-primary" md-alignment="fixed">
			<md-tab id="tab-pages" md-label="Resumo" md-icon="pages">
				<div class="md-layout md-grutter md-alignment-center-center">
					<div class="md-layout-item md-small-size-100 md-size-100">
						<md-card>
							<md-card-content>
								<ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
							</md-card-content>
						</md-card>
					</div>
					<div class="md-layout md-grutter md-alignment-center-center">
						<md-button class="md-fab md-primary">
							<md-icon>close</md-icon>
						</md-button>
						<md-button class="md-fab md-primary" style="background:green">
							<md-icon>save</md-icon>
						</md-button>
					</div>
				</div>
			</md-tab>
			<md-tab id="tab-gift" md-label="perks" md-icon="card_giftcard">

				<span class="no-pic-message md-layout  md-alignment-center-center" v-if="perkList.length == 0">
					<md-card class="mt-layout-item">
						<md-empty-state
					      md-icon="card_giftcard"
					      md-label="Create your first perk"
					      md-description="Perks are used as gratification for the people who supported your campaign.">
					      <md-button class="md-primary md-raised"  @click="perkDialog = true">Create</md-button>
					    </md-empty-state>
					</md-card>
				</span>
				<div class="md-layout md-grutter" v-else>
					<div v-for="(perk, index) in perkList" :key="index" class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
						<md-card>
							<md-card-actions class="delete-btn-absolute">
								<md-button class="md-fab md-mini" @click="openPerkDeleteModal(perk)">
									<md-icon>delete</md-icon>
								</md-button>
							</md-card-actions>
							<md-card-area md-inset>
								<md-card-media md-ratio="16:9">
									<img :src="'http://25.20.118.56/gofunder/'+perk.cover_url">
								</md-card-media>
								<md-card-header>
									<h2 class="md-title">{{perk.name}}</h2>
									<div class="md-subhead">
										<span>{{perk.price | currency}}</span>
									</div>
								</md-card-header>
							</md-card-area>
							<md-card-content>
								<md-list>
									<md-list-item>
										<md-icon>star</md-icon>
										<span class="md-list-item-text">0 itens adicionados</span>

									</md-list-item>
									
								<md-button class="md-raised md-primary">Add itens</md-button>
								</md-list>
							</md-card-content>
							<md-card-actions>
								<md-checkbox v-model="allow" value="1">Mostrar disponivel</md-checkbox>
							</md-card-actions>
						</md-card>

            
					</div>

          
					<div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
						<br>
						<md-button class="md-fab md-primary" @click="perkDialog = true">
							<md-icon>add</md-icon>
						</md-button>
					</div>
				</div>
				<md-dialog-confirm
					:md-active.sync="modalDeletePerk"
					md-title="Tem certeza que deseja deletar o seu perk?"
					md-content="Ao confirmar não haverá como restaurar o perk..."
					md-confirm-text="Confirmar"
					md-cancel-text="Fechar"
					@md-cancel="modalDeletePerk = false"
					@md-confirm="deletePerk()" />
				<div>
					<md-dialog :md-active.sync="perkDialog">
						<md-dialog-title>Criar novo Perk</md-dialog-title>
						<md-dialog-content>
							<input type="file" style="display: none" id="input-file-perk" @change="pickImgPerk($event)">
							<md-button v-if="!imageToUploadPerk" @click="clickOnFileInputPerk()" class="md-fab md-primary">
								<md-icon>add_a_photo</md-icon>
							</md-button>
							<div v-else class="dialog-picture">
								<!-- <img src="https://picsum.photos/200/200" alt=""> -->
								<img :src="base64FilePerk">
								<md-button @click="clickOnFileInputPerk()" class="md-fab md-primary">
									<md-icon>add_a_photo</md-icon>
								</md-button>
							</div>
							
							<div v-if="$v.imageToUploadPerk.$invalid && $v.imageToUploadPerk.$dirty" style="color: #ff1744;">Insira uma imagem para o perk</div>


							<md-field :class="{'md-invalid': $v.perk.name.$invalid && $v.perk.name.$dirty}">
								<label>Qual o nome do seu perk?</label>
								<md-input v-model="perk.name" required></md-input>
								<span class="md-error">Informe o titulo</span>
							</md-field>
							<md-field :class="{'md-invalid': $v.perk.price.$invalid && $v.perk.price.$dirty}">
								<label>Qual o valor do seu perk?</label>
								<md-input v-model.number="perk.price" required></md-input>
								<span class="md-error">Informe o valor</span>
							</md-field>
							<md-field :class="{'md-invalid': $v.perk.stock.$invalid && $v.perk.stock.$dirty}">
								<label>Qual o estoque do seu perk?</label>
								<md-input v-model="perk.stock" required></md-input>
								<span class="md-error">Informe o estoque</span>
							</md-field>
								<md-datepicker class="no-icon" md-immediately v-model="perk.shipping_date" required>
									<label>Informe a data de entrega do seu perk</label>
								</md-datepicker>
						</md-dialog-content>
						<md-dialog-actions>
							<md-button class="md-acent md-raised" @click="resetPerk()">Close</md-button>
							<md-button class="md-primary md-raised" @click="uploadNewPerk()">Add</md-button>
						</md-dialog-actions>
					</md-dialog>
				</div>
			</md-tab>
			<md-tab id="tab-collections" md-label="Gallery" md-icon="collections">
				<md-dialog-confirm
					:md-active.sync="modalDeleteImage"
					md-title="Tem certeza que deseja deletar esta foto da galeria?"
					md-content="Ao confirmar não haverá como restaurá-la..."
					md-confirm-text="Confirmar"
					md-cancel-text="Fechar"
					@md-cancel="modalDeleteImage = false"
					@md-confirm="deleteImage()" />
				<span class="no-pic-message md-layout  md-alignment-center-center" v-if="pictures.length == 0">
					<md-card class="mt-layout-item">
						<md-empty-state
					      md-icon="add_a_photo"
					      md-label="Adicione sua primeira imagem!"
					      md-description="As imagens serão mostradas na sua galeria de fotos da campanha">
					      <md-button class="md-primary md-raised"  @click="showAddImg = true">Escolher Imagem</md-button>
					    </md-empty-state>
					</md-card>
				</span>
				<div class="md-layout md-grutter" v-else>
					<div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25" v-for="(picture, index) in pictures" :key="index">
						<md-card>
							<md-card-actions class="delete-btn-absolute">
								<md-button class="md-fab md-mini" @click="openDeleteImageModal(picture)">
									<md-icon>delete</md-icon>
								</md-button>
							</md-card-actions>
								<md-card-area md-inset>
								<md-card-media md-ratio="16:9">
									<img :src="'http://25.20.118.56/gofunder/'+picture.picture_url">
								</md-card-media>
								<md-card-header>
									<h2 class="md-title">Legenda: </h2>
									<div class="md-subhead">
										<span>{{picture.name}}</span>
									</div>
								</md-card-header>
								</md-card-area>
						</md-card>
					</div>
					<div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
						<br>
						<md-button :disabled="loading" class="md-fab md-primary" @click="showAddImg = true" v-if="pictures.length != 0">
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
								<!-- <img src="https://picsum.photos/200/200" alt=""> -->
								<img :src="base64File">
								<md-button @click="clickOnFileInput()" class="md-fab md-primary">
									<md-icon>add_a_photo</md-icon>
								</md-button>
							</div>
							<md-field v-if="imageToUpload" style="margin-top: 1rem;">
								<label>Insira a descrição da imagem</label>
								<md-input v-model="imgCaption" required></md-input>
							</md-field>
						</md-dialog-content>
						<md-dialog-actions>
							<md-button class="md-acent md-raised" @click="resetImage()">Close</md-button>
							<md-button
								:disabled="!imageToUpload || !imgCaption"
								class="md-primary md-raised"
								@click="uploadNewImage()"
							>Add</md-button>
						</md-dialog-actions>
					</md-dialog>
			</md-tab>
			<md-tab id="tab-question_answer" md-label="Faqs" md-icon="question_answer">
				<md-dialog-confirm
					:md-active.sync="modalDeleteFaq"
					md-title="Tem certeza que deseja deletar este FAQ?"
					md-content="Ao confirmar não haverá como restaurá-lo..."
					md-confirm-text="Confirmar"
					md-cancel-text="Fechar"
					@md-cancel="modalDeleteFaq = false"
					@md-confirm="deleteFaq()" />
				<span class="no-pic-message md-layout  md-alignment-center-center" v-if="faqList.length == 0">
					<md-card class="mt-layout-item">
						<md-empty-state
					      md-icon="question_answer"
					      md-label="Frequently asked questions"
					      md-description="Answer some basic questions for your investors.">
					      <md-button class="md-primary md-raised"  @click="createFaq = true">Create</md-button>
					    </md-empty-state>
					</md-card>
				</span>
				<div class="md-layout md-grutter md-alignment-center-center" v-else>
					<md-card  style="min-width: 50%">

			      <md-card-header>
			        <div class="md-title">Frequently asked questions</div>
			      </md-card-header>
					<md-list class="md-double-line md-size-100" style="min-width: 50%">

						<md-divider></md-divider>
						<md-list-item v-for="(faq, index) in faqList" :key="index" class="bordered">
							<div class="md-list-item-text">
								<span>{{faq.question}}</span>
								<span>{{faq.answer}}</span>
							</div>
							<md-button class="md-icon-button" @click="openEditFaqModal(faq)">
								<md-icon>edit</md-icon>
							</md-button>
							<md-button class="md-icon-button" @click="openDeleteFaqModal(faq)">
								<md-icon>delete</md-icon>
							</md-button>
						</md-list-item>
					</md-list>
				</md-card>
				</div>

				<div class="md-layout md-grutter md-alignment-center-center"  v-if="faqList.length != 0">
					<md-button class="md-fab md-primary" @click="createFaq = true">
						<md-icon>add</md-icon>
					</md-button>
				</div>

				<div>
					<md-dialog :md-active.sync="createFaq">
						<md-dialog-title>Criar novo FAQ</md-dialog-title>
						<md-dialog-content>
							<md-field :class="{'md-invalid': $v.faq.question.$invalid && $v.faq.question.$dirty}">
								<label>Escreva uma pergunta</label>
								<md-input v-model="faq.question" required></md-input>
								<span class="md-error">Insira uma pergunta</span>
							</md-field>
							<md-field :class="{'md-invalid': $v.faq.answer.$invalid && $v.faq.answer.$dirty}">
								<label>Escreva uma resposta</label>
								<md-input v-model="faq.answer" required></md-input>
								<span class="md-error">Insira uma resposta</span>
							</md-field>
						</md-dialog-content>
						<md-dialog-actions>
							<md-button class="md-acent md-raised" @click="resetFaq()">Close</md-button>
							<md-button class="md-primary md-raised" @click="addFaq()" >Add</md-button>
						</md-dialog-actions>
					</md-dialog>
					<md-dialog :md-active.sync="edittingFaq">
						<md-dialog-title>Editar FAQ</md-dialog-title>
						<md-dialog-content>
							<md-field :class="{'md-invalid': $v.faqEdit.question.$invalid && $v.faqEdit.question.$dirty}">
								<label>Edite sua pergunta</label>
								<md-input v-model="faqEdit.question" required></md-input>
								<span class="md-error">Insira uma pergunta</span>
							</md-field>
							<md-field :class="{'md-invalid': $v.faqEdit.answer.$invalid && $v.faqEdit.answer.$dirty}">
								<label>Edite sua resposta</label>
								<md-input v-model="faqEdit.answer" required></md-input>
								<span class="md-error">Insira uma resposta</span>
							</md-field>
						</md-dialog-content>
						<md-dialog-actions>
							<md-button class="md-acent md-raised" @click="resetFaq()">Close</md-button>
							<md-button
								class="md-primary md-raised"
								@click="editFaq()"
							>Edit</md-button>
						</md-dialog-actions>
					</md-dialog>
				</div>
			</md-tab>
			<md-tab id="tab-share" md-label="Social networks" md-icon="share">
				<div class="md-layout md-grutter md-alignment-center-center">
					<md-card  style="min-width: 50%">

			      <md-card-header>
			        <div class="md-title">Social networks profiles</div>
			      </md-card-header>
        <md-card-content>
					
    <md-field>
      <md-icon class="mdi mdi-instagram"></md-icon>
      <label>Instagram profile</label>
      <md-input v-model="social.instagram"></md-input>
    </md-field>
    <md-field>
      <md-icon class="mdi mdi-facebook"></md-icon>
      <label>Facebook profile</label>
      <md-input v-model="social.facebook"></md-input>
    </md-field>
    <md-field>
      <md-icon class="mdi mdi-youtube"></md-icon>
      <label>Youtube channel</label>
      <md-input v-model="social.youtube"></md-input>
    </md-field>
</md-card-content>
				</md-card>
				</div>
					<div class="md-layout md-grutter md-alignment-center">
						<md-button @click="saveSocial()" class="md-fab md-primary" style="background:green">
							<md-icon>save</md-icon>
						</md-button>
					</div>
			</md-tab>
		</md-tabs>
	</div>
</template>
<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { mapState } from "vuex";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
export default {
	components: {},

	data() {
		return {
			perkToDelete: null,
			imageToDelete: null,
			faqToDelete: null,
			modalDeleteImage: false,
			modalDeletePerk: false,
			modalDeleteFaq: false,
			perkDialog: false,
			perk: {
				name: "",
				stock: "",
				price: null,
				shipping_date: null
			},
			social: {
				instagram: null,
				facebook: null,
				youtube: null,
			},
			perkStatus: null,
      perkList: [],
			editor: ClassicEditor,
			editorConfig: {},
			faqOnEdit: null,
			imageToUploadPerk: null,
			edittingFaq: false,
			faqEdit: {
				question: null,
				answer: null,
			},
			faq: {
				question: null,
				answer: null,
			},
			faqList: [],
			loading: false,
			pictureUrl: null,
			editorData: null,
			imageToUpload: null,
			base64File: null,
			imgCaption: null,
			showAddImg: false,
			config: {
				height: 400,
				extraPlugins: ["youtube", "imageresize", "emoji"]
			},
			base64FilePerk: false,
			createFaq: false,
			allow: true,
			pictures: []
		}
	},
	validations: {
			perk: {
				name: {
					required
				},
				stock:{
					required	
				},
				price: {
					required
				},
				shipping_date: {
					required
				}
			},
			faq: {
				question: {
					required
				},
				answer: {
					required
				}
			},
			faqEdit: {
				question: {
					required
				},
				answer: {
					required
				}
			},
			imageToUploadPerk: {
				required
			}
	},
	computed: {
		...mapState(["user"])
	},

	methods: {
		loadPerk() {
			global
				.$get(
					"/Content/getperk?campaign_id=" + this.$route.params.id,
					{},
					this.user.token
				)
				.then(res => {
					this.perkList = res.data;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				});
		},
		uploadNewPerk() {
			this.$v.perk.$touch();
			this.$v.imageToUploadPerk.$touch();
			if (!this.$v.perk.$invalid && !this.$v.imageToUploadPerk.$invalid) {
				this.$v.imageToUploadPerk.$reset();
				this.$v.perk.$reset();
				this.perk.campaign_id = this.$route.params.id;
				this.perk.image = this.imageToUploadPerk;
				let parsedDate =this.perk.shipping_date.toISOString().split('T')[0]
				global
					.$post("/Content/addperk", {...this.perk, shipping_date: parsedDate}, this.user.token)
					.then(response => {
						this.loadPerk()
						this.perkDialog = false
						this.perk = []
						this.imageToUploadPerk = ''
						this.base64FilePerk = ''
					})
					.catch(err => {
						let validErr =
							err && err.response && err.response.data && err.response.data.error;
						alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
					})
					.finally(() => {
						this.loading = false;
					});
				} else {
					this.perkStatus = 'error' 
				}
		},
		resetPerk() {
			this.perkDialog = false
			this.imageToUploadPerk = null
			this.perk.stock = null
			this.perk.price = null
			this.perk.name = null
			this.$v.imageToUploadPerk.$reset();
			this.$v.perk.$reset();
		},
		openPerkDeleteModal(perk) {
			this.perkToDelete = perk
			this.modalDeletePerk = true
		},
		deletePerk() {
			let data = {
				id: this.perkToDelete.id
			}
			global.$post("/Content/deleteperk", data, this.user.token)
				.then(res => {
					this.loadPerk();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
				});
		},
		//GALLERY
		loadGallery() {
			global
				.$get(
					"/Content/getgalery?campaign_id=" + this.$route.params.id,
					{},
					this.user.token
				)
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
		clickOnFileInputPerk() {
			document.getElementById("input-file-perk").click();
		},
		pickImgPerk(evt) {
			let reader = new FileReader();
			this.imageToUploadPerk = evt.target.files[0];
			reader.onload = e => {
				this.base64FilePerk = e.target.result;
			};
			reader.readAsDataURL(evt.target.files[0]);
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
			this.loading = true;
			let data = {
				image: this.imageToUpload,
				title: this.imgCaption
			};
			global
				.$post("/Content/upload_gallery", data, this.user.token)
				.then(response => {
					this.pictureUrl = response.data.gallery_url;
					let data = {
						picture_url: this.pictureUrl,
						campaign_id: this.$route.params.id,
						legend: this.imgCaption
					};
					global
						.$post("/Content/addgalery", data, this.user.token)
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
					this.loading = false;
					this.resetImage()
				});
		},
		openDeleteImageModal(img) {
			this.imageToDelete = img
			this.modalDeleteImage = true
		},
		deleteImage() {
			this.loading = true;
			let data = {
				id: this.imageToDelete.id
			};
			global
				.$post("/Content/deletegalery", data, this.user.token)
				.then(res => {
					this.loadGallery();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
					this.loading = false;
				});
		},
		resetImage() {
			this.showAddImg = false;
			this.imageToUpload = null;
			this.base64File = null;
			this.imgCaption = null;
		},
		//FAQ
		loadFaq() {
			global
				.$get(
					"/Content/getfaq?campaign_id=" + this.$route.params.id,
					{},
					this.user.token
				)
				.then(res => {
					this.faqList = res.data;
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				});
		},
		addFaq() {
			this.$v.faq.$touch();
			if (!this.$v.faq.$invalid) {
				this.createFaq = false;
				this.loading = true;
				let data = {
					campaign_id: this.$route.params.id,
					question: this.faq.question,
					answer: this.faq.answer
				}
				global
					.$post("/Content/addfaq", data, this.user.token)
					.then(res => {
						this.resetFaq()
						this.loadFaq();
					})
					.catch(err => {
						let validErr =
							err && err.response && err.response.data && err.response.data.error;
						alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
					})
					.finally(() => {
						this.loading = false;
					});
			}
		},
		resetFaq() {
			this.edittingFaq = false
			this.createFaq = false;
			this.$v.faq.$reset();
			this.$v.faqEdit.$reset();
			(this.faq.question = null), (this.faq.answer = null);
		},
		deleteFaq() {
			this.loading = true;
			let data = {
				id: this.faqToDelete.id
			};
			global
				.$post("/Content/deletefaq", data, this.user.token)
				.then(res => {
					this.loadFaq();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
					this.loading = false;
				});
		},
		openEditFaqModal(faq) {
			this.edittingFaq = true;
			this.faqOnEdit = faq;
			this.faqEdit.answer = faq.answer;
			this.faqEdit.question = faq.question;
		},
		editFaq() {
			this.$v.faqEdit.$touch();
			if(!this.$v.faqEdit.$invalid) {
			this.loading = true;
			this.edittingFaq = false;
			let data = {
				id: this.faqOnEdit.id,
				answer: this.faqEdit.answer,
				question: this.faqEdit.question
			};
			global
				.$post("/Content/editfaq", data, this.user.token)
				.then(res => {
					this.loadFaq();
					this.resetFaq();
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
					this.loading = false;
				});
			}
		},
		openDeleteFaqModal(faq) {
			this.faqToDelete = faq
			this.modalDeleteFaq = true
		},
		//social
		getSocial() {
			global.$get("/Content/getsocial?campaign_id="+ this.$route.params.id, {} , this.user.token)
				.then(res => {
					console.log('getsocial',res)
					this.social = {...res.data[0]}
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
				});
		},
		saveSocial() {
			let data = { 
				facebook:  this.social.facebook,
				instagram:  this.social.instagram,
				youtube: this.social.youtube,
				campaign_id: this.$route.params.id
			}
			global.$post("/Content/updatesocial", data, this.user.token)
				.then(res => {
					console.log(res)
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
				});
		}
	},

	mounted() {
		// alert(this.$moment("[native Date Tue May 21 2019 00:00:00 GMT-0300 (Horário Padrão de Brasília)]", "YYYY-MM-DD"))
		this.getSocial()
		this.loadGallery()
    this.loadFaq()
    this.loadPerk()
	}
};
</script>
<style lang="scss" scoped>
.bordered {
	&:not(:last-child) {
		border-bottom: 1px solid
			var(--md-theme-default-divider, rgba(0, 0, 0, 0.12));
	}
}
.md-datepicker {
	i {
		display: none;
	}
}
.md-dialog {
	width: 568px;
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
.no-pic-message {
	font-weight: bold;
}
// .close-icon-container {
// 	padding: 10px;
// 	position: absolute;
// 	right: 0;
// 	z-index: 100;
// 	&:hover {
// 		background: #ccc;
// 		cursor: pointer;
// 	}
// 	i {
// 		font-size: 2rem !important;
// 	}
// }
.delete-btn-absolute {
	position: absolute;
	right: 0;
}
.image-description {
	text-align: center;
	p {
		color: white;
	}
}
.max-img-size {
  max-height: 170px;
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
</style>
