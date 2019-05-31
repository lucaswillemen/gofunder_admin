<template class=" md-grutter">
	<md-tabs class="md-primary">
		<md-tab id="tab-usd" md-label="Retirada em USD" md-icon="monetization_on">
			<div class="md-layout md-grutter">

				<md-dialog-confirm
					:md-active.sync="confirmUsd"
					md-title="Tem certeza que deseja sacar este valor?"
					:md-content="'O valor total(valor + taxa) a ser descontado será de: <strong>$'+totalAmountUsd+'</strong> <br><br> Taxa: 1% do valor a ser sacado'"
					md-confirm-text="Ok"
					md-cancel-text="Cancelar"
					@md-cancel="confirmUsd = false"
					@md-confirm="withdrawUsd()" />

					<md-dialog-confirm
					:md-active.sync="confirmBtc"
					md-title="Tem certeza que deseja sacar este valor?"
					:md-content="'O valor total(valor + taxa) a ser descontado será de: <strong>$'+totalAmountBtc+'</strong> <br><br> Taxa: 1% do valor a ser sacado'"
					md-confirm-text="Ok"
					md-cancel-text="Cancelar"
					@md-cancel="confirmBtc = false"
					@md-confirm="withdrawBtc()" />

					<md-dialog-alert
						:md-active.sync="alertError"
						md-title="Erro ao tentar efetuar saque!"
						:md-content="alertErrorMsg" />

				<form novalidate class="md-layout">
					<md-card class="md-layout-item">
						<md-card-header>
							<h4 class="header_title">Saldo disponível para retirada: {{user.usd | currency}}</h4>
						</md-card-header>

						<md-card-content>
							Preencha suas informações corretamente abaixo para abrir um pedido de retirada.
							<br>Caso o país de retirada não aceite dólares será efetuado um depósito via SWIFT, ficando a cargo do usuário a conversão
							<br>
							<br>
							<div class="md-layout md-gutter">
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.country.$invalid && $v.usdWithdraw.country.$dirty}">
										<label for="bankAcc">Pais: *</label>
										<md-input id="country" v-model="usdWithdraw.country"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.country.required">Digite o país de destino</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.bank.$invalid && $v.usdWithdraw.bank.$dirty}">
										<label for="bank">Banco: *</label>
										<md-input id="bank" v-model="usdWithdraw.bank"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.bank.required">O nome do banco beneficiário é obrigatório</span>
										<span class="md-error" v-if="!$v.usdWithdraw.bank.numeric && $v.usdWithdraw.bank.$dirty">Insira apenas números!</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.swift.$invalid && $v.usdWithdraw.swift.$dirty}">
										<label for="swift">SWIFT: *</label>
										<md-input id="swift" v-model="usdWithdraw.swift"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.swift.required">O código SWITF é obrigatória</span>
									</md-field>
								</div>
							</div>

							<div class="md-layout md-gutter">
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.account.$invalid && $v.usdWithdraw.account.$dirty}">
										<label for="bankAcc">Conta Bancária ou IBAN: *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.account"></md-input>
										<span
											class="md-error"
											v-if="!$v.usdWithdraw.account.required"
										>A conta bancária ou IBAN é obrigatória</span>
										<span class="md-error" v-if="!$v.usdWithdraw.account.numeric">Insira apenas números!</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.doc.$invalid && $v.usdWithdraw.doc.$dirty}">
										<label for="document">Documento Beneficiário: *</label>
										<md-input id="document" v-model="usdWithdraw.doc"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.doc.required">O doc é obrigatório</span>
									</md-field>
								</div>
							</div>

							<div class="md-layout md-gutter">
								<div class="md-layout-item md-size-50">
									<md-field :class="{'md-invalid': $v.usdWithdraw.value.$invalid && $v.usdWithdraw.value.$dirty}">
										<label for="value"></label>
										<money id="value" v-model="usdWithdraw.value" class="md-input" v-bind="moneyConfig"></money>
										<span class="md-error" v-if="!$v.usdWithdraw.value.required">O valor é obrigatório</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.name.$invalid && $v.usdWithdraw.name.$dirty}">
										<label for="name">Nome Beneficiário: *</label>
										<md-input id="name" v-model="usdWithdraw.name"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.name.required">o nome é obrigatório</span>
									</md-field>
								</div>
							</div>
							<div class="md-layout md-gutter"></div>
						</md-card-content>
						<md-card-actions>
							<md-button
								:disabled="usdWithdraw.value <= 0"
								type="submit"
								@click.prevent="openConfirmUsd()"
								class="md-raised md-roxo"
							>Fazer pedido de retirada</md-button>
						</md-card-actions>
					</md-card>
				</form>
			</div>
		</md-tab>
		<md-tab id="tab-btc" md-label="Retirada em BTC" md-icon="cloud_done">
			<form novalidate class="md-layout">
				<md-card class="md-layout-item">
					<md-card-header>
						<h4
							class="header_title"
						>Saldo disponível para retirada: {{parseFloat(user.btc).toFixed(8)}} BTC</h4>
					</md-card-header>

					<md-card-content>
						Preencha seu endereço para retirada nos campos abaixo
						<br>Transações em Bitcoin levam até 1 hora para ser confirmadas pela rede
						<br>
						<br>
						<div class="md-layout md-gutter">
							<div class="md-layout-item md-small-size-100">
								<md-field :class="{'md-invalid': $v.btcWithdraw.addr.$invalid && $v.btcWithdraw.addr.$dirty}">
									<label for="bankAcc">Endereço Bitcoin: *</label>
									<md-input id="bankAcc" v-model="btcWithdraw.addr"></md-input>
									<span class="md-error" v-if="!$v.btcWithdraw.addr.required">O endereço em BTC é obrigatório</span>
								</md-field>
							</div>
						</div>

						<div class="md-layout md-gutter">
							<div class="md-layout-item md-size-50">
								<md-field :class="{'md-invalid': $v.btcWithdraw.value.$invalid && $v.btcWithdraw.value.$dirty}">
									<label for="value"></label>
									<money id="value" v-model="btcWithdraw.value" class="md-input" v-bind="btcConfig"></money>
									<span class="md-error" v-if="!$v.btcWithdraw.value.required">O valor é obrigatório</span>
								</md-field>
							</div>
						</div>

						<div class="md-layout md-gutter"></div>
					</md-card-content>
					<md-card-actions>
						<md-button
							:disabled="btcWithdraw.value <= 0"
							type="submit"
							@click.prevent="openConfirmBtc()"
							class="md-raised md-roxo"
						>Fazer pedido de retirada</md-button>
					</md-card-actions>
				</md-card>
			</form>
		</md-tab>
	</md-tabs>
</template>
<script>
import { mapState, mapActions } from "vuex";
import { required, numeric } from "vuelidate/lib/validators";
export default {
	name: 'Withdraw',
	data() {
		return {
			alertError: false,
			alertErrorMsg: null,
			confirmBtc: false, 
			confirmUsd: false,
			loading: false,
			btcWithdraw: {
				value: "",
				addr: null
			},
			usdWithdraw: {
				swift: "",
				bank: "",
				name: "",
				doc: "",
				country: "",
				account: "",
				value: ""
			},
			btcConfig: {
				decimal: ".",
				thousands: "",
				prefix: "",
				suffix: " BTC",
				precision: 8,
				masked: false
			},
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
		usdWithdraw: {
			swift: {
				required,
			},
			bank: {
				required,
				numeric
			},
			name: {
				required,
			},
			doc: {
				required,
			},
			country: {
				required,
			},
			account: {
				required,
				numeric
			},
			value: {
				required,
			}
		},
		btcWithdraw: {
			value: {
				required,
			},
			addr: {
				required
			}
		},
	},
	computed: {
		...mapState(["user"]),
		totalAmountUsd() {
			return this.usdWithdraw.value + ((1/100) * this.usdWithdraw.value)
		},
		totalAmountBtc() {
			return parseFloat(this.btcWithdraw.value + ((1/100) * this.btcWithdraw.value)).toFixed(8)
		},
	},
	methods: {
    ...mapActions('user', ['userSet']),
		withdrawBtc() {
				this.loading = true
				global.$post("/Withdraw/withdrawBtc",{ amount: this.btcWithdraw.value, address: this.btcWithdraw.addr}, this.user.token)
				.then(response => {
					this.userSet({btc: response.data.user_amount_btc})
					this.$v.$reset()
					this.resetForm()
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
				.finally(() => {
					this.loading = false
				});
		},
		openConfirmUsd() {
			this.$v.usdWithdraw.$touch();
			if (!this.$v.usdWithdraw.$invalid) 
				this.confirmUsd = true
		},
		openConfirmBtc() {
			this.$v.btcWithdraw.$touch();
			if (!this.$v.btcWithdraw.$invalid) 
				this.confirmBtc= true
		},
		withdrawUsd() {
				this.loading = true
				global.$post("/Withdraw/insertwithdraw",{ amount: this.usdWithdraw.value, withdrawJson: JSON.stringify(this.usdWithdraw)}, this.user.token)
				.then(response => {
					this.userSet({usd: response.data.user_amount})
					this.$v.$reset()
					this.resetForm()
				})
				.catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
				.finally(() => {
					this.loading = false
				});
		},
		resetForm() {
			for (const key in this.usdWithdraw) {
				this.usdWithdraw[key] = ""
			}
			for (const key in this.btcWithdraw) {
				this.btcWithdraw[key] = ""
			}
		}
	},
	mounted() {}
};
</script>


<style>
.header_title {
	color: gray;
	font-size: 21px;
}
</style>