<template>

	<b-modal id="modal3" :title="popup.title" :size="popup.size" hide-footer="true" >
		<div class="container wrap-popup">
			<b-row>
				<b-col lg="12">
					<div class="center">
						<div class="status">
							<div class="stat">
								<div id="circle1" class="circle" :class="{ 'active' : concept}">
									<font-awesome-icon :icon="['far', 'lightbulb']"/>
								</div>
								<div id="title1" class="title">
									<span>CONCEITO</span>
								</div>
							</div>
							<div class="stat">
								<div id="circle2" class="circle" :class="{ 'active' : prototype}">
									<font-awesome-icon :icon="['fas', 'wrench']"/>
								</div>
								<div id="title2" class="title">
									<span>CONCEITO</span>
								</div>
							</div>
							<div class="stat">
								<div id="circle3" class="circle" :class="{ 'active' : making}">
									<font-awesome-icon :icon="['fas', 'industry']"/>
								</div>
								<div id="title3" class="title">
									<span>CONCEITO</span>
								</div>
							</div>
							<div class="stat">
								<div  id="circle4" class="circle" :class="{ 'active' : delivery}">
									<font-awesome-icon :icon="['fas', 'truck']"/>
								</div>
								<div id="title4" class="title">
									<span>CONCEITO</span>
								</div>
							</div>
						</div>
					</div>
				</b-col>
			</b-row>
			<b-row >
				<b-col lg="12">
					<div class="content">
						<div class="title center">
							<span class="orange">{{description}}</span>
						</div>
						<div class="subtitle center">
							<span class="subcenter">Os desafios do desenvolvimento podem afetar a capacidade de entrega do produto. <a href="#">Saiba mais</a></span>
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
				concept: false,
				prototype: true,
				making: false,
				delivery: false,
				description: 'Esta campanha criou apenas uma demonstração do produto.'
			}
		}
	}

</script>

<style lang="scss" scoped>
	
@import "Styles/colors.scss";

.row {
    height: 100px;
}

.status {
	width: 75%;
	height: 50px;
	position: relative;

}

.status:before {
	content: '';
	position: absolute;
	top: 50%;
	left: 0;
	border-top: 1px dotted $orange;
	width: 100%;
	transform: translateY(-50%);
}

.stat {
	.circle {
		position: absolute;
		width: 50px;
		height: 50px;
		background-color: white;
		border-radius: 50px;
		border: 1px solid #cfcfcf;

		svg {
			position: absolute;
	    	left: 0px;
	    	right: 0px;
	    	bottom: 0px;
	    	top: 0px;
	    	margin: auto; 
	    	font-size: 24px;
	    	color: #cfcfcf;

		}
	}

	.title {
		position: absolute;
    	bottom: -30px;
    	margin: auto; 
    	font-size: 16px;
    	color: darkgray;
	}
}

.active {
	background-color: $orange!important;
	border-color: $orange!important;
	svg {
		color: white!important;
	}
}

#circle1 {
	left: 0px;
}
#title1 {
	left: -14px;
}
#circle2 {
	left: 30%;
}
#title2 {
	left: 27%;
}
#circle3 {
	right: 30%;
}
#title3 {
	right: 27%;
}
#circle4 {
	right: 0px;
}
#title4 {
	right: -14px;
}

.content {
	.subcenter {
		text-align:center;
		width: 68%; 
		font-size: 18px;
	}
}
	
@media only screen and (max-width: 768px) {

	.row {
	    height: auto!important;
	}

	.status {
		width: 100%;
		.title {
	    	font-size: 12px;
		}
	} 
	
	.content {
		margin-top: 40px;
		.title {
			line-height: 20px;
			text-align: center;
			font-size: 24px; 
		}
		.subcenter {
			width: 100%;
			line-height: 20px;
			margin-top: 15px;
		}
	}

	#circle1 {
		left: 0px;
	}
	#title1 {
		left: -5px;
	}
	#circle2 {
		left: 28%;
	}
	#title2 {
		left: 26%;
	}
	#circle3 {
		right: 28%;
	}
	#title3 {
		right: 27%;
	}
	#circle4 {
		right: 0px;
	}
	#title4 {
		right: -5px;
	}

}
	
</style>