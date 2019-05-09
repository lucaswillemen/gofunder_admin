<template class="">
	<div>
		<div class="md-layout md-alignment-center-center">
			<div class="md-layout-item">
				<md-steppers :md-active-step.sync="actualStep" md-linear md-alternative>
					<md-step id="first" md-label="Objetivo" :md-done.sync="steps.first">
						<div class="md-layout md-gutter md-alignment-center-center">
							<div
								@click="objetivo.allow_funds = !objetivo.allow_funds"
								style="cursor:pointer;"
								class="md-layout-item md-size-50 md-small-size-100"
							>
								<md-card
									class="md-layout md-alignment-center-center md-elevation-5"
									:class="{'md-primary': objetivo.allow_funds}"
								>
									<md-empty-state
										class="md-empty-state-icon-first"
										md-icon="account_balance_wallet"
										md-label="Arrecadar fundos"
										md-description="Receba doacoes e envie recompensas para os apioadores da sua campanha em forma de gratidao pela ajuda."
									></md-empty-state>
								</md-card>
							</div>
							<div
								@click="objetivo.allow_speedup = !objetivo.allow_speedup"
								style="cursor:pointer;"
								class="md-layout-item md-size-50 md-small-size-100"
							>
								<md-card
									class="md-layout md-alignment-center-center md-elevation-5"
									:class="{'md-primary': objetivo.allow_speedup}"
								>
									<md-empty-state
										class="md-empty-state-icon-first"
										md-icon="fast_forward"
										md-label="Acelerar seu projeto"
										md-description="Mostre seu projeto para tutores e investidores para ganhar apoio qualificado para fazer sua ideia acontecer."
									></md-empty-state>
								</md-card>
							</div>

							<div
								@click="objetivo.allow_presale = !objetivo.allow_presale"
								style="cursor:pointer;"
								class="md-layout-item md-size-50 md-small-size-100"
							>
								<md-card
									class="md-layout md-alignment-center-center md-elevation-5"
									:class="{'md-primary': objetivo.allow_presale}"
								>
									<md-empty-state
										class="md-empty-state-icon-first"
										md-icon="shopping_basket"
										md-label="Venda antes de terminar"
										md-description="Faca uma prevenda do seu produto enquanto vc finaliza seu projeto e analise o comportamento e aprovacao do publico."
									></md-empty-state>
								</md-card>
							</div>
							<div
								@click="objetivo.allow_share = !objetivo.allow_share"
								style="cursor:pointer;"
								class="md-layout-item md-size-50 md-small-size-100"
							>
								<md-card
									class="md-layout md-alignment-center-center md-elevation-5"
									:class="{'md-primary': objetivo.allow_share}"
								>
									<md-empty-state
										class="md-empty-state-icon-first"
										md-icon="share"
										md-label="Compartilhe sua ideia"
										md-description="Encontre acionistas que irao ajudar a financiar seu projeto e divida os lucros com quem te ajudou."
									></md-empty-state>
								</md-card>
							</div>
							<div class="md-layout md-alignment-center-center">
								<md-button
									class="md-fab md-primary"
									:disabled="!Object.values(objetivo).includes(true)"
									@click="moveStep('first', 'second')"
								>
									<md-icon>arrow_forward</md-icon>
								</md-button>
							</div>
						</div>
					</md-step>
					<md-step
						id="second"
						md-label="Caracteristicas"
						:md-done.sync="steps.second"
						:md-editable="true"
						:md-error="secondError"
					>
						<form novalidate @submit.prevent="validateSecond">
							<div class="md-layout md-gutter">
								<md-card class="md-layout-item md-size-100 md-small-size-100">
									<md-card-header class="md-layout md-gutter md-alignment-center-center">
										<div class="md-title">Vamos identificar o tipo do seu projeto</div>
									</md-card-header>
									<md-card-content>
										<!--
                  <md-field  :class="getValidationClassSecond('amount')">
                    <label>Qual valor vc espera arrecadar para concluir seu projeto?</label>
                    <span class="md-prefix">$</span>
                    <md-input v-model="caracteristicas.amount" name="amount"></md-input>
                    
                    <span class="md-error">Informe o valor</span>
										</md-field>!-->
										<div class="md-field md-theme-default md-has-value" :class="getValidationClassSecond('amount')">
											<label for="md-input-y1unieu5t">Qual valor você espera arrecadar para concluir seu projeto?</label>
											<span class="md-prefix"></span>										
                      <money v-model="caracteristicas.amount" class="md-input" v-bind="moneyConfig"></money> 
											<span class="md-error">Informe o valor</span>
											<!---->
											<!---->
											<!---->
										</div>
										<md-field :class="getValidationClassSecond('opt_develop')">
											<label for="developSelect">O seu projeto esta sendo desenvolvido por?</label>
											<md-select v-model="caracteristicas.opt_develop" name="opt_develop" id="developSelect">
												<md-option
													:value="opt.id"
													v-for="(opt, index) in options.campaign_develop"
													:key="index"
												>{{opt.name}}</md-option>
											</md-select>
											<span class="md-error">Selecione uma opção</span>
										</md-field>
										<md-field :class="getValidationClassSecond('opt_type')">
											<label for="typeSelect">Qual tipo do seu projeto?</label>
											<md-select v-model="caracteristicas.opt_type" name="opt_type" id="typeSelect">
												<md-option
													:value="opt.id"
													v-for="(opt, index) in options.campaign_type"
													:key="index"
												>{{opt.name}}</md-option>
											</md-select>
											<span class="md-error">Selecione uma opção</span>
										</md-field>
										<md-field :class="getValidationClassSecond('opt_category')">
											<label for="categorySelect">Escolha a categoria que melhor se adapta ao seu projeto?</label>
											<md-select
												v-model="caracteristicas.opt_category"
												name="opt_category"
												id="categorySelect"
											>
												<md-option
													:value="opt.id"
													v-for="(opt, index) in options.campaign_category"
													:key="index"
												>{{opt.name}}</md-option>
											</md-select>
											<span class="md-error">Selecione uma opção</span>
										</md-field>
										<md-field :class="getValidationClassSecond('opt_funds')">
											<label for="mfundsSelectovie">Como você gostaria de receber seus fundos?</label>
											<md-select v-model="caracteristicas.opt_funds" name="opt_funds" id="fundsSelect">
												<md-option
													:value="opt.id"
													v-for="(opt, index) in options.campaign_funds"
													:key="index"
												>{{opt.name}}</md-option>
											</md-select>
											<span class="md-error">Selecione uma opcao</span>
										</md-field>
									</md-card-content>
								</md-card>
							</div>
							<div class="md-layout md-alignment-center-center">
								<md-button type="submit" class="md-fab md-primary">
									<md-icon>arrow_forward</md-icon>
								</md-button>
							</div>
						</form>
					</md-step>

					<md-step
						id="third"
						md-label="Informacoes"
						:md-done.sync="steps.third"
						:md-editable="true"
						:md-error="thirdError"
					>
						<form novalidate @submit.prevent="validateThird">
							<div class="md-layout md-gutter">
								<md-card class="md-layout-item md-size-100 md-small-size-100">
									<md-card-header class="md-layout md-gutter md-alignment-center-center">
										<div class="md-title">Insira as informações da sua campanha</div>
									</md-card-header>
									<md-card-content>
										<md-field :class="getValidationClassThird('title')">
											<label>Qual o nome/título do seu projeto?</label>
											<md-input v-model="informacoes.title" name="title" required></md-input>
											<span class="md-error">Informe o título</span>
										</md-field>
										<md-field :class="getValidationClassThird('description')">
											<label>Faça um resumo básico do seu projeto</label>
											<md-textarea v-model="informacoes.description" md-counter="80" required></md-textarea>
										</md-field>

										<!-- <md-autocomplete v-model="selectedCountry" :md-options="options.country" md-dense md-layout="box" :md-open-on-focus="false" @md-selected="selected()">
                                <label>Em qual pais o seu projeto esta sendo desenvolvido?</label>
                                <template slot="md-autocomplete-item" slot-scope="{item, term }">
                                    <md-highlight-text :item="item.country_name" :md-term="term">{{ item.country_name }} ({{item.country_code}})</md-highlight-text>
                                </template>
										</md-autocomplete>-->
										<md-field :class="getValidationClassThird('country_id')">
											<md-select
												v-model="informacoes.country_id"
												placeholder="Em qual país o seu projeto esta sendo desenvolvido?"
												required
											>
												<md-option
													:value="opt.id"
													v-for="(opt, index) in options.country"
													:key="index"
												>{{opt.country_name}}</md-option>
											</md-select>
										</md-field>
										<md-checkbox
											v-model="informacoes.isStarted"
											class="md-primary"
										>Seu projeto já foi iniciado?</md-checkbox>

										<md-datepicker v-if="informacoes.isStarted" v-model="informacoes.startAt" md-immediately>
											<label>Quando pretende iniciar?</label>
										</md-datepicker>

										<md-datepicker
											:class="getValidationClassThird('finishAt')"
											v-model="informacoes.finishAt"
											md-immediately
										>
											<label>E quando pretende finalizar</label>
										</md-datepicker>

										<md-checkbox
											v-model="informacoes.isCountryShared"
											class="md-primary"
										>Você gostaria que pessoas de outros países vissem seu projeto?</md-checkbox>
									</md-card-content>
								</md-card>
							</div>
							<div class="md-layout md-alignment-center-center">
								<md-button type="submit" class="md-fab md-primary">
									<md-icon>arrow_forward</md-icon>
								</md-button>
							</div>
						</form>
					</md-step>

					<md-step id="fourth" md-label="Imagem" :md-done.sync="steps.fourth">
						<md-card>
							<div>
								<md-empty-state
									md-icon="add_a_photo"
									md-label="Adicione uma foto"
									md-description="Adicione uma foto que represente bem sobre o que se trata sua campanha."
								>
										<div class="upload-btn-wrapper">
											<input type="file" id="img-picker" @change="pickImg($event)" />
									
											<button class="md-primary md-upload-btn">Abrir imagem</button>
										</div>

									<div v-if="base64File" class="img-preview">
										<img :src="base64File">
									</div>
									<div class="loading-overlay" v-if="loadingImg">
										<md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
									</div>
									<md-button
										class="md-primary md-raised"
										@click="uploadImage()"
										:disabled="loadingImg || !imageToUpload"
									>Enviar imagem</md-button>
								</md-empty-state>
							</div>
						</md-card>
					</md-step>

					<md-step id="fifth" md-label="Revisão" :md-done.sync="steps.fifth">
						<div class="md-layout md-gutter md-alignment-center-center">
							<div class="md-layout-item md-small-size-100 md-size-50">
								<md-card>
									<md-card-area md-inset>
										<md-card-media md-ratio="16:9">
											<img :src="base64File">
										</md-card-media>

										<md-card-header>
											<h2 class="md-title">{{informacoes.title}}</h2>
											<div class="md-subhead">
												<md-icon>category</md-icon>
												<span>{{caracteristicas.opt_category}}</span>
											</div>
										</md-card-header>

										<md-card-content>{{informacoes.description}}</md-card-content>
									</md-card-area>

									<md-card-content>
										<div class="card-reservation">
											<div class="md-button-group md-layout md-alignment-center-center">
												<md-button class="md-layout-item">{{caracteristicas.amount | currency}}</md-button>
											</div>
										</div>
										<md-progress-bar md-mode="determinate" :md-value="0"></md-progress-bar>
									</md-card-content>
									<div class="loading-overlay" v-if="loadingcampaign">
										<md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
									</div>
									<md-dialog-alert
										:md-active.sync="campaignCreated"
										md-content="Campanha criada com sucesso!"
										md-confirm-text="Continuar"
									/>

									<md-card-actions>
										<md-button :disabled="loadingcampaign" class="md-primary" @click="createcampaign()">
											<md-icon>send</md-icon>Enviar para análise
										</md-button>
									</md-card-actions>
								</md-card>
							</div>
						</div>
					</md-step>
				</md-steppers>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters, mapActions, mapState } from "vuex";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
export default {
	name: "Create",
	mixins: [validationMixin],
	data() {
		return {
			campaignCreated: false,
			loadingcampaign: false,
			loadingImg: false,
			coverUrl: null,
			base64File: null,
			tempURL: null,
			fileTitle: null,
			imageToUpload: null,
			secondError: null,
			thirdError: null,
			objetivo: {
				allow_funds: true,
				allow_speedup: false,
				allow_presale: false,
				allow_share: false
			},
			caracteristicas: {
				amount: "200",
				opt_category: 1,
				opt_develop: 1,
				opt_funds: 7,
				opt_type: 4
			},
			informacoes: {
				title: "Coffee When Wakeup",
				description:
					"We identify the exact time that you wake up and we'll leave your coffee ready.",
				isStarted: false,
				startAt: null,
				finishAt: null,
				country_id: 1,
				isCountryShared: false
			},
			options: {},
			steps: {
				first: false,
				second: false,
				third: false,
				fourth: false
			},
			actualStep: null,
			moneyConfig: {
				decimal: ",",
				thousands: ".",
				prefix: "$ ",
				suffix: "",
				precision: 2,
				masked: false
			}
		};
	},
	validations: {
		caracteristicas: {
			amount: {
        required
			},
			opt_category: {
				required
			},
			opt_develop: {
				required
			},
			opt_funds: {
				required
			},
			opt_type: {
				required
			}
		},
		informacoes: {
			title: {
				required
			},
			description: {
				required
			},
			country_id: {
				required
			},
			finishAt: {
				required
			}
		}
	},
	computed: {
		...mapState(["user"])
	},
	methods: {
		uploadImage() {
			this.loadingImg = true;
			let data = {
				image: this.imageToUpload,
				title: this.informacoes.title
			};
			global
				.$post("/campaign/cover", data, this.user.token)
				.then(response => {
					this.coverUrl = response.data.cover_url;
					this.steps.fourth = true;
					this.moveStep("forth", "fifth");
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				})
				.finally(() => {
					this.loadingImg = false;
				});
		},

		pickImg(evt) {
			this.steps.fourth = false;
			let reader = new FileReader();
			this.imageToUpload = evt.target.files[0];
			reader.onload = e => {
				this.base64File = e.target.result;
			};
			reader.readAsDataURL(evt.target.files[0]);
		},
		getValidationClassSecond(fieldName) {
			const field = this.$v.caracteristicas[fieldName];
			if (field) {
				return {
					"md-invalid": field.$invalid && field.$dirty
				};
			}
		},
		validateSecond() {
			this.$v.caracteristicas.$touch();
			if (!this.$v.caracteristicas.$invalid) {
				this.secondError = null;
				this.moveStep("second", "third");
			} else {
				this.steps.second = false;
				this.secondError = "Reveja as informações";
			}
		},
		getValidationClassThird(fieldName) {
			const field = this.$v.informacoes[fieldName];
			if (field) {
				return {
					"md-invalid": field.$invalid && field.$dirty
				};
			}
		},
		validateThird() {
			this.$v.informacoes.$touch();
			if (!this.$v.informacoes.$invalid) {
				this.thirdError = null;
				this.moveStep("third", "fourth");
			} else {
				this.steps.third = false;
				this.thirdError = "Reveja as informações";
			}
		},
		getOptions() {
			global
				.$get("/campaign/option", {}, this.user.token)
				.then(response => {
					this.options = {
						...response.data
					};
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					alert(validErr ? err.response.data.error : "INVALID_ERROR"); // enviar alerta
				});
		},
		createcampaign() {
			this.loadingcampaign = true;
			let self = this;
			if (this.$v.caracteristicas.$invalid) {
				this.$v.caracteristicas.$touch();
				this.steps.second = false;
				this.moveStep("fourth", "second");
				this.secondError = "Reveja as informações";
				return false;
			}
			if (this.$v.informacoes.$invalid) {
				this.$v.informacoes.$touch();
				this.steps.third = false;
				this.moveStep("fourth", "third");
				this.thirdError = "Reveja as informações";
				return false;
			}
			if (
				!this.secondError &&
				!this.thirdError &&
				Object.values(this.objetivo).includes(true)
			) {
				this.objetivo.allow_funds = this.objetivo.allow_funds * 1;
				this.objetivo.allow_speedup = this.objetivo.allow_speedup * 1;
				this.objetivo.allow_presale = this.objetivo.allow_presale * 1;
				this.objetivo.allow_share = this.objetivo.allow_share * 1;
				this.informacoes.isStarted = this.informacoes.isStarted * 1;
				this.informacoes.allow_other_country =
					this.informacoes.isCountryShared * 1;

				let data = {
					...this.objetivo,
					...this.caracteristicas,
					...this.informacoes,
					finishAt: this.informacoes.finishAt
						? this.informacoes.finishAt.toISOString()
						: null,
					startAt: this.informacoes.startAt
						? this.informacoes.startAt.toISOString()
						: null,
					cover_url: this.coverUrl
				};

				global
					.$post("/campaign/create", data, this.user.token)
					.then(response => {
						this.campaignCreated = true;
					})
					.catch(err => {
						let validErr =
							err &&
							err.response &&
							err.response.data &&
							err.response.data.error;
						// alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
					})
					.finally(() => {
						this.loadingcampaign = false;
					});
			}
		},

		moveStep(actual, next) {
			this.steps[actual] = true;
			if (next) {
				this.actualStep = next;
			}
		}
	},
	mounted() {
		this.getOptions();
	}
};
</script>

<style lang="scss">
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.md-upload-btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 8px 20px;
  border-radius: 0px;
  font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}


.md-card.md-theme-default {
	margin: 30px;
}

.md-empty-state-icon-first > div > .md-empty-state-icon {
	color: var(
		--md-theme-default-icon-on-background,
		rgba(0, 0, 0, 0.08)
	) !important;
	width: 160px;
	position: relative;
	top: 50px;
	min-width: 160px;
	height: 24px;
	font-size: 160px !important;
	margin: 0;
}
#img-picker {
	//  display: none;
}
.img-preview {
	padding: 1rem;
	img {
		border-radius: 2px;
		max-width: 300px;
		height: auto;
	}
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
</style>
