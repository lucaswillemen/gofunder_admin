<template>
<div>
  <main-header></main-header>
  <div class="financial">
    <div class="top">
      <div class="container">
        <b-row class="first-row">
          <b-col cols="12" lg="6">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" v-if="campaign.image_galery[0]!==''">
              <div class="carousel-inner">
                <div class="carousel-item" :class="{ 'active': i == 0}" v-if="campaign.image_galery" v-for="(slide, i) in campaign.image_galery" :key="slide">
                  <img class="d-block" :src="$apiEndpoint + slide">
                </div>
              </div>
              <div v-show="campaign.image_galery && campaign.image_galery.length>1" class="thumb-control carousel-indicators">
                <div class="thumb" :class="{ 'active': i == 0 }" v-if="campaign.image_galery" v-for="(slide, i) in campaign.image_galery" :key="slide" v-bind:data-slide-to="i" data-target="#carouselExampleIndicators">
                  <img :src="$apiEndpoint + slide" :class="{ 'first': i == 0 }">
                </div>
              </div>
              <a v-show="campaign.image_galery && campaign.image_galery.length>1" href="#carouselExampleIndicators" role="button" data-slide="prev" class="ctrl-left">
                <div class="bg-control">
                  <button class="control" data-glide-dir="<">
                    <font-awesome-icon icon="chevron-left" />
                  </button>
                </div>
              </a>
              <a v-show="campaign.image_galery && campaign.image_galery.length>1" href="#carouselExampleIndicators" role="button" data-slide="next" class="ctrl-right">
                <div class="bg-control">
                  <button class="control" data-glide-dir=">">
                    <font-awesome-icon icon="chevron-right" />
                  </button>
                </div>
              </a>
            </div>

          </b-col>
          <b-col cols="12" lg="6">
            <b-breadcrumb :items="breadcrumbItems" />
            <div class="seta"></div>
            </b-breadcrumb>
            <div class="info">
              <div class="title_top">
                <span>{{campaign.title}}</span>
              </div>
              <div class="text">
                <span>{{campaign.description}}</span>
              </div>
              <div class="owner">
                <span class="title">Proprietário do Projeto</span>
                <div class="img">
                  <img style="border-radius: 100px;height:75px;width:75px;margin-top:5px" :src="(campaign && campaign.user_img ? $apiEndpoint+'/uploads/profile/'+campaign.user_img : '/static/anonymous-icon.svg')  ">
                </div>
                <div class="info">
                  <span class="name">{{campaign.owner_name}}</span>
                  <span class="location" v-if="campaign.country&&campaign.city">{{campaign.country}}, {{campaign.city}}</span>
                  <span class="qt">{{campaign.owner_campaigns}} campanha criada(s)</span>
                </div>
              </div>
              <div class="bar">
                <span class="total_cash">Total Arrecadado {{campaign.cash_received  | currency}}  ({{campaign.donaters}} doadores)</span>
                <progress-bar :current="campaign.percent_current"></progress-bar>
                <span class="meta">Meta de arrecadação <span class="valor">{{campaign.cash  | currency}} </span></span>
                <span class="due-date">Termina em {{campaign.due_dat_time}} dias</span>
              </div>
              <div class="bottom">
                <div class="btn-noborder-blue button">
                  <b-button :href="'/#/payment-contribution/'+campaign.id">Apoiar</b-button>
                </div>
                <div class="social">
                  <ul class="social-list">
                    <li class="active">
                      <font-awesome-icon :icon="['far', 'heart']" />
                    </li>
                    <li v-for='social in socials' :key="social.name" :style="'background-color: '+social.color">
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
          </b-col>
        </b-row>
        <hr>
        </hr>
        <b-row class="second-row">
          <b-col cols="12" lg="8">
            <b-row>
              <div class="visao-geral">
                <div class="title">
                  <span>VISÃO GERAL</span>
                </div>
                <b-row>
                  <b-col lg="4" cols="12">
                    <img v-if="campaign.image_overlay" class="img-gadjet" :src="$apiEndpoint + campaign.image_overlay">
                  </b-col>
                  <b-col lg="8" cols="12">
                    {{campaign.campaign_overview}}
                  </b-col>
                </b-row>
              </div>
            </b-row>
            <b-col cols="12" lg="12">
              <div class="tabs">
                <b-tabs>
                  <b-tab title="Projeto" active>
                    <div class="projeto">
                      <!--<div class="title">
                        <span>{{campaign.title}}</span>
                      </div>
                      <div class="subtitle">
                        <span>{{campaign.description}}</span>
                      </div>!-->
                      <div v-html="campaign.campaign_history">
                      </div>
                    </div>
                  </b-tab>
                  <b-tab title="FAQ">
                    <div class="faqNews">
                      <span> Perguntas <span class="blue">Frequentes</span></span>
                    </div>
                    <div class="mt-3 mb-5" v-if="campaign.campaign_faq && campaign.campaign_faq.length > 0" v-for="faq in (campaign.campaign_faq)">
                      <b>P: </b>{{faq.question}} <br>
                      <b>R: </b>{{faq.answer}} <br>
                    </div>
                  </b-tab>
                  <b-tab title="Atualizações">
                    Nenhuma atualização até o momento
                  </b-tab>
                  <b-tab title="Apoiadores">
                    Nenhum doador até agora
                  </b-tab>
                </b-tabs>
              </div>
              <div class="mt-5 tags" v-show="campaign.tags_split && campaign.tags_split.length > 1 &&  campaign.tags_split[0].length">
                <div class="title">
                  <span> Tags <span class="blue">Relacionadas</span></span>
                </div>
                <div class="tag-group">
                  <div class="btn-border-blue" v-for="tag in campaign.tags_split" :key="tag">
                    <b-button>{{tag}}</b-button>
                  </div>
                </div>
              </div>
            </b-col>
          </b-col>
          <b-col cols="12" lg="4" v-if="campaign.perks.length>0">
            <div class="recompensa">
              <div class="title">
                <span>ESCOLHA A RECOMPENSA</span>
              </div>
              <!-- {{campaign.perks}} !-->
              <div class="recompensas">
                <b-card v-for="rec in (campaign.perks)" v-bind:key="rec.id" :img-src="$apiEndpoint  + rec.perk_image" img-alt="Card image" style="cursor:pointer;" @click="openDonation(rec.id)"  img-top>
                  <div class="info">
                    <!--<span class="category">DESTAQUE</span>!-->
                    <span class="value">Doação Mínima {{rec.perk_min_donation | currency}}</span>
                    <span class="title">{{rec.perk_title}}</span>
                    <span v-if="rec.perk_description" class="text" v-html="rec.perk_description">
                      {{rec.perk_description}}
                    </span>
                    <div v-if="rec.perk_item_info && rec.perk_item_info.length" class="itens">
                      <span class="title">Itens Incluídos</span>
                      <ul>
                        <li v-for="item in (rec.perk_item_info)" :key="item.title">{{item.title}}</li>
                      </ul>
                    </div>
                    <div class="delivery">
                      <span class="title">Entrega</span>
                      <span class="due-date">Estimado em {{rec.perk_delivery_date}}</span>
                      <!--<div class="mt-4">
                        <table style="width:100%; font-size:12px!important;">
                          <th>Pais</th>
                          <th>Valor</th>
                          <tr v-for="item in JSON.parse(rec.perk_shipping_info)">
                            <td><span :class="item.locale.icon"></span> {{item.locale.label}}</td>
                            <td>{{item.price  | currency}}</td>
                          </tr>
                        </table>
                      </div>!-->
                    </div>
                    <div class="totals">
                      <span>{{rec.users_payed}} de {{rec.perk_stock}} revindicados</span>
                    </div>
                  </div>
                </b-card>
              </div>
            </div>
          </b-col>
        </b-row>
        <b-row>
          <b-col cols="12" lg="">
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
import {
  mapActions,
  mapState,
  mapGetters
} from 'vuex'



export default {
  computed: {
    ...mapState(['user'])
  },
  methods: {
    openDonation(perkId) {
      window.open('/#/payment-contribution/'+this.campaign.id+'/'+perkId)
    },
    getItem() {

      global.$post("/Campaign/get_public", {
          id: this.$route.params.id
        }, this.user.token)
        .then(response => {
          this.campaign = response.data.MSG
          try {
            this.campaign.campaign_faq = JSON.parse(this.campaign.campaign_faq);
          } catch (exp) {
            this.campaign.campaign_faq = []
          }
          for (var i in this.campaign.perks) {
            try {
              this.campaign.perks[i].perk_shipping_info = JSON.parse(this.campaign.perks[i].perk_shipping_info);
            } catch (exp) {
              this.campaign.perks[i].perk_shipping_info = []
            }
            try {
              this.campaign.perks[i].perk_item_info = JSON.parse(this.campaign.perks[i].perk_item_info);
            } catch (exp) {
              this.campaign.perks[i].perk_item_info = []
            }
          }
          this.breadcrumbItems = [{
              text: this.campaign.campaign_type,
              href: '#'
            },
            {
              text: this.campaign.campaign_category,
              active: true
            }
          ]
        })
        .catch(err => {
          this.$awn.alert("Campanha invalida!")
        })
    },
    getRandomItems() {
      this.$awn.asyncBlock(global.$post("/Campaign/random_list", {}))
        .then(response => {
          for (var i in response.data.MSG) {
            let percent = ((100 / response.data.MSG[i].cash) * response.data.MSG[i].cash_received)
            response.data.MSG[i].percent = percent > 100 ? 100 : percent
            this.projects.push(response.data.MSG[i])
          }
        })
        .catch(err => {
        })
    }
  },
  mounted() {
    this.getRandomItems()
    this.getItem()
  },
  data() {
    return {
      campaign: [],
      breadcrumbItems: [],
      socials: [{
          name: 'facebook-f',
          link: 'https://www.facebook.com/sharer.php?u=' + location.href,
          color: '#3b5998'
        },
        {
          name: 'twitter',
          link: 'https://twitter.com/intent/tweet?url='+ location.href,
          color: '#1da1f2'
        },
        {
          name: 'pinterest-p',
          link: 'http://pinterest.com/pin/create/link/?url=' + location.href,
          color: '#bd081c'
        },
      ],
      projects: []
    }
  },
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/financial.scss";
</style>
