<template>
	<div class="page-container">
		<md-app style="min-height: 100vh;" md-mode="fixed">
			<md-app-toolbar class="topbar" style="background:white">
				<div class="md-toolbar-section-start">
					<md-button class="md-icon-button">
						<md-icon>menu</md-icon>
					</md-button>
					<span class="md-title">{{$route.name}}</span>
				</div>
				<div class="md-toolbar-section-end">
					<md-button class="md-icon-button">
						<md-icon>notifications</md-icon>
					</md-button>
					<md-button class="md-icon-button">
						<md-icon>settings</md-icon>
					</md-button>
				</div>
			</md-app-toolbar>

			<md-app-drawer md-permanent="full" class="md-elevation-0">
				<md-toolbar class md-elevation="0" style="background:white">
					<img src="http://gofunder.io/static/img/logo.8941ded.png">
				</md-toolbar>
				<md-divider></md-divider>
				<md-subheader>Navigation</md-subheader>
				<md-list>
					<router-link to="/campaigns">
						<md-list-item
							v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/campaigns'}"
						>
							<md-icon>send</md-icon>
							<span class="md-list-item-text">My campaigns</span>
						</md-list-item>
					</router-link>
					<router-link to="/create">
						<md-list-item
							v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/create'}"
						>
							<md-icon>add</md-icon>
							<span class="md-list-item-text">Create new campaign</span>
						</md-list-item>
					</router-link>

					<a href="#" @click="logout()">
						<md-list-item class="nav-item">
							<md-icon>close</md-icon>
							<span class="md-list-item-text">Logout</span>
						</md-list-item>
					</a>
				</md-list>

				<md-divider></md-divider>

				<md-divider></md-divider>

				<md-divider></md-divider>

				<!--<md-divider></md-divider>
				<md-list class="md-triple-line">
					<router-link to="/edit">
						<md-list-item>
							<md-avatar>
								<img src="https://www.raspberrypi.org/wp-content/uploads/2014/09/IMG_4456.jpg" alt="People">
							</md-avatar>

							<div class="md-list-item-text">
								<span>Coffee When Wakeup</span>

								<span>12 Investors</span>
								<md-progress-bar md-mode="determinate" :md-value="15"></md-progress-bar>
							</div>
						</md-list-item>
					</router-link>

					<md-divider></md-divider>
					<router-link to="/edit">
						<md-list-item>
							<md-avatar>
								<img
									src="http://www.coffeeshopexpo.co.uk/showimages/rural_blogs/topimage/ruralblog_7469.jpg"
									alt="People"
								>
							</md-avatar>

							<div class="md-list-item-text">
								<span>Coffee When Wakeup</span>
								<span>17 Investors</span>
								<md-progress-bar md-mode="determinate" :md-value="22"></md-progress-bar>
							</div>
						</md-list-item>
					</router-link>
				</md-list>
				<md-divider></md-divider>!-->

			</md-app-drawer>
			<md-app-content>
				<router-view></router-view>
			</md-app-content>
		</md-app>
	</div>
</template>



<script>
import { mapGetters, mapActions, mapState } from "vuex";

export default {
	name: "ListTypes",
	computed: {
		...mapGetters({
			isUserLogged: "user/isUserLogged"
		}),
		...mapState(["user"])
	},
	data() {
		return {
			intervalTimer: false
		};
	},
	methods: {
		...mapActions("user", ["userLogout", "userSet"]),
		logout() {
			this.userLogout();
			location.href = "/login";
		},
		checkLogin() {
			if (!this.isUserLogged) {
				this.logout();
			}
			global
				.$post("/Auth/check", {}, this.user.token)
				.then(res => {
					this.userSet(res);
				})
				.catch(() => {
					this.logout();
				});
		}
	},
	mounted() {
		this.checkLogin();
		this.intervalTimer = setInterval(this.checkLogin, 10000);
	},
	beforeDestroy() {
		clearInterval(this.intervalTimer);
	}
};
</script>

