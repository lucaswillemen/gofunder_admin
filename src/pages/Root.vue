<template>
	<div class="page-conatainer">
		<md-app md-mode="fixed">
			<md-app-toolbar class="" style="background:white">
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

			<md-app-drawer md-permanent="full">
				<md-toolbar style="background:white">
					<img src="http://gofunder.io/static/img/logo.8941ded.png">
				</md-toolbar>
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
				<md-list v-for="(campaign, index) in campaigns" :key="index" class="md-triple-line bordered" >
					<router-link :to="'/edit/'+campaign.id">
						<md-list-item>
							<md-avatar>
           			<img :src="'http://25.20.118.56/gofunder/'+campaign.cover_url">
							</md-avatar>

							<div class="md-list-item-text">
								<span>{{campaign.title}}</span>

								<span>{{campaign.number_of_investor}} investidores</span>
          			<md-progress-bar md-mode="determinate" :md-value="(campaign.arrecadation/campaign.amount)*100"></md-progress-bar>

							</div>
						</md-list-item>
					</router-link>
					
				</md-list>
			</md-app-drawer>
			<md-app-content style="padding: 0px;">
				
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
			campaigns: [],
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
		},
		listCampaigns() {
      global.$get("/campaign/getList?user_id="+this.user.id, {}, this.user.token)
        .then(response => {
            this.campaigns = response.data
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
    }
	},
	mounted() {
		this.checkLogin();
		this.listCampaigns();
		this.intervalTimer = setInterval(this.checkLogin, 10000);
	},
	beforeDestroy() {
		clearInterval(this.intervalTimer);
	}
};
</script>
<style lang="scss" scoped>
.bordered {
	&:not(:last-child) {
		border-bottom: 1px solid
			var(--md-theme-default-divider, rgba(0, 0, 0, 0.12));
	}
}
</style>

