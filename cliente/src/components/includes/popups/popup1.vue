<template>

	<b-modal id="modal1" :title="popup.title" :size="popup.size" hide-footer="true" >
		<div class="container wrap-popup">
			<b-row>
				<b-col lg="12">
					<div class="top">
						<div class="user">
							<div class="img" v-bind:style="{ backgroundImage: 'url(' + user_img  + ')' }"></div>
							<div class="info">
								<div class="title">
									<span>{{user_name}}</span>
									<font-awesome-icon :icon="['far', 'check-circle']"/>
								</div>
								<div class="subtitle">
									<span>{{user_occupation}}</span>
								</div>
							</div>
						</div>
						<div class="social">
							<ul class="social-list" >
								<li v-for='social in socials' :key="social.name">
									<a :href="social.link">
										<font-awesome-icon :icon="['fab', social.name]" />
									</a>
								</li>
							</ul>
							<div class="subtitle">
								<small>{{user_site}}</small>
							</div>
						</div>
					</div>
					<div class="text">
						<span>{{user_text}}</span>
					</div>
				</b-col>
			</b-row>
			<b-row>
				<b-col lg="12">
					<div class="title">
						<span>Informação Verificada</span>
					</div>
					<div class="list">
						<div class="checked" v-for="checked in checkeds" :key="checked.name">
							<font-awesome-icon :icon="['far', 'check-circle']"/>
							<span class="item">
								{{checked.name}}
							</span>
						</div>
					</div>
				</b-col>
			</b-row>
			<b-row>
				<b-col lg="12">
					<div class="title">
						<span>Impacto no Portal</span>
					</div>
					<div class="boxes">
						<div class="box">
							<div class="top">
								<span>{{total_campaings}}</span>
							</div>
							<div class="bottom">
								<span>Campanha</span>
							</div>
						</div>
						<div class="box">
							<div class="top">
								<span>{{amout}}</span>
							</div>
							<div class="bottom">
								<span>Levantado</span>
							</div>
						</div>
						<div class="box">
							<div class="top">
								<span>{{contributions}}</span>
							</div>
							<div class="bottom">
								<span>Contribuições</span>
							</div>
						</div>
					</div>
				</b-col>
			</b-row>
			<b-row>
				<b-col lg="12">
					<div class="btn-border-blue">
						<b-button>Exibir campanhas Anteriores</b-button>
					</div>
				</b-col>
			</b-row>
		</div>	
		<hr>
		<div class="container wrap-popup bottom">
			<b-row>
				<b-col lg="12">
					<div class="main-title">
						<span>Membros do time</span>
					</div>
					<div class="team">
						<div class="player" v-for="player in team">
							<div class="user">
								<div class="img" v-bind:style="{ backgroundImage: 'url(' + player.img  + ')' }"></div>
								<div class="info">
									<div class="title">
										<span>{{player.name}}</span>
										<font-awesome-icon :icon="['far', 'check-circle']"/>
									</div>
									<div class="subtitle">
										<span>{{player.occupation}}</span>
									</div>
								</div>
							</div>
							<div class="social">
								<ul class="social-list" >
									<li v-for='social in player.socials' :key="social.name">
										<a :href="social.link">
											<font-awesome-icon :icon="['fab', social.name]" />
										</a>
									</li>
								</ul>
							</div>
							<div class="btn-border-blue">
								<b-button>Ver Perfil</b-button>
							</div>
						</div>
					</div>
				</b-col>
			</b-row>
		</div>
	</b-modal>
	
</template>

<script>
	
	export default {
		data () {
			return {
				popup: {
					title: 'Sobre',
					size: 'lg',
				},
				user_name: 'Caloi Club',
				user_email: 'caloiclub@gmail.com',
				user_site: 'www.caloiclub.com',
				user_img: require('Img/admin/user.png'),
				user_occupation: 'Ativista / Autor',
				user_text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
				total_campaings: 1,
				amout: '$ 950,003',
				contributions: 3,
				socials: [
					{name: 'facebook-f', link:'#'},
					{name: 'twitter', link:'#'},
					{name: 'instagram', link:'#'},
					{name: 'pinterest-p', link:'#'},
				],
				checkeds: [
					{name: 'E-mail do Proprietário'},
					{name: 'Facebook'},
					{name: 'Linkedin'}
				],
				team: [
					{ 
						name: 'John Smith', 
						occupation:'Ativista',
						img: require('Img/admin/user.png'),
						socials: [
							{name: 'facebook-f', link:'#'},
							{name: 'twitter', link:'#'},
							{name: 'instagram', link:'#'},
							{name: 'pinterest-p', link:'#'},
						]
					},
					{ 
						name: 'Sarah Connor', 
						occupation:'Ativista',
						img: require('Img/admin/user.png'),
						socials: [
							{name: 'facebook-f', link:'#'},
							{name: 'twitter', link:'#'},
							{name: 'instagram', link:'#'},
							{name: 'pinterest-p', link:'#'},
						]
					}
				]
			}
		}
	}

</script>

<style lang="scss" scoped>
	
@import "Styles/colors.scss";


	.user {
		float: left;
    	width: 50%;

		.img {
			width: 80px;
			height: 80px;
			background-size: cover;
		    background-repeat: no-repeat;
		    margin-right: 20px;
		    float: left;
		}

		.title {
			margin-top: 13px;

		}

		svg {
			color:green;
			font-size: 14px;
		}

	}

	.social {
		float:right;

		.social-list {
			// margin-top: 3px;
			margin-bottom: 0px;

			li {
				position: relative;
			    width: 33px;
			    height: 33px;
			    background-color: #c1c1c1;
			   	color: white;
			    border-radius: 3px;
			    margin-right: 7px;
			    cursor: pointer;

			    a { 
			    	color: white;
			    }

			}

			svg {
				position: absolute;
			    top: 0px;
			    bottom: 0px;
			    left: 0;
			    right: 0;
			    margin: auto;
			}

			.active {
				background-color: $orange;
			}
			
		}


	}

	.top {

		

	}

	.list {
		display: flex;

		.checked {
			margin-right: 15px;

			svg {
				color: green;
				font-size: 16px;
			    vertical-align: text-top;
			}

			.item {
				font-size: 19px;
				color: gray;
			}
		}
	}

	.boxes {
		display: flex;

		.box {
			text-align: center; 
			margin-right: 20px;

			.top {
				background-color: $orange;
				border: 1px solid $orange;
				border-top-left-radius: 5px;
				border-top-right-radius: 5px;
				color: white;
				margin-bottom: 0px;
			}

			.bottom {
				border-bottom-left-radius: 5px;
				border-bottom-right-radius: 5px;	
				border: 1px solid gray;
				color: gray;
			}

			.top, .bottom {
				font-size: 16px;
				padding: 3px 20px;
			}

		}
	}

	.team {

		.player {
			height: 100px;
			border-bottom: 1px solid #e8e8e8;
			margin-bottom: 20px;
		}

		.user {
			width: 40%;
		}
		.social {
			float: left;
		}

		button {
			float:right;
			margin-top: 25px;
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
		button {

		}
	}

	#modal1 {
		padding-left: 0px!important;
	}
}
	
</style>