<template>
<div>
  <main-header></main-header>
  <div class="financial">
    <div class="top">
      <div class="container">
        <b-row class="first-row">
          <b-col cols="12" lg="6">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" v-if="campaign.gallery.length > 0">
              <div class="carousel-inner">
                <!-- v-if="campaign.gallery" na div abaixo -->
                <div class="carousel-item" :class="{ 'active': index == 0}"  v-for="(slide, index) in campaign.gallery" :key="index">
                  <img class="d-block" :src="$apiEndpoint + slide.picture_url">
                </div>
              </div>
              <div v-show="campaign.gallery && campaign.gallery.length > 1" class="thumb-control carousel-indicators">
                <!--  v-if="campaign.gallery" na div abaixo -->
                <div class="thumb" :class="{ 'active': index == 0 }" v-for="(slide, index) in campaign.gallery" :key="index" v-bind:data-slide-to="index" data-target="#carouselExampleIndicators">
                  <img :src="$apiEndpoint + slide.picture_url" :class="{ 'first': index == 0 }">
                </div>
              </div>
              <a v-show="campaign.gallery && campaign.gallery.length > 1" href="#carouselExampleIndicators" role="button" data-slide="prev" class="ctrl-left">
                <div class="bg-control">
                  <button class="control" data-glide-dir="<">
                    <font-awesome-icon icon="chevron-left" />
                  </button>
                </div>
              </a>
              <a v-show="campaign.gallery && campaign.gallery.length > 1" href="#carouselExampleIndicators" role="button" data-slide="next" class="ctrl-right">
                <div class="bg-control">
                  <button class="control" data-glide-dir=">">
                    <font-awesome-icon icon="chevron-right" />
                  </button>
                </div>
              </a>
            </div>
            <div v-else class="text-center" style="font-weight: 600; font-size: 1.5rem;">
              Esta campanha não possui imagens cadastradas na sua galeria de imagens!
            </div>

          </b-col>
          <b-col cols="12" lg="6">
            <b-breadcrumb :items="breadcrumbItems" />
            <div class="seta"></div>
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
                  <img style="border-radius: 100px;height:75px;width:75px;margin-top:5px" :src="(campaign && campaign.owner_image ? $apiEndpoint+campaign.owner_image : '/static/anonymous-icon.svg')  ">
                </div>
                <div class="info">
                  <span class="name">{{campaign.owner_name}}</span>
                  <span class="location" v-if="campaign.owner_country&&campaign.owner_city">{{campaign.owner_country}}, {{campaign.owner_city}}</span>
                  <span class="qt">{{campaign.owner_campaigns}} campanha criada(s)</span>
                </div>
              </div>
              <div class="bar">
                <span class="total_cash">Total Arrecadado {{campaign.amount_received  | currency}}  ({{campaign.donators}} doadores)</span>
                <progress-bar :current="currentPercentage"></progress-bar>
                <span class="meta">Meta de arrecadação <span class="valor">{{campaign.amount | currency}} </span></span>
                <span class="due-date">Termina em {{campaign.remain_days}} dias</span>
              </div>
              <div class="bottom">
                <div class="btn-noborder-blue button">
                  <b-button :href="'/#/payment-contribution/'+campaign.id">Apoiar</b-button>
                </div>
                <div class="social">
                <div style="font-size: 1.5rem;">
                  <i class="fab fa-facebook link-icon" :style="campaign.content[0].facebook_page? 'color: #496cb5': 'color: #707070; cursor: pointer;'"></i>
                  <i class="fab fa-instagram link-icon" :style="campaign.content[0].instagram_page? 'color: #d6249f': 'color: #707070; cursor: pointer;'"></i>
                  <i class="fab fa-youtube link-icon" :style="campaign.content[0].youtube_page? 'color: #ff0000': 'color: #707070; cursor: pointer;'"></i>
                </div>
                  <!-- <ul class="social-list">
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
                  </ul> -->
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
        <hr>
        <b-row class="second-row">
          <b-col cols="12" lg="8">
            <!-- <b-row>
              <div class="visao-geral">
                <div class="title">
                  <span>VISÃO GERAL</span>
                </div>
                <b-row>
                  <b-col lg="4" cols="12">
                    <img v-if="campaign.cover_url" class="img-gadjet" :src="$apiEndpoint + campaign.cover_url">
                  </b-col>
                  <b-col lg="8" cols="12">
                    {{campaign.description}}
                  </b-col>
                </b-row>
              </div>
            </b-row> -->
            <b-col cols="12" lg="12">
              <div class="tabs">
                <b-tabs>
                  <b-tab title="Projeto" active>
                    <div class="projeto" v-if="campaign.content.length > 0 && campaign.content[0].html">
                      <!--<div class="title">
                        <span>{{campaign.title}}</span>
                      </div>
                      <div class="subtitle">
                        <span>{{campaign.description}}</span>
                      </div>!-->
                      <div v-html="campaign.content[0].html">
                      </div>
                    </div>
                  </b-tab>
                  <b-tab title="FAQ">
                    <section v-if="campaign.faq.length > 0">
                      <div class="faqNews">
                        <span> Perguntas <span class="blue">Frequentes</span></span>
                      </div>
                      <!-- v-if="campaign.campaign_faq && campaign.campaign_faq.length > 0" na div abaixo -->
                      <div class="mt-3 mb-5"  v-for="(faq, index) in campaign.faq" :key="index">
                        <b>P: </b>{{faq.question}} <br>
                        <b>R: </b>{{faq.answer}} <br>
                      </div>
                    </section>
                    <section v-else class="text-center" style="font-weight: 600; font-size: 1.5rem;">
                      Nenhuma pergunta frequente cadastrada para esta campanha
                    </section>
                  </b-tab>
                </b-tabs>
              </div>
              </b-col>
          </b-col>
          <b-col cols="12" lg="4" v-if="campaign.perk.length > 0">
            <div class="recompensa">
              <div class="title">
                <span>ESCOLHA A RECOMPENSA</span>
              </div>
              <!-- {{campaign.perks}} !-->
              <div class="recompensas">
                <b-card v-for="(rec, index) in campaign.perk" :key="index" :img-src="$apiEndpoint + rec.cover_url" img-alt="Card image" style="cursor:pointer;" @click="openDonationPerk(rec.id)"  img-top>
                  <div class="info">
                    <span class="value" :class="{'has-discount': rec.discount > 0 && rec.discount}">Doação Mínima <span class="price">{{rec.price | currency}}</span></span>
                    <span v-if="rec.discount > 0 && rec.discount" class="value discount">Doação Mínima <span class="price">{{(rec.price - rec.discount) | currency}}</span></span>
                    <div class="title mt-2">{{rec.name}}</div>
                    <span v-if="rec.description" class="text" v-html="rec.description">
                      {{rec.description}}
                    </span>
                    <!-- <div v-if="rec.perk_item_info && rec.perk_item_info.length" class="itens">
                      <span class="title">Itens Incluídos</span>
                      <ul>
                        <li v-for="item in (rec.perk_item_info)" :key="item.title">{{item.title}}</li>
                      </ul>
                    </div> -->
                    <div class="delivery" >
                      <div v-if="rec.shipping_price > 0">
                        <span class="title" v-if="rec.shipping_worldwide == 'world_wide' ">Entrega em todo o mundo</span>
                        <span class="title" v-if="rec.shipping_worldwide == 'only_country' ">Entrega apenas em {{campaign.country_info.country_name}}</span>
                        <div class="due-date">Frete: {{rec.shipping_price | currency}}</div>
                        <span class="due-date">Estimado em {{rec.shipping_date}}</span>
                      </div>
                      <div v-else>
                        <span class="no-shipping">Não possui entrega!</span>
                      </div>
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
                      {{rec.stock_remain}} de {{rec.stock_remain}}<span> revindicados</span>
                    </div>
                  </div>
                </b-card>
              </div>
              <div class="recompensas">
                <b-card v-for="(cota, index) in campaign.cota" :key="index" img-src="https://via.placeholder.com/150" img-alt="Card image" style="cursor:pointer;" @click="openDonationCota(cota.id)"  img-top>
                  <div v-if="cota.stock_remain > 0" class="info">
                    <span class="value">Doação Mínima <span class="price">{{cota.min_donation | currency}}</span></span>
                    <div class="text">Ao atingir o valor mínimo de doação, você será recompensado com {{cota.percent}}% de toda venda do produto</div>
                    <div class="delivery">
                      <div>
                        <div class="due-date">Data de expiração: {{cota.expiry}}</div>
                      </div>
                      <div class="due-date">Estoque de cotas: {{cota.stock_remain}}</div>
                    </div>

                    <div class="text cota-obs">Obs: Essa cota será divida com o {{cota.stock}} pessoas</div>
                  </div>
                </b-card>
              </div>
            </div>
          </b-col>

        </b-row>
        <!-- <b-row>
          <b-col cols="12" lg="">
            <div class="more">
              <div class="title">
                <span> Você pode <span class="blue">gostar!</span></span>
              </div> -->
              <!-- <div class="project-group">
                <project-card :projects="projects"></project-card>
              </div> -->
            <!-- </div>
          </b-col>
        </b-row> -->
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
    ...mapState(['user']),
    currentPercentage() {
       let percentage = Math.round(100 / this.campaign.amount * this.campaign.amount_received)
        return  percentage > 100 ? 100 : percentage
    }
  },
  methods: {
    openDonationPerk(id) {
      window.open('/#/payment-contribution/perk/'+this.campaign.id+'/'+id)
    },
    openDonationCota(id) {
      window.open('/#/payment-contribution/cota/'+this.campaign.id+'/'+id)
    },
    loadCampaign() {
      global.$post("/Campaign/campaigninfo", {campaign_id: this.$route.params.id}, this.user.token || null)
        .then(response => {
          console.log(response.data)
          this.campaign = response.data
          this.breadcrumbItems = [{
              text: 'Funding',
              href: this.campaign.category_info.route
            },
            {
              text: this.$f('HOME::'+this.campaign.category_info.name),
              active: true
            }
          ]
        })
        .catch(err => {
          this.$awn.alert("Campanha invalida!")
        })
    }
  },
  mounted() {
    this.loadCampaign()
  },
  data() {
    return {
      campaign: {},
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
