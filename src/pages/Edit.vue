<template>
	<div>
		<div class="loading-overlay" v-if="loading">
			<md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
		</div>
		<md-tabs class="md-primary" md-alignment="fixed">
			<md-tab id="tab-pages" md-label="Resumo" md-icon="pages">
				<Overview></Overview>
			</md-tab>
			<md-tab id="tab-gift" md-label="perks" md-icon="card_giftcard">
				<Perks></Perks>
			</md-tab>
			<md-tab id="tab-collections" md-label="Gallery" md-icon="collections">
				<Gallery></Gallery>
			</md-tab>
			<md-tab id="tab-question_answer" md-label="Faqs" md-icon="question_answer">
				<Faq></Faq>
			</md-tab>
			<md-tab id="tab-share" md-label="Social networks" md-icon="share">
				<SocialNetwork></SocialNetwork>
			</md-tab>
		</md-tabs>
	</div>
</template>
<script>
import Overview from '@/components/Edit/Overview'
import Perks from '@/components/Edit/Perks'
import Gallery from '@/components/Edit/Gallery'
import Faq from '@/components/Edit/Faq'
import SocialNetwork from '@/components/Edit/SocialNetwork'
export default {
	name: 'Edit',
	components: {
		Overview,
		Perks,
		Gallery,
		Faq,
		SocialNetwork
	},

	data() {
		return {
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
