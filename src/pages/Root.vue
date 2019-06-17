<template>
<div class="page-conatainer">
  <md-app md-mode="fixed">
    <md-app-toolbar class="backgroundSidebar">
      <div class="md-toolbar-section-start">
        <md-button class="md-icon-button" @click="toggleMenu" v-if="!menuVisible">
          <md-icon style="color:white!important;">menu</md-icon>
        </md-button>
        <span class="md-title" style="color:white;">{{$route.name}}</span>
      </div>
      <div class="md-toolbar-section-end">
        <md-button class="md-icon-button">
          <md-icon style="color:white!important;">notifications</md-icon>
        </md-button>
        <md-button class="md-icon-button">
          <md-icon style="color:white!important;">settings</md-icon>
        </md-button>
        <md-button class="md-icon-button" @click="logout()">
          <md-icon style="color:white!important;">exit_to_app</md-icon>
        </md-button>
      </div>
    </md-app-toolbar>

    <md-app-drawer :md-active.sync="menuVisible" md-persistent="full" class="backgroundSidebar">

      <md-toolbar class="md-transparent" md-elevation="0">

        <div class="md-toolbar-section-end">
          <img style="max-width:180px;" src="https://gofunder.io/static/img/logo.8941ded.png"/>
          <md-button class="md-icon-button md-dense md-raised" @click="toggleMenu">
            <md-icon style="color:white!important;">keyboard_arrow_left</md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <div class="list textoMenu backgroundSidebar">

        <router-link to="/">
          <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/'}">
            <md-icon>home</md-icon>
            <span class="md-list-item-text">Dashboard</span>
          </md-list-item>
        </router-link>

        <router-link to="/profile">
          <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/profile'}">
            <md-icon>person</md-icon>
            <span class="md-list-item-text">Perfil</span>
          </md-list-item>
        </router-link>


        <md-list class="mdListExtend backgroundSidebar">
          <md-list-item md-expand :md-expanded.sync="expandCampanhas">
            <md-icon>view_quilt</md-icon>
            <span class="md-list-item-text">Minhas Campanhas</span>

            <md-list slot="md-expand" class="mdListExtend backgroundSidebar">
              <router-link to="/campaigns">
                <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/campaigns'}">
                  <span class="md-list-item-text">Ver Campanhas</span>
                </md-list-item>
              </router-link>
              <router-link to="/create">
                <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/create'}">
                  <span class="md-list-item-text">Criar Campanhas</span>
                </md-list-item>
              </router-link>
            </md-list>
          </md-list-item>
        </md-list>


<!--
        <md-list-item md-expand :md-expanded.sync="expandProdutos">
          <md-icon>store</md-icon>
          <span class="md-list-item-text">Meus Produtos</span>

          <md-list slot="md-expand" class="mdListExtend backgroundSidebar">
            <router-link to="/campaigns">
              <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/campaigns'}">
                <span class="md-list-item-text">Ver Produtos</span>
              </md-list-item>
            </router-link>
            <router-link to="/create">
              <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/create'}">
                <span class="md-list-item-text">Criar Produtos</span>
              </md-list-item>
            </router-link>
          </md-list>
        </md-list-item>!-->

        <router-link to="/withdraw">
          <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/withdraw'}">
            <md-icon>payment</md-icon>
            <span class="md-list-item-text">Saques</span>
          </md-list-item>
        </router-link>
        <router-link to="/extract">
          <md-list-item v-bind:class="{'nav-item': true, 'active': $router.currentRoute.path=='/extract'}">
            <md-icon>receipt</md-icon>
            <span class="md-list-item-text">Relatórios</span>
          </md-list-item>
        </router-link>
      </div>

    </md-app-drawer>
    <md-app-content style="padding: 0px;">
      <router-view></router-view>
    </md-app-content>
  </md-app>
</div>
</template>



<script>
import {
  mapGetters,
  mapActions,
  mapState
} from "vuex";

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
      alertError: false,
    	alertErrorMsg: null,
      campaigns: [],
      intervalTimer: false,
      menuVisible: true,
      expandCampanhas: false,
      expandPerfil: false,
      expandDoacoes: false,
      expandProdutos: false
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
      global
        .$get("/campaign/getList?user_id=" + this.user.id, {}, this.user.token)
        .then(response => {
          this.campaigns = response.data;
        })
        .catch(err => {
					let validErr =
						err && err.response && err.response.data && err.response.data.error;
					this.alertErrorMsg = validErr ? err.response.data.error : "INVALID_ERROR"; // enviar alerta
					this.alertError = true;
				})
    },
    toggleMenu() {
      this.menuVisible = !this.menuVisible;
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
.nav-item.active {
  border-left: none;
}
.bordered {
    &:not(:last-child) {
        border-bottom: 1px solid var(--md-theme-default-divider, rgba(0, 0, 0, 0.12));
    }
}
.mdListExtend {
    color: white;
    .md-list-item-text {
        font-size: 12px!important;
        margin: 0 auto;
    }
}
.md-list-expand {
    ul {
        li {
            min-height: 10px!important;
        }
    }
}
.textoMenu {
    list-style-type: none;
    span {
        font-family: "Source Sans Pro", sans-serif;
        color: white;
    }
    i {
        color: #fef9e7 !important;
    }
}
.backgroundSidebar {
    background-color: #080033 !important;
}
</style>
