<template>
	<div class="table">
		<b-table :items="items">			
			<span slot="acoes" slot-scope="data" v-html="data.value"></span>
		</b-table>
	</div>
</template>

<script>
	export default {
		props: [ 'items' ]
	}
</script>

<style lang="scss">

@import "Styles/colors.scss";

	table thead tr th:first-child {
	    border-top-left-radius: 5px!important;
	    border-left: 1px solid $blue!important;
	}
	table thead tr th:last-child {
	    border-top-right-radius: 5px!important;
	    border-right: 1px solid $blue!important;
	}

	table thead tr th:last-child {
		color: transparent;
	}

	table tbody tr:last-child td:first-child {
	    border-bottom-left-radius: 5px;
	}
	table tbody tr:last-child td:last-child {
		border-bottom-right-radius: 5px;
	    border-right: 1px solid $blue!important;
	}

	table tbody tr:last-child td {
		border-bottom: 1px solid $blue!important;
	}

	table tbody tr td:first-child {
		border-left: 1px solid $blue!important;
	}
	table tbody tr td:last-child {
		border-right: 1px solid $blue!important;
	}

	table {
    	background-color: transparent!important;
	 	border-collapse: separate;
	 	border-spacing: 0;

    	thead {
    		th {
    			 border-top: 1px solid $blue!important;
    			border-bottom: none!important;
    			padding-left: 25px!important;
    			font-size: 13px;
    			font-weight: 600;
    			color: $blue;
    		}
    	}

    	tbody {
    		td {
    			border-top: 1px dotted gray!important;
    			border-bottom: none!important;
    			padding-left: 25px!important;
    			font-size: 12px;
    			color: gray;
    			font-weight: 400;
    		}
    	}

    	.acoes {
		    font-weight: 500;
    	}
    	.separator {
		    padding: 0px 5px;
    	}
	}

@media only screen and (max-width: 768px) {

	.table {
		overflow-x: scroll;
	}

}

</style>
