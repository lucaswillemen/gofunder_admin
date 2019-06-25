<template class=" md-grutter">
	<md-tabs class="md-primary">
		<md-tab id="tab-usd" :md-label="$f('WITHDRAW::Retirada em USD')" md-icon="monetization_on">
			<div class="md-layout md-grutter">

				<md-dialog-confirm
					:md-active.sync="confirmUsd"
					:md-title="$f('WITHDRAW::Tem certeza que deseja sacar este valor?')"
					:md-content="`${$f('WITHDRAW::O valor total(valor + taxa) a ser descontado será de:')}<strong>$${totalAmountUsd}</strong> <br><br> ${$f('WITHDRAW::Taxa: 1% do valor a ser sacado')}`"
					:md-confirm-text="$f('COMMON::Ok')"
					:md-cancel-text="$f('COMMON::Cancelar')"
					@md-cancel="confirmUsd = false"
					@md-confirm="withdrawUsd()" />

					<md-dialog-confirm
					:md-active.sync="confirmBtc"
					:md-title="$f('WITHDRAW::Tem certeza que deseja sacar este valor?')"
					:md-content="`${$f('WITHDRAW::O valor total(valor + taxa) a ser descontado será de:')}<strong>$${totalAmountUsd}</strong> <br><br> ${$f('WITHDRAW::Taxa: 1% do valor a ser sacado')}`"
					:md-confirm-text="$f('COMMON::Ok')"
					:md-cancel-text="$f('COMMON::Cancelar')"
					@md-cancel="confirmBtc = false"
					@md-confirm="withdrawBtc()" />

					<md-dialog-alert
						:md-active.sync="alertError"
						:md-title="$f('WITHDRAW::Erro ao tentar efetuar saque!')"
						:md-content="alertErrorMsg" />

				<form novalidate class="md-layout">
					<md-card class="md-layout-item">
						<md-card-header>
							<h4 class="header_title">{{"WITHDRAW::Saldo disponível para retirada:" | fix}} {{user.usd | currency}}</h4>
						</md-card-header>

						<md-card-content>
							{{"WITHDRAW::Preencha suas informações corretamente abaixo para abrir um pedido de retirada." | fix}}
							<br>{{"WITHDRAW::Caso o país de retirada não aceite dólares será efetuado um depósito via SWIFT, ficando a cargo do usuário a conversão" | fix}}
							<br>
							<br>
							<div class="md-layout md-gutter">
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.country.$invalid && $v.usdWithdraw.country.$dirty}">
										<label for="bankAcc">{{"WITHDRAW::País:" | fix}} *</label>
										<md-input id="country" v-model="usdWithdraw.country"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.country.required">{{"WITHDRAW::Digite o país de destino" | fix}}</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.bank.$invalid && $v.usdWithdraw.bank.$dirty}">
										<label for="bank">{{"WITHDRAW::Banco:" | fix}} *</label>
										<md-input id="bank" v-model="usdWithdraw.bank"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.bank.required">{{"WITHDRAW::O nome do banco beneficiário é obrigatório" | fix}}</span>
										<span class="md-error" v-if="!$v.usdWithdraw.bank.numeric && $v.usdWithdraw.bank.$dirty">{{"WITHDRAW::Insira apenas números!" | fix}}</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.swift.$invalid && $v.usdWithdraw.swift.$dirty}">
										<label for="swift">{{"WITHDRAW::SWIFT:" | fix}} *</label>
										<md-input id="swift" v-model="usdWithdraw.swift"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.swift.required">{{"WITHDRAW::O código SWITF é obrigatório" | fix}}</span>
									</md-field>
								</div>
							</div>

							<div class="md-layout md-gutter">
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.account.$invalid && $v.usdWithdraw.account.$dirty}">
										<label for="bankAcc">{{"WITHDRAW::Conta Bancária ou IBAN:" | fix}} *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.account"></md-input>
										<span
											class="md-error"
											v-if="!$v.usdWithdraw.account.required">
											{{"WITHDRAW::A conta bancária ou IBAN é obrigatória" | fix}}
										</span>
										<span class="md-error" v-if="!$v.usdWithdraw.account.numeric">{{"WITHDRAW::Insira apenas números!" | fix}}</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.doc.$invalid && $v.usdWithdraw.doc.$dirty}">
										<label for="document">{{"WITHDRAW::Documento Beneficiário:" | fix}} *</label>
										<md-input id="document" v-model="usdWithdraw.doc"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.doc.required">{{"WITHDRAW::O doc é obrigatório" | fix}}</span>
									</md-field>
								</div>
							</div>

							<div class="md-layout md-gutter">
								<div class="md-layout-item md-size-50">
									<md-field :class="{'md-invalid': $v.usdWithdraw.value.$invalid && $v.usdWithdraw.value.$dirty}" class="md-focused money-input">
										<label for="value">{{"WITHDRAW::Valor:" | fix}}</label>
										<money id="value" v-model="usdWithdraw.value" class="md-input" v-bind="moneyConfig"></money>
										<span class="md-error" v-if="!$v.usdWithdraw.value.required">{{"WITHDRAW::O valor é obrigatório" | fix}}</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.usdWithdraw.name.$invalid && $v.usdWithdraw.name.$dirty}">
										<label for="name">{{"WITHDRAW::Nome Beneficiário:" | fix}} *</label>
										<md-input id="name" v-model="usdWithdraw.name"></md-input>
										<span class="md-error" v-if="!$v.usdWithdraw.name.required">{{"WITHDRAW::o nome é obrigatório" | fix}}</span>
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
								class="md-raised md-roxo">
								{{"WITHDRAW::Fazer pedido de retirada" | fix}}
							</md-button>
						</md-card-actions>
					</md-card>
				</form>
			</div>
		</md-tab>
		<md-tab id="tab-btc" :md-label="$f('WITHDRAW::Retirada em BTC')" md-icon="cloud_done">
			<form novalidate class="md-layout">
				<md-card class="md-layout-item">
					<md-card-header>
						<h4 class="header_title">
							{{"WITHDRAW::Saldo disponível para retirada:" | fix}} {{parseFloat(user.btc).toFixed(8)}} BTC
						</h4>
					</md-card-header>

					<md-card-content>
						{{"WITHDRAW::Preencha seu endereço para retirada nos campos abaixo" | fix}}
						<br>{{"WITHDRAW::Transações em Bitcoin levam até 1 hora para ser confirmadas pela rede" | fix}}
						<br>
						<br>
						<div class="md-layout md-gutter">
							<div class="md-layout-item md-small-size-100">
								<md-field :class="{'md-invalid': $v.btcWithdraw.addr.$invalid && $v.btcWithdraw.addr.$dirty}">
									<label for="bankAcc">{{"WITHDRAW::Endereço Bitcoin:" | fix}} *</label>
									<md-input id="bankAcc" v-model="btcWithdraw.addr"></md-input>
									<span class="md-error" v-if="!$v.btcWithdraw.addr.required">{{"WITHDRAW::O endereço em BTC é obrigatório" | fix}}</span>
								</md-field>
							</div>
						</div>

						<div class="md-layout md-gutter">
							<div class="md-layout-item md-size-50">
								<md-field :class="{'md-invalid': $v.btcWithdraw.value.$invalid && $v.btcWithdraw.value.$dirty}" class="md-focused money-input">
									<label for="valueBtc">{{"WITHDRAW::Valor:" | fix}}</label>
									<money id="valueBtc" v-model="btcWithdraw.value" class="md-input" v-bind="btcConfig"></money>
									<span class="md-error" v-if="!$v.btcWithdraw.value.required">{{"WITHDRAW::O valor é obrigatório" | fix}}</span>
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
							class="md-raised md-roxo">
							{{"WITHDRAW::Fazer pedido de retirada" | fix}}
						</md-button>
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