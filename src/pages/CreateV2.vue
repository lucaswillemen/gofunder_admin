<template>
	<md-steppers :md-active-step.sync="actualStep" md-linear md-alternative>
		<md-step id="first" md-label="Informações" :md-editable="steps.first">
			<md-card>
				<md-empty-state
					md-icon="short_text"
					md-label="Informações Básicas"
					md-description="Bem vindo ao nosso criador de campanhas!
							Preencha as informações abaixo para conhecermos mais sobre a sua campanha"
				></md-empty-state>
				<div style="height:470px;">
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('title')">
							<md-icon>title</md-icon>
							<label>Qual titulo de sua campanha?</label>
							<md-input maxlength="60" style v-model="form.title"/>
							<span class="md-error">Digite algo entre 10 e 60 caracteres</span>
							<span class="md-helper-text">Escolha um nome bonito e chamativo para sua campanha</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('country')">
							<md-icon>public</md-icon>
							<label>Qual país que seu produto será produzido?</label>
							<md-select v-model="form.country">
								<md-option
									:value="opt.id"
									v-for="(opt, index) in options.country"
									:key="index"
								>{{opt.country_name}}</md-option>
							</md-select>
							<span class="md-error">Escolha qual pais seu produto é produzido</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('description')">
							<md-icon>description</md-icon>
							<label>Qual descrição para sua campanha?</label>
							<md-textarea style maxlength="128" v-model="form.description"/>
							<span class="md-error">Digite um resumo entre 34 e 128 caracteres</span>
							<span class="md-helper-text">Faça uma breve explicação da sua campanha</span>
						</md-field>
					</div>
					<br>
					<br>

					<div style="width: 290px;margin:auto;">
						<md-button
							class="md-raised"
							@click="moveStep(['title','description','country'], 'first', 'second')"
						>
							Avançar para próxima etapa
							<md-icon style="color:white;">arrow_forward</md-icon>
						</md-button>
					</div>
				</div>
			</md-card>
		</md-step>
		<md-step id="second" md-label="Financeiro" :md-editable="steps.second">
			<md-card>
				<md-empty-state
					class="md-accent"
					md-icon="monetization_on"
					md-label="Informações Financeiras"
					md-description="Antes de criar uma campanha você precisa especificar por qual método você deseja receber pagamentos e quais valores para sua campanha
"
				></md-empty-state>
				<div style="height:400px;">
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('amount')">
							<md-icon>attach_money</md-icon>
							<label>Qual valor de arredacação pretendido?</label>
							<md-input v-model="form.amount" type="number" min="100"/>
							<span class="md-error">O valor de arrecadação não deve ser inferior a $100,00</span>
							<span class="md-helper-text">O valor é arrecadado em dólares</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('accept_bitcoin')">
							<md-icon>attach_money</md-icon>
							<label>Você deseja receber em criptomoedas?</label>
							<md-select v-model="form.accept_bitcoin">
								<md-option value="yes">Sim, desejo receber em criptos</md-option>
								<md-option value="no">Não, apenas quero receber dólar</md-option>
							</md-select>
							<span class="md-error">Escolha se deseja aceitar criptomoedas ou não</span>
							<span
								class="md-helper-text"
							>Caso escolha receber em criptomoedas as doações em Bitcoin serão estimadas em dólar conforme a cotação do momento</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('flexible')">
							<md-icon>dashboard</md-icon>
							<label>Qual tipo de arrecadação?</label>
							<md-select v-model="form.flexible">
								<md-option value="flexible">Arrecadação Flexível</md-option>
								<md-option value="static">Arrecadação Fixa</md-option>
							</md-select>
							<span
								class="md-helper-text"
							>Arrecadação flexível deixa sua campanha ainda aberta a doações mesmo após ter atingido 100%</span>
						</md-field>
					</div>
					<br>
					<div style="width: 290px;margin:auto;">
						<md-button
							class="md-raised"
							@click="moveStep(['accept_bitcoin','flexible','amount'], 'second', 'third')"
						>
							Avançar para próxima etapa
							<md-icon style="color:white;">arrow_forward</md-icon>
						</md-button>
					</div>
				</div>
			</md-card>
		</md-step>

		<md-step id="third" md-label="Produto" :md-editable="steps.third">
			<md-card>
				<md-empty-state
					md-icon="dashboard"
					class="md-raised"
					md-label="Fale mais do seu produto"
					md-description="Para nossa empresa conseguir o maior número de arrecadação possível, necessitamos que você especifique mais informações sobre seu produto"
				></md-empty-state>
				<div style="height:600px;">
					<div style="width: 50%;margin:auto;">
						<div v-if="base64File" class="img-preview">
							<img :src="base64File">
						</div>

						<md-field :class="getValidationClass('cover_url')">
							<label>Escolha uma foto para seu produto</label>
							<md-file v-model="form.cover_url" @change="pickImg($event)" accept="image/*"/>
							<span class="md-error">Escolha uma imagem válida por favor</span>
							<span class="md-helper-text">Uma boa foto ajuda a impulsionar ainda mais sua arrecadação!</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<div class="md-layout md-gutter">
							<div class="md-layout-item">
								<md-field :class="getValidationClass('category')">
									<md-icon>public</md-icon>
									<label>Qual categoria de produto se encaixa?</label>

									<md-select v-model="form.category">
										<md-option
											:value="opt.id"
											v-for="(opt, index) in options.category"
											:key="index"
										>{{opt.name}}</md-option>
									</md-select>
									<span class="md-error">Escolha qual categoria seu produto se encaixa!</span>
									<span
										class="md-helper-text"
									>Escolher uma boa categoria ajuda a otimizar sua campanha para os motores de buscas</span>
								</md-field>
							</div>
							<div class="md-layout-item">
								<md-field :class="getValidationClass('product_stage')">
									<md-icon>dashboard</md-icon>
									<label>Qual estágio do seu produto?</label>
									<md-select v-model="form.product_stage">
										<md-option value="concept">Conceito</md-option>
										<md-option value="prototype">Protótipo</md-option>
										<md-option value="production">Produção</md-option>
										<md-option value="shipping">Pronta Entrega</md-option>
									</md-select>
									<span class="md-error">Escolha qual estágio do seu produto</span>
									<span
										class="md-helper-text"
									>Estágio do seu produto nos ajuda a entender qual seu público alvo para arrecadação</span>
								</md-field>
							</div>
						</div>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<div class="md-layout md-gutter">
							<div class="md-layout-item">
								<md-datepicker v-model="form.startAt" :class="getValidationClass('startAt')" md-immediately>
									<label style="border-bottom:none!important;">Quando você quer iniciar a campanha?</label>
									<span class="md-error">Escolha qual prazo de finalização da campanha do seu produto</span>
									<span
										class="md-helper-text"
									>A partir dessa data sua campanha será publicada e começara a receber fundos</span>
								</md-datepicker>
							</div>
							<div class="md-layout-item">
								<md-datepicker
									v-model="form.finishAt"
									:class="getValidationClass('finishAt')"
									md-immediately
								>
									<label style="border-bottom:none!important;">Qual prazo para finalização da campanha?</label>
									<span class="md-error">Escolha qual prazo de finalização da campanha do seu produto</span>
									<span class="md-helper-text">A partir dessa data sua campanha será finalizada</span>
								</md-datepicker>
							</div>
						</div>
					</div>
					<br>
					<br>
					<div style="width: 290px;margin:auto;">
						<md-button
							class="md-raised"
							@click="moveStep(['finishAt','product_stage','cover_url'], 'third', 'four')"
						>
							Avançar para próxima etapa
							<md-icon style="color:white;">arrow_forward</md-icon>
						</md-button>
					</div>
				</div>
			</md-card>
		</md-step>

		<md-step id="four" md-label="Conteúdo" :md-editable="steps.four">
			<md-card>
				<div v-if="!loadingSpinner">
					<md-empty-state
						class="md-accent"
						md-icon="check"
						md-label="Por enquanto é isso"
						md-description="Toda descrição básica sobre seu projeto foi salva e seu projeto foi salvo como um rascunho pois
					ainda precisamos de mais algumas informações que podem ser preenchidas clicando no botão abaixo"
					></md-empty-state>
					<div style="height:200px;">
						<div style="width: 290px;margin:auto;">
							<br>
							<md-button class="md-raised" @click="editProject()">
								Ir para edição de meu projeto
								<md-icon style="color:white;">arrow_forward</md-icon>
							</md-button>
						</div>
					</div>
				</div>
				<div v-if="loadingSpinner" style="height:200px;">
					<br>
					<div class="md-empty-state-container">
						<md-progress-spinner :md-diameter="100" :md-stroke="10" md-mode="indeterminate"></md-progress-spinner>
						<strong class="md-empty-state-label">Enviando arquivos ...</strong>
					</div>
				</div>
			</md-card>
		</md-step>
		    <md-dialog-alert :md-active.sync="imagemInvalida" md-content="A imagem que você enviou não é válida, clique no campo de enviar imagem e tente escolher outra!" md-confirm-text="Ok!" />
	</md-steppers>

</template>
<script>
import { mapGetters, mapActions, mapState } from "vuex";
import {
	required,
	minLength,
	maxValue,
	minValue,
	helpers
} from "vuelidate/lib/validators";
import { validationMixin } from "vuelidate";

export default {
	name: "Create",
	mixins: [validationMixin],
	data() {
		return {
			actualStep: 1,
			loadingSpinner: null,
			imagemInvalida: false,
			projectID: 0,
			options: {
				country: [],
				category: []
			},
			form: {
				title: null,
				description: null,
				country: null,
				amount: null,
				flexible: null,
				accept_bitcoin: null,
				cover_url: null,
				product_stage: null,
				finishAt: null,
				startAt: null,
				category: null,
				image_upload: null
			},
			steps: {
				first: true,
				second: false,
				third: false,
				fourth: false
			},
			base64File: null
		};
	},
	computed: {
		...mapState(["user"])
	},
	validations: {
		form: {
			title: {
				required,
				minLength: minLength(10)
			},
			description: {
				required,
				minLength: minLength(30)
			},
			country: {
				required
			},
			amount: {
				required,
				minValue: minValue(100)
			},
			flexible: {
				required
			},
			accept_bitcoin: {
				required
			},
			cover_url: {
				required
			},
			product_stage: {
				required
			},
			category: {
				required
			},
			finishAt: {
				required
			},
			startAt: {
				required
			}
		}
	},
	methods: {
		hasErrorForm(arr) {
			for (var i in arr) {
				if (this.$v.form[arr[i]] && this.$v.form[arr[i]].$invalid) {
					return true;
				}
			}
		},
		pickImg(evt) {
			let reader = new FileReader();
			this.form.image_upload = evt.target.files[0];
			reader.onload = e => {
				this.base64File = e.target.result;
			};
			reader.readAsDataURL(evt.target.files[0]);
		},
		getValidationClass(field) {
			return this.$v.form[field] &&
				this.$v.form[field].$invalid &&
				this.$v.form[field].$dirty
				? "md-invalid"
				: "";
		},
		moveStep(arr, actual, next) {
			this.$v.form.$touch();
			if (!this.hasErrorForm(arr)) {
				this.steps[actual] = true;
				this.actualStep = next;
				this.$v.$reset();
				if (next == "four") {
					this.createCampaign();
					this.steps = {
						first: false,
						second: false,
						third: false,
						fourth: true
					};
					this.loadingSpinner = true;
				}
			}
		},
		getOptions() {
			global
				.$get("/campaign/option", {}, this.user.token)
				.then(response => {
					this.options.country = response.data.country;
					this.options.category = response.data.category;
				})
				.catch(err => {});
		},
		createCampaign() {
			global
				.$post("/campaign/create", this.form, this.user.token)
				.then(response => {
					this.projectID = response.data.id
				})
				.catch(err => {
					this.actualStep = 'third';
					this.steps = {
						first: false,
						second: false,
						third: true,
						fourth: false
					};
					this.imagemInvalida = true
				})
				.finally(err => {
					this.loadingSpinner = false;

				});
		},
		editProject() {
			window.location.href = '/edit/' + this.projectID 
		}
	},
	mounted() {
		this.getOptions();
	}
};
</script>

<style lang="scss">
.img-preview {
	max-width: 120px;
	margin-left: auto;
	margin-right: auto;
	border-radius: 10px !important;
	margin-bottom: 10px;
}
</style>
