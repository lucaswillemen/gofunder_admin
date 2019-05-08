<template>
	<div>
		<md-dialog :md-active.sync="showDialog">
			<md-dialog-title v-if="title">{{title}}</md-dialog-title>
            {{text}}
			<md-dialog-actions>
				<md-button class="md-primary" @click="showDialog = false">Fechar</md-button>
			</md-dialog-actions>
		</md-dialog>
	</div>
</template>

<script>
export default {
	name: "AlertVue",
	data: () => ({
        showDialog: false,
        title: '',
        text: ''
	}),
	methods: {
		alertVue(title, text) {
            this.showDialog = true
            this.title = title 
            this.text = text
		}
	}
};
</script>

<style lang="scss" scoped>
.md-dialog {
	max-width: 768px;
}
</style>