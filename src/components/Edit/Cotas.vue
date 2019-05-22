<template>
	<main>
		<div class="md-layout-item md-small-size-100 md-size-100">
			<md-card>
				<md-empty-state
					style="padding-bottom: 0 !important;"
					md-icon="find_in_page"
					md-label="Criar uma cota!"
					md-description="Você pode criar cotas para pessoas que fizerem doações para seu produto. Cotas são partes da sua empresa e cada vez que você vender este seu produto no marketplace (após ele ser lançado) parte do valor do produto vendido será revertido para o usuário que doou pra você"
				></md-empty-state>
				<md-card-content style="display:flex; align-items: center; flex-direction: column;">
					<md-checkbox
						id="agree"
						v-model="agree"
					>Você concorda que ja editou tudo que precisava em sua campanha?</md-checkbox>
					<p v-if="agree">
						Ao clicar em enviar campanha você
						<strong>NUNCA MAIS!</strong> poderá editá-la novamente. Apenas envia sua campanha caso tenha certeza que tudo está dentre os conformes!
					</p>
				</md-card-content>
				<md-card-actions>
					<md-button :disabled="!agree" class="md-primary md-raised">Enviar campanha</md-button>
				</md-card-actions>
			</md-card>
		</div>
	</main>
</template>

<script>
export default {
	data() {
		return {
			agree: false
		};
	},
	mounted() {}
};
</script>

<style lang="scss" scoped>
</style>

