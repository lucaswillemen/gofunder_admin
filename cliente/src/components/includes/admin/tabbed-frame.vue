<template>
	<div class="tabbed-frame">
		<b-tabs>
			<b-tab title="Projeto" class="tabs" active>
				<div class="tab-wrap">
					<div class="title">
						<span>ATOM</span>
					</div>
					<div class="subtitle">
						<span>Reinvented 3-axis phone gimbal</span>
					</div>
					<div class="text">
						<span>The ATOM is the smallest 3-axis smartphone gimbal with a foldable structure, which provides great portability, rich fantastic functionality and expanded App extensions.</span>
					</div>
					<div class="img">
						<img :src="fin2">
					</div>
					<div class="img">
						<img :src="fin3">
					</div>
					<div class="title">
						<span>Foldable & Portable</span>
					</div>
					<div class="text">
						<span>The ATOM is the smallest 3-axis smartphone gimbal with a foldable structure, which provides great portability, rich fantastic functionality and expanded App extensions.</span>
					</div>
					<div class="img">
						<img :src="fin4">
					</div>
					<div class="img">
						<img :src="fin5">
					</div>
				</div>
			</b-tab>
			<b-tab title="Atualizações" >
				I'm the second tab content
			</b-tab>
			<b-tab title="Comentários">
				Disabled tab!
			</b-tab>
			<b-tab title="Apoiadores">
				Disabled tab!
			</b-tab>
		</b-tabs>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				

			}
		},
	}

</script>

<style lang="scss">

@import "Styles/colors.scss";

.tabbed-frame {

	.tabs {

		ul {
			border-bottom: none!important;

			li {

				font-size: 13px;
				font-weight: 600;

				.nav-link {
					color: $blue;
					border-left: 1px solid $orange;
					border-radius: 0px;
					border-top: none;
					border-bottom: none;
					padding: 4px 25px;
				}

				.active {
					color: $orange;
					background-color: transparent;
				}
			}	
		}
		
	}

	.tab-wrap {
		margin-top: 10px;
		border: 1px solid $orange;
		padding: 20px;
		border-radius:5px;
	}

}


@media only screen and (max-width: 768px) {



}

</style>