<template class=" md-grutter">
	<md-tabs class="md-primary">
		<md-tab id="tab-usd" md-label="Retirada em USD" md-icon="monetization_on">
			<div class="md-layout md-grutter">
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
									<md-field :class="{'md-invalid': $v.country.$invalid && $v.country.$dirty}">
										<label for="bankAcc">Pais: *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.country"></md-input>
										<span class="md-error" v-if="!$v.country.required">Digite o país de destino</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.bank.$invalid && $v.bank.$dirty}">
										<label for="bankAcc">Banco: *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.bank"></md-input>
										<span class="md-error" v-if="!$v.bank.required">O nome do banco beneficiário é obrigatório</span>
										<span class="md-error" v-if="!$v.bank.numeric">Insira apenas números!</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.swift.$invalid && $v.swift.$dirty}">
										<label for="bankAcc">SWIFT: *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.swift"></md-input>
										<span class="md-error" v-if="!$v.swift.required">O código SWITF é obrigatória</span>
									</md-field>
								</div>
							</div>

							<div class="md-layout md-gutter">
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.bankAccount.$invalid && $v.bankAccount.$dirty}">
										<label for="bankAcc">Conta Bancária ou IBAN: *</label>
										<md-input id="bankAcc" v-model.number="usdWithdraw.account"></md-input>
										<span
											class="md-error"
											v-if="!$v.bankAccount.required"
										>A conta bancária ou IBAN é obrigatória</span>
										<span class="md-error" v-if="!$v.bankAccount.numeric">Insira apenas números!</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.cpf.$invalid && $v.cpf.$dirty}">
										<label for="bankAcc">Documento Beneficiário: *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.doc"></md-input>
										<span
											class="md-error"
											v-if="!$v.cpf.required"
										>O número de documento do titular (CPF, RG ou Carteira Motorista) é obrigatória</span>
									</md-field>
								</div>
							</div>

							<div class="md-layout md-gutter">
								<div class="md-layout-item md-size-50">
									<md-field :class="{'md-invalid': $v.value.$invalid && $v.value.$dirty}">
										<label for="value"></label>
										<money id="value" v-model="usdWithdraw.value" class="md-input" v-bind="moneyConfig"></money>
										<span class="md-error" v-if="!$v.value.required">O valor é obrigatório</span>
									</md-field>
								</div>
								<div class="md-layout-item md-small-size-100">
									<md-field :class="{'md-invalid': $v.name.$invalid && $v.name.$dirty}">
										<label for="bankAcc">Nome Beneficiário: *</label>
										<md-input id="bankAcc" v-model="usdWithdraw.name"></md-input>
										<span class="md-error" v-if="!$v.name.required">o nome é obrigatória</span>
									</md-field>
								</div>
							</div>
							<div class="md-layout md-gutter"></div>
						</md-card-content>
						<md-card-actions>
							<md-button
								:disabled="usdWithdraw.value <= 0"
								type="submit"
								@click.prevent="withdraw()"
								class="md-raised md-accent"
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
								<md-field :class="{'md-invalid': $v.addr.$invalid && $v.addr.$dirty}">
									<label for="bankAcc">Endereço Bitcoin: *</label>
									<md-input id="bankAcc" v-model="btcWithdraw.addr"></md-input>
									<span class="md-error" v-if="!$v.addr.required">O endereço em BTC é obrigatório</span>
								</md-field>
							</div>
						</div>

						<div class="md-layout md-gutter">
							<div class="md-layout-item md-size-50">
								<md-field :class="{'md-invalid': $v.value.$invalid && $v.value.$dirty}">
									<label for="value"></label>
									<money id="value" v-model="btcWithdraw.value" class="md-input" v-bind="btcConfig"></money>
									<span class="md-error" v-if="!$v.value.required">O valor é obrigatório</span>
								</md-field>
							</div>
						</div>

						<div class="md-layout md-gutter"></div>
					</md-card-content>
					<md-card-actions>
						<md-button
							:disabled="btcWithdraw.value <= 0"
							type="submit"
							@click.prevent="withdrawBTC()"
							class="md-raised md-accent"
						>Fazer pedido de retirada</md-button>
					</md-card-actions>
				</md-card>
			</form>
		</md-tab>
	</md-tabs>
</template>
<script>
import { mapState } from "vuex";
import { required, numeric } from "vuelidate/lib/validators";
export default {
	data() {
		return {
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
		addr: {
			required
		},
		country: {
			required
		},
		bank: {
			required,
			numeric
		},
		swift: {
			required
		},
		cpf: {
			required
		},
		name: {
			required
		},
		bankAccount: {
			required,
			numeric
		},
		value: {
			required
		}
	},
	computed: {
		...mapState(["user"])
	},
	methods: {
		withdraw() {
			this.$v.$touch();
		},
		withdrawBTC() {
			this.$v.$touch();
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