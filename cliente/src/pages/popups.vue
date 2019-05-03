<template>
	<div>
		<main-header></main-header>

		<div class="wrap-pop">
			<b-row>
				<b-col lg="3"></b-col>
				<b-col lg="6" class="popups">
					 <b-btn v-b-modal.modal1>Popoup 1</b-btn>
					 <b-btn v-b-modal.modal2>Popoup 2</b-btn>
					 <b-btn v-b-modal.modal3>Popoup 3</b-btn>
				</b-col>
				<b-col lg="3"></b-col>
			</b-row>
		</div>

		<!-- popups -->
		<popup1></popup1>
		<popup2></popup2>
		<popup3></popup3>

		<main-footer></main-footer>
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

.wrap-pop {

	padding: 60px 0px;

}
	

@media only screen and (max-width: 768px) {

	.popups {
		text-align: center; 
	}	

}
	
</style>