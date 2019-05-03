<template>
<div class="topbar">
	<div class="left">
		<b-breadcrumb class="admin-bc" :items="items"/>
		</b-breadcrumb>
	</div>
  <div class="right">
    <div class="btn-border margins">
      <a :href="'/#/project-info/'+this.$route.params.id" target="_blank"><b-button>Preview</b-button></a>
    </div>
    <div class="btn-border-blue margins">
      <b-button @click="$parent.saveCampaign()">Salvar Campanha</b-button>
    </div>
    <div class="btn-noborder margins">

      <b-button>Revisar e Lançar</b-button>
    </div>
  </div>
</div>
</template>

<script>
	export default {
		props: [ 'items' ]
	}
</script>

<style lang="scss">
.topbar {
	.admin-bc {
		background-color: transparent;
		padding: 5px 10px;
			margin-bottom: 0px;

		.breadcrumb-item + .breadcrumb-item::before {
			content: '>';
			font-size:12px;
		}

		a, span {
			color: gray;
			font-size: 12px;
		}
	}

	.right {
		display: flex;
		margin-top: 5px;

		button {
			height: 22px;
			font-size: 10px;
		}

	}

}

</style>
