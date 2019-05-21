<template>
	<div class="footer">

		<hr>

		<b-container >
			<b-row style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
				<b-col>
					<b-img left :src="logo" alt="image" style="max-width:120px;" />
					<ul class="social-list">
						<li><font-awesome-icon :icon="['fab', 'facebook']" /></li>
						<li><font-awesome-icon :icon="['fab', 'twitter']" /></li>
						<li><font-awesome-icon :icon="['fab', 'instagram']" /></li>
						<li><font-awesome-icon :icon="['fab', 'pinterest']" /></li>
					</ul>
					<span>{{ email }}</span>
					<span>{{ phone }}</span>
				</b-col>
				<b-col>
					<h6>Explore</h6>
					<ul>
						<li><a href="#">O que Fazemos</a></li>
						<li><a href="#">Funding</a></li>
						<li><a href="#">Marketplace</a></li>
					</ul>
				</b-col>
				<b-col>
					<h6>Sobre</h6>
					<ul>
						<li><a href="#">Sobre Nós</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">Segurança</a></li>
						<li><a href="#">Suporte</a></li>
						<li><a href="#">Carreiras</a></li>
						<li><a href="#">Contato</a></li>
					</ul>
				</b-col>
				<b-col>
					<h6>Empreendedores</h6>
					<ul>
						<li><a href="#">Como Funciona</a></li>
						<li><a href="#">Controle Educacional</a></li>
						<li><a href="#">Experts Directory</a></li>
						<li><a href="#">Taxas</a></li>
						<li><a href="#">Empresarial</a></li>
					</ul>
				</b-col>
				<b-col lg='4' sm="12">
					<h6>Newsletter</h6>
					<b-form @submit="onSubmit" @reset="onReset" v-if="show">
						<b-form-input id="name"
							type="text"
							v-model="form.name"
							required
							placeholder="Nome">
						</b-form-input>
						<b-form-input id="email"
							type="email"
							v-model="form.email"
							required
							placeholder="E-mail">
						</b-form-input>
						<b-button type="submit" variant="primary">ENVIAR</b-button>
					</b-form>
				</b-col>
			</b-row>
			<b-row class='fotter-bottom' >
				<b-col lg='6' sm='12' >
					<b-navbar-nav class="h-list left">
						<b-nav-item href="#">@ 2019</b-nav-item>
						<b-nav-item class="no-cursor">|</b-nav-item>
						<b-nav-item href="#">GoFunder | Todos os direitos reservados</b-nav-item>
					</b-navbar-nav>
				</b-col>
				<b-col lg='6' sm='12' >
					<b-navbar-nav class="h-list right">
						<b-nav-item href="#">@ 2019</b-nav-item>
						<b-nav-item class="no-cursor">|</b-nav-item>
						<b-nav-item href="#">Privacidade</b-nav-item>
						<b-nav-item class="no-cursor">|</b-nav-item>
						<b-nav-item href="#">Termos de uso</b-nav-item>
						<b-nav-item class="no-cursor">|</b-nav-item>
						<b-nav-item href="#">Avalie sua Experiência</b-nav-item>
					</b-navbar-nav>
				</b-col>
			</b-row>
		</b-container>
</div>
</template>

<script>
	export default {
		data () {
		return {
			logo: require('Img/logo.png'),
			email: 'hello@gofunder.io',
			phone: '0800 3215 654',
			form: {
				email: '',
				name: '',
				food: null,
				checked: []
			},
			foods: [
			{ text: 'Select One', value: null },
			'Carrots', 'Beans', 'Tomatoes', 'Corn'
			],
			show: true
		}
	},
	methods: {
		onSubmit (evt) {
			evt.preventDefault();
			global.$post("/Newsletter/add", this.form)
        .then(response => {
					console.log(response)
          this.$awn.success("E-mail cadastrado com sucesso!")         
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro!")         
        })
		},
		onReset (evt) {
			evt.preventDefault();
			/* Reset our form values */
			this.form.email = '';
			this.form.name = '';
			this.form.food = null;
			this.form.checked = [];
			/* Trick to reset/clear native browser form validation state */
			this.show = false;
			this.$nextTick(() => { this.show = true });
		}
	}
}

</script>

<style lang="scss">

@import "Styles/colors.scss";

.footer {
	left: 0;
	bottom: 0;
	width: 100%;
}
.footer .container {
	padding-top: 50px;
	padding-bottom: 40px;
}

.social-list {
	list-style: none;
	display: flex;
	padding-left: 0px;
	float:left;
	color: $orange;
	margin-top: 25px;
	font-size: 15px;
}
.social-list li {
	margin-right: 25px;
}

.footer span {
	font-size: 13px;
	float: left;
	color: $blue;
	font-weight: 700;
}

.footer h6 {
	color: $orange;
	font-weight: 700;
}

.footer ul {
	list-style: none;
	padding-left:0px;
	line-height: 20px
}
.footer a {
	color:gray;
	font-size: 12px
}
.footer input {
	height: 28px;
    font-size: 10px;
    margin-bottom: 5px;
}

.footer button {
	width: 100%;
    height: 28px;
    font-size: 10px;
    background-color: $orange;
    border-color: $orange;
}

.footer button:hover {
	background-color: $blue;
    border-color: $blue;
}
.footer hr {
	border-top: 1px solid rgba(0, 0, 0, 0.2)
}

.fotter-bottom a {
	font-size: 10px;
	color: rgba(0, 0, 0, 0.4);
}

.fotter-bottom ul li {
    padding-right: 10px;
}

@media only screen and (max-width: 768px) {

	.footer .container {
		padding-bottom: 20px;
	}

}
</style>
