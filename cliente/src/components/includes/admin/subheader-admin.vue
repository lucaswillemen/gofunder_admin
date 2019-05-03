<template>
	<div class="subheader-admin">
		<div class="container">
			<b-row>
				<b-col lg="12">
					<div class="labels">
						<!--<div class="label">
							<span><a href="/#/user/config-user">Meu Perfil</a></span>
						</div>
						<div class="label">
							<span><a href="/#/admin/config-edit">Editar Perfil e Configurações</a></span>
						</div>!-->
					</div>
				</b-col>
			</b-row>
		</div>
	</div>
</template>

<script>
	export default {
		// props: [ 'items' ]
	}
</script>

<style lang="scss">

	@import "Styles/colors.scss";

	.subheader-admin {
		height: 50px;
		width: 100%;
		background-color: $orange;
		padding-top: 16px;
		margin-bottom: 20px;

		.labels {
			display: flex;

			.label {

				border-left: 1px solid #ffffffd4;
				padding:0px 20px;
				font-size: 11px;

				a {
					color: #ffffffd4;
				}
			}
		}

	}

</style>
