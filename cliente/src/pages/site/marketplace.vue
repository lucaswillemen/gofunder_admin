 <template>
	<div>
		<main-header></main-header>
		
		<div class="marketplace">

			<div class="top">
				<div class="container">
					<b-row class="first-row">
						<b-col lg='6'>
							<!-- <b-breadcrumb :items="items"/>
								<div class="seta"></div>
							</b-breadcrumb> -->

							<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item" :class="{ 'active': i == 0}" v-for="(slide, i) in slides" :key="slide.img"> 
										<img class="d-block w-100" :src="slide.img" >
									</div>
								</div>
								<div class="thumb-control carousel-indicators">
									<div class="thumb" :class="{ 'active': i == 0 }" v-for="(slide, i) in slides" :key="slide.img" v-bind:data-slide-to="i" data-target="#carouselExampleIndicators"> 
										<img :src="slide.img" :class="{ 'first': i == 0 }">
									</div>	
								</div>
								<a href="#carouselExampleIndicators" role="button" data-slide="prev" class="ctrl-left">
									<div class="bg-control">
										<button class="control" data-glide-dir="<">
											<font-awesome-icon icon="chevron-left" />
										</button>
									</div>
								</a>
								<a href="#carouselExampleIndicators" role="button" data-slide="next" class="ctrl-right">
									<div class="bg-control">
										<button class="control" data-glide-dir=">">
											<font-awesome-icon icon="chevron-right" />
										</button>
									</div>
								</a>
							</div>

						</b-col>
						<b-col lg='6'>
							<div class="info">
								<div class="header">
									<span class="category">{{category}}</span>
									<span class="delivery">{{delivery}}</span>
								</div>
								<div class="value">
									<span v-html="value"> {{value}} </span>
								</div>
								<div class="title">
									<span>{{title}}</span>
								</div>
								<div class="text">
									<span >{{text}}</span>
								</div>

								<div class="bottom">
									<div class="owner">
										<div class="img">
											<img :src="owner.img">
										</div>
										<div class="info">
											<span class="name">{{owner.name}}</span>
											<span class="location">{{owner.location}}</span>
											<span class="qt">{{owner.qt}}</span>
										</div>
									</div>
									<div class="btn-social">
										<div class="btn-noborder-blue button"><b-button>Comprar Agora</b-button></div>
										<div class="social">
											<ul class="social-list" >
												<li class="active">
													<font-awesome-icon :icon="['far', 'heart']" />
												</li>
												<li v-for='social in socials' :key="social.name">
													<a :href="social.link">
														<font-awesome-icon :icon="['fab', social.name]" />
													</a>
												</li>
												<li>
													<font-awesome-icon :icon="['fas', 'link']" />
												</li>
												<li>
													<font-awesome-icon :icon="['fas', 'code']" />
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="tags">
									<div class="title">
										<span> Tags <span class="blue">Relacionadas</span></span>
									</div>
									<div class="tag-group">
										<div class="btn-border-blue" v-for="tag in tags" :key="tag.name">
											<b-button>{{tag.name}}</b-button>
										</div>
									</div>
								</div> 
							</div>
						</b-col>
					</b-row> 
					<b-row>
						<b-col lg="6">
							<div class="visao-geral">
								<div class="title">
									<span>VISÃO GERAL</span>
								</div>
								<div class="content">
									<div class="img">
										<img :src="fin1">
									</div>
									<div class="text">
										The ATOM is the smallest 3-axis smartphone gimbal with a foldable structure, which provides great portability, rich fantastic functionality and expanded App extensions.
										<br>
										<br>
										Unlike all other existing 3-axis gimbals on the market which are always huge and troublesome in mounting phones, with ATOM, you can carry it anywhere with ease even put it in your pocket.  In addition, ATOM also provides a series of fantastic functions which enable you to control your filming work with great flexibility.
									</div>
								</div>
							</div>
							<div class="tabs">
								<b-tabs>
									<b-tab title="Projeto" active>
										<div class="projeto">
											<div class="title">
												<span>ATOM</span>
											</div>
											<div class="subtitle">
												<span>Reinvented 3-axis phone gimbal</span>
											</div>
											<div class="text">
												<span>The ATOM is the smallest 3-axis smartphone gimbal with a foldable structure, which provides great portability, rich fantastic functionality and expanded App extensions.</span>
											</div>
											<div class="img">
												<img :src="fin2">
											</div>
										</div>
									</b-tab>
									<b-tab title="Atualizações" >
										Disabled tab!
									</b-tab>
									<b-tab title="Comentários">
									    Disabled tab!
									</b-tab>
									<b-tab title="Apoiadores">
										Disabled tab!
									</b-tab>
								</b-tabs>
							</div>
							
						</b-col>
						<b-col lg="6"></b-col>
					</b-row>
					<b-row>
						<b-col lg="12">
							<div class="more">
								<div class="title">
									<span> Você pode <span class="blue">gostar!</span></span>
								</div>
								<div class="project-group">
									<project-card :projects="projects"></project-card>
								</div>
							</div>
						</b-col>
					</b-row>
				</div>
			</div>

		</div>


		<pre-footer></pre-footer>
		<main-footer></main-footer>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				slides: [
				{ img: require('Img/area-1-imagem-1.png') },
				{ img: require('Img/area-1-imagem-2.png') },
				{ img: require('Img/area-1-imagem-1.png') },
				{ img: require('Img/area-1-imagem-2.png') },
				{ img: require('Img/area-1-imagem-1.png') },
				{ img: require('Img/area-1-imagem-2.png') },
				{ img: require('Img/area-1-imagem-1.png') },
				{ img: require('Img/area-1-imagem-2.png') },
				],
				category: 'Marketplace',
				delivery: 'Entrega Garantida',
				value: "<span class='blue'> $ 18,99 </span> USD + Entrega $27 (33% Off)",
				title: 'ATOM: A pocket-sized 3-axis smartphone gimbal',
				text: 'Super portable, wireless, charging, 310g payload mic jack, one-key swich, zoom and focus control',
				owner: {
					img: require('Img/financial/owner.png'),
					name: 'Caloi Club',
					location: 'New York, USA',
					qt: '1 Campanha'
				},
				socials: [
				{name: 'facebook-f', link:'#'},
				{name: 'twitter', link:'#'},
				{name: 'instagram', link:'#'},
				{name: 'pinterest-p', link:'#'},
				],
				fin1: require('Img/financial/fin1.png'),
				fin2: require('Img/financial/fin2.png'),
				tags: [
					{name: 'Atualizações'},
					{name: 'Design'},
					{name: 'Inovação'},
					{name: 'Videos'},
					{name: 'Design'},
					{name: 'Inovação'},
					{name: 'Design'},
					{name: 'Inovação'},
					{name: 'Design'},
					{name: 'Câmera'},
					{name: 'Produção'},
					{name: 'Conectividade'},
				],
				projects: [
					{
						type: 'Funding',
						type2: 'Lançamento em Breve',
						category: 'Publicação',
						title: 'Revista Comunitária',
						img: require('Img/projetos/proj1.png'),
						text: "Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card",
						counter: 75, max: 100, 
						total: '$ 7.850,65',
						meta: '$ 10.000,00'
					},
					{
						type: 'Marketplace',
						type2: 'Frete Grátis',
						category: 'Travel & Outdoors',
						title: 'Revista Comunitária',
						img: require('Img/projetos/proj2.png'),
						text: "Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card",
						liquid: '$61,00 USD',
						value: '$73',
						discount: '(16% off)'
					},
					{
						type: 'Funding',
						type2: 'Lançamento em Breve',
						category: 'Publicação',
						title: 'Revista Comunitária',
						img: require('Img/projetos/proj3.png'),
						text: "Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card",
						counter: 34, max: 100, 
						total: '$ 7.850,65',
						meta: '$ 10.000,00'
					},
					{
						type: 'Funding',
						type2: 'Lançamento em Breve',
						category: 'Publicação',
						title: 'Revista Comunitária',
						img: require('Img/projetos/proj1.png'),
						text: "Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card",
						counter: 15, max: 100, 
						total: '$ 7.850,65',
						meta: '$ 10.000,00'
					},
				]
			}	
		}
	}
	

</script>

<style lang="scss">

@import "Styles/colors.scss";
@import "Styles/marketplace.scss";	

</style>