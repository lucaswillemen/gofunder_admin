<template>
	<md-steppers :md-active-step.sync="actualStep" md-linear md-alternative>
		<md-step id="first" :md-label="$f('CREATE::Informações')" :md-editable="steps.first">
			<md-card>
				<md-empty-state
					md-icon="short_text"
					:md-label="$f('CREATE::Informações Básicas')"
					:md-description="`${$f('CREATE::Bem vindo ao nosso criador de campanhas!')} ${$f('CREATE::Preencha as informações abaixo para')} ${$f('CREATE::conhecermos mais sobre a sua campanha')}`"
				></md-empty-state>
				<div style="height:470px;">
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('title')">
							<md-icon>title</md-icon>
							<label>{{"CREATE::Qual o título da sua campanha?" | fix}}</label>
							<md-input style v-model="form.title"></md-input>
							<span class="md-error">{{"CREATE::Digite algo entre 10 e 60 caracteres" | fix}}</span>
							<span class="md-helper-text">{{"CREATE::Escolha um nome bonito e chamativo para sua campanha" | fix}}</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
							
						<md-field :class="getValidationClass('country')">
							<md-icon>public</md-icon>
							<multiselect v-model="form.country" class="select-country" :placeholder="$f('MULTISELECT::Pesquise um país')" label="country_name" track-by="id" :options="options.country" :selectLabel="$f('MULTISELECT::Clique para selecionar')" :selectedLabel="$f('MULTISELECT::Selecionado')" :hideSelected="true">
							 <template slot="noResult">
                    <span><strong>{{"MULTISELECT::Sua pesquisa não encontrou nenhum país, tente novamente" | fix}}</strong></span>
                  </template>
                  <template slot="noOptions">
                    <span><strong>{{"MULTISELECT::Nenhum país encontrado, tente recarregar a página ou contate o administrador" | fix}}</strong></span>
                  </template>
							</multiselect>
							<span class="md-error">{{"CREATE::Escolha qual pais seu produto é produzido" | fix}}</span>
							<span class="md-helper-text">{{"CREATE::Escolha o país de origem da sua campanha" | fix}}</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('description')">
							<md-icon>description</md-icon>
							<label>{{"CREATE::Qual descrição para sua campanha?" | fix}}</label>
							<md-textarea style v-model="form.description"></md-textarea>
							<span class="md-error">{{"CREATE::Digite um resumo entre 34 e 128 caracteres" | fix}}</span>
							<span class="md-helper-text">{{"CREATE::Faça uma breve explicação da sua campanha" | fix}}</span>
						</md-field>
					</div>
					<br>
					<br>

					<div style="width: 290px;margin:auto;">
						<md-button
							class="md-raised"
							@click="moveStep(['title','description','country'], 'first', 'second')">
							{{"CREATE::Avançar para próxima etapa" | fix}}
							<md-icon style="color:white;">arrow_forward</md-icon>
						</md-button>
					</div>
				</div>
			</md-card>
		</md-step>
		<md-step id="second" :md-label="$f('CREATE::Financeiro')" :md-editable="steps.second">
			<md-card>
				<md-empty-state
					class="md-accent"
					md-icon="monetization_on"
					:md-label="$f('CREATE::Informações Financeiras')"
					:md-description="`${$f('CREATE::Antes de criar uma campanha você precisa especificar por qual método você deseja receber pagamentos e quais valores para sua campanha')}`"
				></md-empty-state>
				<div style="height:400px;">
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('amount')">
							<md-icon>attach_money</md-icon>
							<label>{{"CREATE::Qual valor de arredacação pretendido?" | fix}}</label>
							<md-input v-model="form.amount" type="number" min="100"/>
							<span class="md-error">{{"CREATE::O valor de arrecadação não deve ser inferior a $100,00" | fix}}</span>
							<span class="md-helper-text">{{"CREATE::O valor é arrecadado em dólares" | fix}}</span>
						</md-field>
					</div>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('payment_method')">
							<md-icon>attach_money</md-icon>
							<label>{{"CREATE::Escolha a forma de pagamento que seu projeto aceitará" | fix}}</label>
							<md-select v-model="form.payment_method" style="margin-left: 14px;">
								<md-option value="bitcoin">{{"CREATE::Desejo receber em Bitcoin" | fix}}</md-option>
								<md-option value="dollar">{{"CREATE::Desejo receber em Dólar" | fix}}</md-option>
								<md-option value="dollar_and_bitcoin">{{"CREATE::Desejo receber em Dólar e Bitcoin" | fix}}</md-option>
							</md-select>
							<span class="md-error">{{"CREATE::Escolha se deseja aceitar criptomoedas ou não" | fix}}</span>
							<span
								class="md-helper-text"
							>{{"CREATE::Caso escolha receber em criptomoedas as doações em Bitcoin serão estimadas em dólar conforme a cotação do momento" | fix}}</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<md-field :class="getValidationClass('flexible')">
							<md-icon>dashboard</md-icon>
							<label>{{"CREATE::Qual tipo de arrecadação?" | fix}}</label>
							<md-select v-model="form.flexible" style="margin-left: 14px;">
								<md-option value="flexible">{{"CREATE::Arrecadação Flexível" | fix}}</md-option>
								<md-option value="static">{{"CREATE::Arrecadação Fixa" | fix}}</md-option>
								<md-option value="everything_or_nothing">{{"CREATE::Tudo ou Nada" | fix}}</md-option>
							</md-select>
							<span
								class="md-helper-text"
							>{{"CREATE::Arrecadação flexível deixa sua campanha ainda aberta a doações mesmo após ter atingido 100%" | fix}}</span>
						</md-field>
					</div>
					<br>
					<div style="width: 290px;margin:auto;">
						<md-button
							class="md-raised"
							@click="moveStep(['accept_bitcoin','flexible','amount'], 'second', 'third')">
							{{"CREATE::Avançar para próxima etapa" | fix}}
							<md-icon style="color:white;">arrow_forward</md-icon>
						</md-button>
					</div>
				</div>
			</md-card>
		</md-step>

		<md-step id="third" :md-label="$f('CREATE::Produto')" :md-editable="steps.third">
			<md-card>
				<md-empty-state
					md-icon="dashboard"
					class="md-raised"
					:md-label="$f('CREATE::Fale mais do seu produto')"
					:md-description="$f('CREATE::Para nossa empresa conseguir o maior número de arrecadação possível, necessitamos que você especifique mais informações sobre seu produto')"
				></md-empty-state>
				<div style="height:600px;">
					<div style="width: 50%;margin:auto;">
						<div v-if="base64File" class="img-preview">
							<img :src="base64File">
						</div>

						<md-field :class="getValidationClass('cover_url')">
							<label>{{"CREATE::Escolha uma foto para seu produto" | fix}}</label>
							<md-file v-model="form.cover_url" @change="pickImg($event)" accept="image/*"/>
							<span class="md-error">{{"CREATE::Escolha uma imagem válida por favor" | fix}}</span>
							<span class="md-helper-text">{{"CREATE::Uma boa foto ajuda a impulsionar ainda mais sua arrecadação!" | fix}}</span>
						</md-field>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<div class="md-layout md-gutter">
							<div class="md-layout-item">
								<md-field :class="getValidationClass('category')" class="custom-md-field">
									<md-icon>public</md-icon>
									<label>{{"CREATE::Em qual categoria seu produto se encaixa?" | fix}}</label>

									<md-select v-model="form.category" style="margin-left: 14px;">
										<md-option :value="opt.id" v-for="(opt, index) in options.category" :key="index">
											{{"DB::"+opt.name | fix}}
										</md-option>
									</md-select>
									<span class="md-error">{{"CREATE::Escolha qual categoria seu produto se encaixa!" | fix}}</span>
									<span
										class="md-helper-text">
										{{"CREATE::Escolher uma boa categoria ajuda a otimizar sua campanha para os motores de buscas" | fix}}</span>
								</md-field>
							</div>
							<div class="md-layout-item">
								<md-field :class="getValidationClass('product_stage')">
									<md-icon>dashboard</md-icon>
									<label>{{"CREATE::Qual estágio do seu produto?" | fix}}</label>
									<md-select v-model="form.product_stage">
										<md-option value="concept">{{"CREATE::Conceito" | fix}}</md-option>
										<md-option value="prototype">{{"CREATE::Protótipo" | fix}}</md-option>
										<md-option value="production">{{"CREATE::Produção" | fix}}</md-option>
										<md-option value="shipping">{{"CREATE::Pronta entrega" | fix}}</md-option>
									</md-select>
									<span class="md-error">{{"CREATE::Escolha qual estágio do seu produto" | fix}}</span>
									<span
										class="md-helper-text"
									>{{"CREATE::O estágio do seu produto nos ajuda a entender qual seu público alvo para arrecadação" | fix}}</span>
								</md-field>
							</div>
						</div>
					</div>
					<br>
					<div style="width: 50%;margin:auto;">
						<div class="md-layout md-gutter">
							<div class="md-layout-item">
								<md-datepicker v-model="form.startAt" :class="getValidationClass('startAt')" md-immediately class="custom-md-field">
									<label style="border-bottom:none!important;">{{"CREATE::Quando você vai iniciar a campanha?" | fix}}</label>
									<span class="md-error">{{"CREATE::Escolha qual o prazo de finalização da campanha do seu produto" | fix}}</span>
									<span
										class="md-helper-text"
									>{{"CREATE::A partir dessa data sua campanha será publicada e começará a receber fundos" | fix}}</span>
								</md-datepicker>
							</div>
							<div class="md-layout-item">
								<md-datepicker
									v-model="form.finishAt"
									:class="getValidationClass('finishAt')"
									md-immediately class="custom-md-field">
									<label style="border-bottom:none!important;" class="custom-md-field">{{"CREATE::Qual prazo para finalização da campanha?" | fix}}</label>
									<span class="md-error">{{"CREATE::Escolha qual o prazo de finalização da campanha do seu produto" | fix}}</span>
									<span class="md-helper-text">{{"CREATE::A partir dessa data sua campanha será finalizada" | fix}}</span>
								</md-datepicker>
							</div>
						</div>
					</div>
					<br>
					<br>
					<div style="width: 290px;margin:auto;">
						<md-button
							class="md-raised"
							@click="moveStep(['finishAt','product_stage','cover_url'], 'third', 'four')">
							{{"CREATE::Avançar para próxima etapa" | fix}}
							<md-icon style="color:white;">arrow_forward</md-icon>
						</md-button>
					</div>
				</div>
			</md-card>
		</md-step>

		<md-step id="four" :md-label="$f('CREATE::Conteúdo')" :md-editable="steps.four">
			<md-card>
				<div v-if="!loadingSpinner">
					<md-empty-state
						class="md-accent"
						md-icon="check"
						:md-label="$f('CREATE::Por enquanto é isso')"
						:md-description="$f('CREATE::Toda descrição básica sobre seu projeto foi salva e seu projeto foi salvo como um rascunho pois ainda precisamos de mais algumas informações que podem ser preenchidas clicando no botão abaixo')"
					></md-empty-state>
					<div style="height:200px;">
						<div style="width: 290px;margin:auto;">
							<br>
							<md-button class="md-raised" @click="editProject()">
								{{"CREATE::Editar meu projeto"}}
								<md-icon style="color:white;">arrow_forward</md-icon>
							</md-button>
						</div>
					</div>
				</div>
				<div v-if="loadingSpinner" style="height:200px;">
					<br>
					<div class="md-empty-state-container">
						<md-progress-spinner :md-diameter="100" :md-stroke="10" md-mode="indeterminate"></md-progress-spinner>
						<strong class="md-empty-state-label">{{"CREATE::Enviando arquivos..."}}</strong>
					</div>
				</div>
			</md-card>
		</md-step>
		    <md-dialog-alert :md-active.sync="imagemInvalida" :md-content="$f('CREATE::A imagem que você enviou não é válida, clique no campo de enviar imagem e tente escolher outra!')" :md-confirm-text="$f('COMMON::Ok!')" />
	</md-steppers>

</template>
<script>
import { mapGetters, mapActions, mapState } from "vuex";
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Multiselect from 'vue-multiselect'
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
	components: {
		Multiselect
	},
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
				payment_method: null,
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
			payment_method: {
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
				required,
				validFinishDate: function () {
					if(this.form.finishAt < this.form.startAt)
						return false
					return true
				}
			},
			startAt: {
				required,
				validStartDate: function () {
					if(this.form.startAt > this.form.finishAt)
						return false
					return true
				}
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
			this.form.image_upload = null
			this.form.cover_url = null
			this.base64File = null
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
			this.form.startAt = this.form.startAt.toISOString().split('T')[0]
			this.form.finishAt = this.form.finishAt.toISOString().split('T')[0]
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
.custom-md-field {
	label {
		top: 6px !important;
	}
}
.select-country {
	color: black;
	cursor: pointer;
	div[class="multiselect__tags"] {
		border: none !important;
	}
}
.img-preview {
	max-width: 120px;
	margin-left: auto;
	margin-right: auto;
	border-radius: 10px !important;
	margin-bottom: 10px;
}
</style>
