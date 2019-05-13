<template>
  <main>
    <span class="no-pic-message md-layout md-alignment-center-center" v-if="perkList.length == 0">
      <md-card class="mt-layout-item">
        <md-empty-state
          md-icon="card_giftcard"
          md-label="Create your first perk"
          md-description="Perks are used as gratification for the people who supported your campaign."
        >
          <md-button class="md-primary md-raised" @click="perkDialog = true">Criar</md-button>
        </md-empty-state>
      </md-card>
    </span>
    <div class="md-layout md-grutter" v-else>
      <div
        v-for="(perk, index) in perkList"
        :key="index"
        class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25"
      >
        <md-card>
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
              {{perk.description}}
              <md-button class="md-raised md-primary" @click="showModalEditPerk(perk)">Editar Recompensa</md-button>
            </md-list>
          </md-card-content>
          <md-card-actions>
            <md-checkbox v-model="allow" value="1">Mostrar disponivel</md-checkbox>
          </md-card-actions>
        </md-card>
      </div>

      <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
        <br>
        <md-button :disabled="parentCall && parentCall.loadingState()" class="md-fab md-primary" @click="perkDialog = true">
          <md-icon>add</md-icon>
        </md-button>
      </div>
    </div>
    <div>
      <md-dialog :md-active.sync="perkDialog">
        <md-dialog-title>Criar novo Perk</md-dialog-title>
        <md-dialog-content>
          <input type="file" style="display: none" id="input-file-perk" @change="pickImgPerk($event)">
          <md-button
            v-if="!imageToUploadPerk"
            @click="clickOnFileInputPerk()"
            class="md-fab md-primary"
          >
            <md-icon>add_a_photo</md-icon>
          </md-button>
          <div v-else class="dialog-picture">
            <!-- <img src="https://picsum.photos/200/200" alt=""> -->
            <img :src="base64FilePerk">
            <md-button @click="clickOnFileInputPerk()" class="md-fab md-primary">
              <md-icon>add_a_photo</md-icon>
            </md-button>
          </div>
          
          <div
            v-if="$v.imageToUploadPerk.$invalid && $v.imageToUploadPerk.$dirty"
            style="color: #ff1744;"
          >Insira uma imagem para o perk</div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perk.name.$invalid && $v.perk.name.$dirty}">
                <label>Qual o nome do seu perk?</label>
                <md-input v-model="perk.name" required></md-input>
                <span class="md-error">Informe o titulo</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perk.price.$invalid && $v.perk.price.$dirty}">
                <label>Qual o valor do seu perk?</label>
                <md-input v-model.number="perk.price" required></md-input>
                <span class="md-error">Informe o valor</span>
              </md-field>
            </div>
          </div>

          <md-field :class="{'md-invalid': $v.perk.description.$invalid && $v.perk.description.$dirty}">
            <label>Qual a descrição do seu perk? *</label>
            <md-textarea v-model="perk.description" required md></md-textarea>
            <span class="md-error">Informe a descrição!</span>
          </md-field>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perk.stock.$invalid && $v.perk.stock.$dirty}">
                <label>Qual o estoque do seu perk?</label>
                <md-input v-model="perk.stock" required></md-input>
                <span class="md-error">Informe o estoque</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perk.discount.$invalid && $v.perk.discount.$dirty}">
                <label>Qual o valor do desconto?</label>
                <md-input v-model.number="perk.discount" required></md-input>
                <span class="md-error">Informe o valor</span>
              </md-field>
            </div>
          </div>
          

          

          <md-switch v-model="perk.haveFrete">Seu produto será enviado pelos correios?</md-switch>
          <div v-show="perk.haveFrete">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                <md-field :class="{'md-invalid': $v.perk.shipping_price.$invalid}">
                  <label>Qual o valor do frete?</label>
                  <md-input v-model.number="perk.shipping_price" required></md-input>
                  <span class="md-error">Informe o valor</span>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                  <md-datepicker class="no-icon" :class="{'md-invalid': $v.perk.shipping_date.$invalid}" md-immediately v-model="perk.shipping_date" required>
              <label>Informe a data estimada de entrega do seu produto</label>
            </md-datepicker>
              </div>
            </div>
            
          
            <div>
              <div>
                <b>Opções de envio:</b>
              </div>
              <div>

                <md-radio
                  v-model="perk.shipping_worldwide"
                  value="only_country"
                >Meu produto será enviado apenas para o país</md-radio>
                <md-radio
                  v-model="perk.shipping_worldwide"
                  value="world_wide"
                >Meu produto será enviado para qualquer lugar do mundo</md-radio>
              </div>
            </div>
          </div>
        </md-dialog-content>
        <md-dialog-actions>
          <md-button class="md-acent md-raised" @click="resetPerk()">Close</md-button>
          <md-button class="md-primary md-raised" :disabled="parentCall && parentCall.loadingState()" @click="uploadNewPerk()">Add</md-button>
        </md-dialog-actions>
      </md-dialog>
    </div>

    <div>
      <md-dialog :md-active.sync="perkEditDialog">
        <md-dialog-title>Editar Perk</md-dialog-title>
        <md-dialog-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perkEdit.name.$invalid && $v.perkEdit.name.$dirty}">
                <label>Qual o nome do seu perk?</label>
                <md-input v-model="perkEdit.name" required></md-input>
                <span class="md-error">Informe o titulo</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perkEdit.price.$invalid && $v.perkEdit.price.$dirty}">
                <label>Qual o valor do seu perk?</label>
                <md-input v-model.number="perkEdit.price" required></md-input>
                <span class="md-error">Informe o valor</span>
              </md-field>
            </div>
          </div>
          
          <md-field
            :class="{'md-invalid': $v.perkEdit.description.$invalid && $v.perkEdit.description.$dirty}">
            <label>Qual a descrição do seu perk?</label>
            <md-textarea v-model="perkEdit.description" required></md-textarea>
            <span class="md-error">Informe o titulo</span>
          </md-field>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="{'md-invalid': $v.perkEdit.stock.$invalid && $v.perkEdit.stock.$dirty}">
                <label>Qual o estoque do seu perk?</label>
                <md-input v-model="perkEdit.stock" required></md-input>
                <span class="md-error">Informe o estoque</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field
                :class="{'md-invalid': $v.perkEdit.discount.$invalid && $v.perkEdit.discount.$dirty}">
                <label>Qual o valor do desconto?</label>
                <md-input v-model.number="perkEdit.discount" required></md-input>
                <span class="md-error">Informe o desconto</span>
              </md-field>
            </div>
          </div>
          
          <input
            type="checkbox"
            id="id-name--1"
            name="set-name"
            class="switch-input"
            @change="mudou()"
            :checked="perkEdit.haveFrete"
          >					
          <label for="id-name--1" class="switch-label">Seu produto será enviado pelos correios?</label>

          <div v-show="perkEdit.haveFrete">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                  <md-field :class="{'md-invalid': $v.perkEdit.shipping_price.$invalid}">
                    <label>Qual o valor do frete?</label>
                    <md-input v-model.number="perkEdit.shipping_price" required></md-input>
                    <span class="md-error">Informe o valor</span>
                  </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-datepicker class="no-icon" :class="{'md-invalid': $v.perkEdit.shipping_date.$invalid}" md-immediately v-model="perkEdit.shipping_date" required>
                  <label>Informe a data estimada de entrega do seu produto</label>
                </md-datepicker>
              </div>
            </div>
            <div>
              <br>
              <b>Opções de envio:</b>
              <br>
              <md-radio
                v-model="perkEdit.shipping_worldwide"
                value="only_country"
              >Meu produto será enviado apenas para o país</md-radio>
              <md-radio
                v-model="perkEdit.shipping_worldwide"
                value="world_wide"
              >Meu produto será enviado para qualquer lugar do mundo</md-radio>
            </div>
          </div>
        </md-dialog-content>
        <md-dialog-actions>
          <md-button class="md-acent md-raised" @click="resetEditPerk()">Close</md-button>
          <md-button class="md-primary md-raised" :disabled="parentCall && parentCall.loadingState()" @click="editPerk()">Save</md-button>
        </md-dialog-actions>
      </md-dialog>
    </div>
  </main>
</template>

<script>
import { mapState } from 'vuex';
import { required } from "vuelidate/lib/validators";
export default {
  data() {
		return {			
			parentCall: null,
      base64FilePerk: false,
			perkDialog: false,
			perkEditDialog: false,
			perkEdit: {
				name: "",
				stock: "",
				price: null,
				shipping_price: 0.0,
				shipping_date: null,
				description: "",
				haveFrete: false,
				shipping_worldwide: "world_wide"
			},
			allow: true,
      imageToUploadPerk: null,
			perk: {
				name: "",
				stock: "",
				price: null,
				shipping_price: 0.0,
				shipping_date: null,
				description: "",
				haveFrete: false,
				shipping_worldwide: "world_wide"
			},
			perkList: [],
		};
	},
	validations: {
		perkEdit: {
			name: {
				required
			},
			stock: {
				required
			},
			price: {
				required
			},
			discount: {
				required
			},
			description: {
				required
			},
			shipping_price: {
				checkFrete: function() {
					if(this.perkEdit.haveFrete && (!this.perkEdit.shipping_price || this.perkEdit.shipping_price <= 0)) {
						return false
					}
					return true
				},
			},
			shipping_date: {
				checkDate: function() {
					if(this.perkEdit.haveFrete && !this.perkEdit.shipping_date) {
						return false
					}
					return true
				}
			}
		},
		perk: {
			name: {
				required
			},
			stock: {
				required
			},
			price: {
				required
			},
			discount: {
				required
			},
			description: {
				required
			},
			shipping_price: {
				checkFrete: function() {
					if(this.perk.haveFrete && (!this.perk.shipping_price || this.perk.shipping_price <=0)) {
						return false
					}
					return true
				}
			},
			shipping_date: {
				checkDate: function() {
					if(this.perk.haveFrete && !this.perk.shipping_date) {
						return false
					}
					return true
				}
			}
		},
		imageToUploadPerk: {
			required
		}
	},
	computed: {
		...mapState(["user"]),
  },
  methods: {
    mudou() {
			this.perkEdit.haveFrete = !this.perkEdit.haveFrete
			if(!this.perkEdit.haveFrete) this.perkEdit.shipping_price = 0
		},
		showModalEditPerk(perkToEdit) {
			this.perkEditDialog = true;
			if(perkToEdit.shipping_date == "0000-00-00" && perkToEdit.shipping_price == 0 ){
				this.perkEdit = {...perkToEdit, haveFrete: false, shipping_date: null};
			}
			else {
				this.perkEdit = {...perkToEdit, haveFrete: false};
			}
			if(this.perkEdit.shipping_price > 0) {
				this.perkEdit.haveFrete = true;
			}
		},
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
				})
		},
		uploadNewPerk() {
			this.$v.perk.$touch();
			this.$v.imageToUploadPerk.$touch();
			if (!this.$v.perk.$invalid && !this.$v.imageToUploadPerk.$invalid) {
				this.$v.imageToUploadPerk.$reset();
				this.$v.perk.$reset();
				this.perk.campaign_id = this.$route.params.id;
				this.perk.image = this.imageToUploadPerk;
				if(this.perk.haveFrete) {
					this.perk.shipping_date = this.perk.shipping_date
					.toISOString()
					.split("T")[0];
				}else {
					this.perk.shipping_price = 0
				}

        this.perkDialog = false;

        this.parentCall.showLoading();

				global
					.$post("/Content/addperk", this.perk, this.user.token)
					.then(response => {
						this.loadPerk();
						this.perk = [];
						this.imageToUploadPerk = "";
						this.base64FilePerk = "";
					})
					.catch(err => {
						let validErr =
							err &&
							err.response &&
							err.response.data &&
							err.response.data.error;
						alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
					})
					.finally(() => {
            this.parentCall.hideLoading()                        
					});
			}
		},

		editPerk() {
				
			this.$v.perkEdit.$touch();

			if (!this.$v.perkEdit.$invalid) {
				this.$v.perkEdit.$reset();
				this.perkEdit.campaign_id = this.$route.params.id;
				this.perkEdit.shipping_date = this.perkEdit.shipping_date
					.toISOString()
					.split("T")[0];

				this.perkEditDialog = false;
				this.parentCall.showLoading()

				global
					.$post("/Content/editperk", this.perkEdit, this.user.token)
					.then(response => {
						this.loadPerk();
						this.perkEdit = {};
					})
					.catch(err => {
						let validErr =
							err &&
							err.response &&
							err.response.data &&
							err.response.data.error;
						alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
					})
					.finally(() => {
            this.parentCall.hideLoading();

					});
			}
		},
		resetEditPerk() {
			this.perkEditDialog = false;
			this.perkEdit = {};
			this.$v.perkEdit.$reset();
		},
		resetPerk() {
			this.perkDialog = false;
			this.imageToUploadPerk = null;
			this.perk.stock = null;
			this.perk.price = null;
			this.perk.name = null;
			this.$v.imageToUploadPerk.$reset();
			this.$v.perk.$reset();
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
  },
  mounted() {
		this.loadPerk()
		this.parentCall = this.$parent.$parent.$parent.$parent
  }
}
</script>

<style lang="scss" scoped>

.md-dialog {
	width: 70%;
}
.switch-input {
	display: none;
}
.switch-label {
	position: relative;
	display: inline-block;
	min-width: 112px;
	cursor: pointer;
	font-weight: 500;
	text-align: left;
	margin: 16px;
	padding: 16px 0 16px 44px;
}
.switch-label:before,
.switch-label:after {
	content: "";
	position: absolute;
	margin: 0;
	outline: 0;
	top: 50%;
	-ms-transform: translate(0, -50%);
	-webkit-transform: translate(0, -50%);
	transform: translate(0, -50%);
	-webkit-transition: all 0.3s ease;
	transition: all 0.3s ease;
}
.switch-label:before {
	left: 1px;
	width: 34px;
	height: 14px;
	background-color: #9e9e9e;
	border-radius: 8px;
}
.switch-label:after {
	left: 0;
	width: 20px;
	height: 20px;
	background-color: #fafafa;
	border-radius: 50%;
	box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14),
		0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
}
.switch-label .toggle--on {
	display: none;
}
.switch-label .toggle--off {
	display: inline-block;
}
.switch-input:checked + .switch-label:before {
	background-color: rgba(255,82,82,0.38);
}
.switch-input:checked + .switch-label:after {
	background-color: #ff5252;
	-ms-transform: translate(80%, -50%);
	-webkit-transform: translate(80%, -50%);
	transform: translate(80%, -50%);
}
.switch-input:checked + .switch-label .toggle--on {
	display: inline-block;
}
.switch-input:checked + .switch-label .toggle--off {
	display: none;
}
</style>

