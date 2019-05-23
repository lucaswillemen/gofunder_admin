<template>
	<div>
		<div class="loading-overlay" v-if="loading">
			<md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
		</div>
		<md-steppers :md-active-step.sync="actualStep"  md-alternative>
			<md-step id="first" md-label="Resumo" :md-done.sync="steps.first" >
				<Overview></Overview>
			</md-step>
			<md-step id="second" md-label="Perks" :md-done.sync="steps.second" >
				<Perks></Perks>
			</md-step>
			<md-step id="third" md-label="Cotas" :md-done.sync="steps.third" >

				<Cotas></Cotas>
			</md-step>
			<md-step id="fourth" md-label="Faqs" :md-done.sync="steps.fourth" >
				<Faq></Faq>
			</md-step>
			<md-step id="five" md-label="Galeria" :md-done.sync="steps.five" >
				<Gallery></Gallery>
			</md-step>
			<md-step id="six" md-label="Enviar para análise" :md-done.sync="steps.six" >
				<Analysis></Analysis>
			</md-step>
		</md-steppers>
	</div>
</template>
<script>
import Overview from "@/components/Edit/Overview";
import Perks from "@/components/Edit/Perks";
import Gallery from "@/components/Edit/Gallery";
import Faq from "@/components/Edit/Faq";
import Analysis from "@/components/Edit/Analysis";
import Cotas from "@/components/Edit/Cotas";
export default {
	name: "Edit",
	components: {
		Overview,
		Perks,
		Gallery,
		Faq,
		Analysis,
		Cotas
	},

	data() {
		return {
			steps: {
				first: false,
				second: false,
				third: false,
				fourth: false,
				five: false,
				six: false
			},
			actualStep: 'first',
			loading: false
		};
	},
	methods: {
		showLoading() {
			this.loading = true
		},
		hideLoading() {
			this.loading = false
		},
		loadingState() {
			return this.loading
		}
	}
};
</script>
<style lang="scss" scoped>
.loading-overlay {
	z-index: 10;
	top: 0;
	left: 0;
	right: 0;
	position: absolute;
	width: 100%;
	height: 100%;
	background: rgba(255, 255, 255, 0.9);
	display: flex;
	align-items: center;
	justify-content: center;
}

</style>
