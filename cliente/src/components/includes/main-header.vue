<template>
	<div>
		<b-navbar toggleable="false" type="dark" class="primary-nav topbar">
			<b-container class="container-nav">
				<b-navbar-nav class="left-content big2">
					<b-nav-item href="#">{{ email }}</b-nav-item>
					<b-nav-item class="no-cursor">|</b-nav-item>
					<b-nav-item href="#">{{phone}} </b-nav-item>			
				</b-navbar-nav>
				<b-navbar-nav class="ml-auto right-itens">
					<b-nav-item-dropdown right v-if="user.token !== null" class="big">
						<template slot="button-content">
							<img	class="img"	v-bind:src='user && user.img ? this.$apiEndpoint+"/uploads/profile/"+user.img : "/static/anonymous-icon.svg"'>
							<label class="orange">
								<b>{{"MAIN_HEADER::Olá"|fix}}</b>
							</label>
							<label>{{user.name}}</label>
						</template>
						<div class="seta"></div>
						<b-dropdown-item><router-link :to="'/user/'+user.id+'/info/'">{{"MAIN_HEADER::Meu Perfil"|fix}}</router-link></b-dropdown-item>
						<hr>
						<b-dropdown-item><router-link to="/user/edit">{{"MAIN_HEADER::Editar Perfil"|fix}}</router-link></b-dropdown-item>
						<hr>
						<!-- <b-dropdown-item><router-link :to="'/user/'+user.id+'/info/'">{{"MAIN_HEADER::Campanhas"|fix}}</router-link></b-dropdown-item> -->
						<hr>
						<b-dropdown-item @click="logout()">{{"MAIN_HEADER::Deslogar"|fix}}</b-dropdown-item>
					</b-nav-item-dropdown>
				</b-navbar-nav>
			</b-container>
		</b-navbar>
		<b-container class="second-nav">
			<b-row>
				<b-col lg="2">
					<a href="/">
						<b-img center :src="logo" alt="image" class="logo"/>
					</a>
				</b-col>
				<b-col lg="4" class="center">
					<div class="drop-button margins">
						<b-form-input
							v-model="searchText"
							style="height:30px;border-radius:2px;font-size:11.4px;width:200px;"
							:placeholder="$f('MAIN_HEADER::Buscar alguma coisa ...')"
							type="text"
							@keydown.native="searchEnter($event)"
						></b-form-input>
						<div class="btn-border no-radius-left center search">
							<b-button @click="search()">
								<font-awesome-icon icon="search"/>
							</b-button>
						</div>
					</div>
				</b-col>
				<b-col lg="2"></b-col>
				<b-col lg="4" class="center" v-if="user.token === null">
					<div class="btn-border margins">
						<a href="/#/register">
							<b-button>{{"MAIN_HEADER::Registrar-se"|fix}}</b-button>
						</a>
					</div>
					<div class="btn-noborder margins">
						<a href="/#/login">
							<b-button>{{"MAIN_HEADER::Fazer Login"|fix}}</b-button>
						</a>
					</div>
				</b-col>
				<b-col lg="4" class="center" v-if="user.token !== null">
					<div class="btn-noborder-blue margins">
						<!--<a href="/#/register">
            <button type="button" class="btn btn-secondary">Anunciar um produto</button>
						</a>!-->
					</div>
					<div class="btn-noborder margins">
						<a href="/#/user/campaign/create">
							<b-button>{{"MAIN_HEADER::Começar uma campanha"|fix}}</b-button>
						</a>
					</div>
				</b-col>
			</b-row>
		</b-container>
		<hr>
	</div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
	computed: {
		...mapState(["user"])
	},
	data() {
		return {
			interval: null
		};
  },
	methods: {
		...mapActions("user", ["userLogout", "userSet"]),
		searchEnter: function(event) {
			if (event.which === 13) {
				this.search();
			}
		},
		search: function() {
			window.open("/#/projects/" + this.searchText);
		},
		logout: function() {
			this.$router.push({ name: 'Home'}) 
			this.userLogout()
			this.$awn.success($f("MAIN_HEADER::Deslogado com sucesso!"))			
			clearInterval(this.interval)
		},
		isPrivateUrl() {	
			let currentLink = window.location.href
			return	currentLink.search(window.location.host+"/user/") !== -1 
			|| currentLink.search(window.location.host+"/#/user/") !== -1
		},
		userLocalToken() {
			try {
        		let json = JSON.parse(window.localStorage.getItem("vuex"))
				return json.user.token
			} catch (e) {
				return false
			}			
		},
		check: function() {
			global
				.$get("/Auth/check", {}, this.userLocalToken())
				.then(response => {
					this.userSet(response.data)
				})
				.catch(err => {
					if (this.isPrivateUrl()) {
						this.userLogout()
						this.$router.push('/')
					}
				})
		},
		sincronize: function() {
			this.counter++
			if(!this.userLocalToken() && this.user.token)  {
				return this.userLogout()
			}
			if(this.userLocalToken() && (!this.user.token || this.user.token.length < 8))  {
				return this.check()
			}
			if (!this.userLocalToken() && this.isPrivateUrl()) {
				this.userLogout()
				return this.$router.push('/')
			}	
			// a cada 10 segundos
			if(this.counter % 10 == 0) {
				return this.check()
			}
		}
	},
	data() {
		return {
			searchText: "",
			email: "contato@gofunder.io",
			phone: "0800 3215 654",
			logo: require("Img/logo.png"),
			counter: 0
		};
	},
	mounted() {
		this.check()
		this.interval = setInterval(this.sincronize, 1000)
	}
};
</script>

<style lang="scss">
@import "Styles/colors.scss";

.primary-nav {
	background-color: $blue;
	height: 35px;
	font-size: 10px;
	padding: 0;
	.container-nav {
		height: inherit;
	}
	.navbar-nav {
		flex-direction: row !important;
		height: inherit;
	}
}
.primary-nav .left-content {
	// display: -webkit-box;
	// -webkit-box-orient: horizontal;
}
.primary-nav .nav-link {
	color: $bg-color !important;
	padding: 0 5px!important !important;
}
.primary-nav .dropdown-menu {
	margin: 1px;
	font-size: 12px;
	padding: 10px 12px;
}
.primary-nav .dropdown-item {
	font-weight: 600 !important;
	color: $blue !important;
	padding: 2px 0;
}
.primary-nav .navbar-nav .dropdown-menu {
	position: absolute;
}
.primary-nav hr {
	border-bottom: 1px dotted $orange;
	margin-bottom: 0;
	margin-top: 0;
}
.dropdown-item:active,
.primary-nav .dropdown-item.active {
	background-color: white;
}
.primary-nav .seta {
	border-right: 16px solid transparent;
	border-left: 16px solid transparent;
	border-bottom: 11px solid #fff;
	content: " ";
	height: 16px;
	left: 121px;
	position: absolute;
	top: -11px;
	z-index: 2;
}

.second-nav {
	background-color: transparent;
	height: auto;
	padding-top: 12px;
	padding-bottom: 12px;
}
.second-nav {
	font-size: 12px;
	font-weight: 700;
}
.second-nav .left-content,
.second-nav .right-content {
	display: flex;
}
.second-nav .search button {
	padding: 0 9px;
}
hr {
	margin-bottom: 0;
	margin-top: 0;
}
.big {
	font-size: 15px !important;
	height: inherit;
	a {
		height: inherit;
		// padding: 0.07rem 0;
		display: flex;
		align-items: center;
    text-decoration: none;
    color: inherit;
	}
}
.big2 {
	font-size: 13px !important;
}
.topbar {
	.img {
		background-repeat: no-repeat;
		background-size: cover;
		height: 25px;
		width: 25px;
		// margin-top: 3px;
		border-radius: 50px;
		float: left;
	}

	label {
		margin-bottom: 0;
		// margin-top: 5px;
		margin-left: 5px;
	}
}

@media only screen and (max-width: 768px) {
	.primary-nav {
		height: 75px;
	}
	.primary-nav .navbar-nav {
		margin-top: 5px;
	}
	.primary-nav .left-content {
		font-size: 8px;
	}

	.second-nav {
		height: auto;
	}

	.second-nav div[class*="col"] {
		margin-bottom: 20px;
	}
}

.logo {
	max-width: 180px !important;
}
</style>
