<template>
	<main>
		<span class="no-pic-message md-layout md-alignment-center-center" v-if="faqList.length == 0">
			<md-card class="mt-layout-item">
				<md-empty-state
					md-icon="question_answer"
					md-label="Frequently asked questions"
					md-description="Answer some basic questions for your investors."
				>
					<md-button class="md-primary md-raised" @click="createFaq = true">Create</md-button>
				</md-empty-state>
			</md-card>
		</span>
		<div class="md-layout md-grutter md-alignment-center-center" v-else>
			<md-card style="min-width: 50%">
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
						<md-button class="md-icon-button" @click="deleteFaq(faq.id)">
							<md-icon>delete</md-icon>
						</md-button>
					</md-list-item>
				</md-list>
			</md-card>
		</div>

		<div class="md-layout md-grutter md-alignment-center-center" v-if="faqList.length != 0">
			<md-button
				:disabled="parentCall && parentCall.loadingState()"
				class="md-fab md-primary"
				@click="createFaq = true"
			>
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
					<md-button
						:disabled="parentCall && parentCall.loadingState()"
						class="md-primary md-raised"
						@click="addFaq()"
					>Add</md-button>
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
					<md-button class="md-primary md-raised" @click="editFaq()">Edit</md-button>
				</md-dialog-actions>
			</md-dialog>
		</div>
	</main>
</template>

<script>
import { mapState } from "vuex";
import { required } from "vuelidate/lib/validators";
export default {
	data() {
		return {
			parentCall: null,
			faqOnEdit: null,
			edittingFaq: false,
			faqEdit: {
				question: null,
				answer: null
			},
			faq: {
				question: null,
				answer: null
			},
			faqList: [],
			createFaq: false
		};
	},
	validations: {
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
		}
	},
	computed: {
		...mapState(["user"])
	},
	methods: {
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
				this.parentCall.showLoading();
				let data = {
					campaign_id: this.$route.params.id,
					question: this.faq.question,
					answer: this.faq.answer
				};
				global
					.$post("/Content/addfaq", data, this.user.token)
					.then(res => {
						this.resetFaq();
						this.loadFaq();
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
		resetFaq() {
			this.edittingFaq = false;
			this.createFaq = false;
			this.$v.faq.$reset();
			this.$v.faqEdit.$reset();
			(this.faq.question = null), (this.faq.answer = null);
		},
		deleteFaq(id) {
			this.parentCall.showLoading();
			let data = {
				id: id
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
					this.parentCall.hideLoading();
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
			if (!this.$v.faqEdit.$invalid) {
				this.parentCall.showLoading();
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
		}
	},
	mounted() {
		this.loadFaq();
		this.parentCall = this.$parent.$parent.$parent.$parent;
	}
};
</script>

<style lang="scss" scoped>
.no-pic-message {
	font-weight: bold;
}
.bordered {
	&:not(:last-child) {
		border-bottom: 1px solid
			var(--md-theme-default-divider, rgba(0, 0, 0, 0.12));
	}
}
</style>
