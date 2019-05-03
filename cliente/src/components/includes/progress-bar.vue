<template>
	<div>
		<b-progress :max="max">
			<b-progress-bar :value="current">
				{{ current }}%
			</b-progress-bar>
		</b-progress>
	</div>
</template>

<script>
	export default {
		props: [ 'max', 'current' ]
	}
</script>

<style lang="scss">

@import "Styles/colors.scss";

.progress {
	background-color: #cfcfcf;
	margin-bottom:3px;
}

// nao funciona
.progress  div {background-color: $orange;}

@media only screen and (max-width: 768px) {


}

</style>