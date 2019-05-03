<template>

	<b-modal id="modal2" :title="popup.title" :size="popup.size" hide-footer="true" >
		<div class="container wrap-popup">
			<b-row>
				<b-col lg="12">
					<div class="header">
						<div class="title">
							Informe um valor de apoio
						</div>
						<div class="sbs center">
							<div class="btn-border-blue">
								<b-button>Exibir campanhas Anteriores</b-button>
							</div>
							<div class="btn-noborder-blue">
								<b-button>Continuar</b-button>
							</div>
						</div>
						<div class="title">
							<span>Contribuições sem recompensa</span>
						</div>
					</div>
				</b-col>
			</b-row>
		</div>
		<hr>
		<hr>
		<div class="container wrap-popup bottom">
			<div class="contr">
				<b-row>
					<b-col lg="12">
						<div class="info" v-for="rec in recs">
			            	<span class="value">{{rec.value}}</span>
			            	<span class="title">{{rec.title}}</span>
			            	<span v-if="rec.text" class="text" v-html="rec.text">
			            		{{rec.text}}
							</span>
							<div class="">
								<div v-if="rec.itens" class="itens">
									<span  class="title">Itens Incluídos</span>
									<ul >
										<li v-for="item in rec.itens" :key="item.name">{{item.name}}</li>
									</ul>
								</div>
								<div class="delivery">
									<span class="title">Entrega Estimada</span>
									<span class="due-date">{{rec.due_date}}</span>
								</div>
							</div>
							<div class="totals">
								<span>{{rec.qt}} de {{rec.total}} revindicados</span>
							</div>
							<div class="button btn-border-blue">
								<b-button>Pagar Recompensa</b-button>
							</div>
			            </div>
					</b-col>
				</b-row>

			</div>
		</div>
			
		</div>
	</b-modal>
	
</template>

<script>
	
	export default {
		data () {
			return {
				popup: {
					title: 'Apoiar este projeto',
					size: 'lg',
				},
				recs: [
					{
						img: require('Img/financial/rec2.png'),
						category: 'DESTAQUE',
						value: '$ 150,00 USD = Envio $ 285 (30% Off)',
						title: '2 Lentes de foco',
						text: 'The ATOM is the smallest 3-axis smartphone gimbal with a foldable structure, which provides great portability, rich fantastic functionality and expanded App extensions. <br><br> Unlike all other existing 3-axis gimbals on the market which are always huge and troublesome in mounting phones, with ATOM, you can carry it anywhere with ease even put it in your pocket.  In addition, ATOM also provides a series of fantastic functions which enable you to control your filming work with great flexibility.',
						itens: [
							{name: 'Lentes'},
							{name: 'Lentes 02'},
							{name: 'Lentes 02541'},
						],
						due_date: 'Dezembro 2018',
						qt: 25,
						total: 100 
					},
					{
						img: require('Img/financial/rec2.png'),
						category: 'DESTAQUE',
						value: '$ 150,00 USD = Envio $ 285 (30% Off)',
						title: '2 Lentes de foco',
						text: 'The ATOM is the smallest 3-axis smartphone gimbal with a foldable structure, which provides great portability, rich fantastic functionality and expanded App extensions. <br><br> Unlike all other existing 3-axis gimbals on the market which are always huge and troublesome in mounting phones, with ATOM, you can carry it anywhere with ease even put it in your pocket.  In addition, ATOM also provides a series of fantastic functions which enable you to control your filming work with great flexibility.',
						itens: [
							{name: 'Lentes'},
							{name: 'Lentes 02'},
							{name: 'Lentes 02541'},
						],
						due_date: 'Dezembro 2018',
						qt: 25,
						total: 100 
					},
				]
			}
		}
	}

</script>

<style lang="scss" scoped>
	
@import "Styles/colors.scss";

.header {
	text-align: center; 

	.sbs {
		margin-bottom: 40px;
	}
}

.bottom {
	margin-top: 25px;
}

.contr {
	
}

.info {
	margin-top:0px;
	overflow: auto;
	background-color: #f6f6f6;
	border-radius: 5px;
	padding: 20px 25px 25px 25px;
	margin-bottom: 20px;

	.category, .value {
	    font-size: 26px;
	    font-weight: 600;
	    display: block;
	}

	.title {
		font-size: 40px;
	    font-weight: 600;
	    display: block;	
	    color: $blue;
	}

	.text {
		font-size: 18px;
		line-height: 26px;
	}

	.itens, .delivery {
		margin-top:25px;
	    float: left;
	    width: 50%;

	    .title {
	    	font-size: 26px;
	    	font-weight: 600;
	    	margin-bottom: 0px;
	    }

	    ul {
	    	list-style: none;
	    	padding-left: 1px;
	    	margin-bottom: 0px;
	    }

		ul li, .due-date {
			font-size: 18px;
			font-weight: 400;		
		}
	}

	.totals {
		float:left;
		width: 100%;
		margin-top: 20px;
		font-size: 18px;
		font-weight: 600;
	}

	.button {
		width: 100%;
		float:left;
		margin-top: 30px;
	}

	}
	
@media only screen and (max-width: 768px) {

	.user, .social, button {
		float: none!important;
	}

	.user {
	    overflow: auto;
    	width: 100%;
	}

	.list, .boxes {
		display: block;
	}

	.box {margin-bottom:10px;}

	.team {
		.player {
			height: auto;
			padding-bottom: 20px;
		}
		.user {
			width: 100%;
			overflow:auto;
		}
	}

	.sbs {
		display: block;
		button {margin-bottom: 10px;}
	}

}
	
</style>