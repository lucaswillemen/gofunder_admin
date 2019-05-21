<template>
    <div>
        <main-header></main-header>
        <div class="slide-home">
            <b-carousel id="carousel1" style="text-shadow: 1px 1px 2px #333;" controls background="#ababab" :interval="99999999999" v-model="slide" @sliding-start="onSlideStart" @sliding-end="onSlideEnd">
                <b-carousel-slide v-for="slideData in slidesData"  v-bind:key="slideData.id" >
                    <div class="slide-text">
                        <div class="title">
                            {{slideData.title}}
                        </div>
                        <div class="text">
                            {{slideData.description}}
                        </div>
                        <div class="buttons">
                            <div class="btn-noborder mright">
                                <router-link :to="'/project-info/'+slideData.id+ '/'+ slideData.uri">
                                    <b-button>Quero Contribuir!</b-button>
                                </router-link>
                            </div>
                            <div class="btn-noborder-blue mleft">
                                <router-link :to="'/project-info/'+slideData.id+ '/'+ slideData.uri">
                                    <b-button>Saiba mais</b-button>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <b-img slot="img" :src='$apiEndpoint + slideData.image_overlay' fluid-grow></b-img>
                </b-carousel-slide>
            </b-carousel>
            <div class="counter">
                {{ slide + 1 }}/{{slidesData.length}}
            </div>
        </div>
        <div class="slide-bottom">
            <div class="center-right left">
                <span>Total Arrecadado {{selectSlide.cash_received  | currency}}</span>
            </div>
            <div class="center-obj circle"></div>
            <div class="center-obj number">{{selectSlide.percentage}}%</div>
            <div class="center-left right">
                <span>Meta {{selectSlide.cash | currency}}</span>
            </div>
            <div class="percent">
                <svg viewBox="0 0 36 100" class="circular-chart">
                    <path class="circle" v-bind:stroke-dasharray="100 + ' 100'" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
            </div>
        </div>
        <b-container>
            <b-row align-h="between" class='area-1'>
                <b-col lg="6" sm="12">
                    <div class="left" v-bind:style="{ backgroundImage: 'url(' + area1img1 + ')' }">
                        <div class="center-obj" v-bind:style="{ backgroundImage: 'url(' + area1icn1 + ')' }"></div>
                        <div class="content center-obj-hv">
                            <div class="title">
                                Funding
                            </div>
                            <div class="text">
                                Compre pequenas cotas de startups com grande pontencial e consiga lucros expressivos no mercado que mais cresce em todo o mundo
                            </div>
                            <div class="buttons">
                                <div class="btn-noborder-transp mright">
                                    <b-button @click="goFunding()">Ver Campanhas</b-button>
                                </div>
                                <div class="btn-noborder mleft">
                                    <b-button>Saiba mais</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col lg="6" sm="12">
                    <div class="right" v-bind:style="{ backgroundImage: 'url(' + area1img2 + ')' }">
                        <div class="center-obj" v-bind:style="{ backgroundImage: 'url(' + area1icn2 + ')' }"></div>
                        <div class="content center-obj-hv">
                            <div class="title">
                                Marketplace
                            </div>
                            <div class="text">
                                Aqui você encontra o que é de mais inovador no mercado. São produtos e serviços desenvolvidos por pequenas estartups exclusivas.
                            </div>
                            <div class="buttons">
                                <div class="btn-noborder-transp mright">
                                    <b-button @click="goProducts()">Ver Produtos</b-button>
                                </div>
                                <div class="btn-noborder-blue mleft">
                                    <b-button>Saiba mais</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
            </b-row>
            <b-row class="area-2">
                <b-col lg="4" sm="12">
                    <div class="left" v-bind:style="{ backgroundImage: 'url(' + area2bg + ')' }">
                        <b-img class="center-obj-v" :src='area2icn1'></b-img>
                        <span class="text1 center-obj-v">Inovação</span>
                    </div>
                </b-col>
                <b-col lg="4" sm="12">
                    <div class="middle" v-bind:style="{ backgroundImage: 'url(' + area2bg + ')' }">
                        <b-img class="center-obj-v" :src='area2icn2'></b-img>
                        <span class="text2 center-obj-v">Fácil Acesso</span>
                    </div>
                </b-col>
                <b-col lg="4" sm="12">
                    <div class="right" v-bind:style="{ backgroundImage: 'url(' + area2bg + ')' }">
                        <b-img class="center-obj-v" :src='area2icn3'></b-img>
                        <span class="text3 center-obj-v">Mercado Garantido</span>
                    </div>
                </b-col>
            </b-row>
        </b-container>
        <div class="area-3">
            <div class="bg" v-bind:style="{ backgroundImage: 'url(' + area3bg + ')' }"></div>
            <b-container>
                <b-row class="linha1">
                    <b-col lg="6" sm="12">
                        <div class="col1" v-bind:style="{ backgroundImage: 'url(' + area3img1 + ')' }">
                            <div class="title center-obj-v">
                                <span>Top 10 <b>Startups</b></span>
                            </div>
                        </div>
                        <div class="under-img">
                            <span class="center-object-v">
                            As ideias startup com baixo investimento e grande possibilidade de retorno!
                            </span>
                            <div class="btn-noborder-blue">
                                <b-button>ver mais</b-button>
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="6" sm="12">
                        <div class="col2" v-bind:style="{ backgroundImage: 'url(' + area3img2 + ')' }">
                            <div class="title center-obj-v">
                                <span><b>Favoritos</b> da Casa</span>
                            </div>
                        </div>
                        <div class="under-img">
                            <span class="center-object-v">
                            Separamos os favoritos da equipe por votação
                            </span>
                            <div class="btn-noborder-blue">
                                <b-button>ver mais</b-button>
                            </div>
                        </div>
                    </b-col>
                </b-row>
                <b-row class="linha1">
                    <b-col lg="6" sm="12">
                        <div class="col1" v-bind:style="{ backgroundImage: 'url(' + area3img3 + ')' }">
                            <div class="title center-obj-v">
                                <span></span>
                            </div>
                        </div>
                        <div class="under-img">
                            <span class="center-object-v">
                            Ideias automotivas de baixo investimento e grande possibilidade de retorno!
                            </span>
                            <div class="btn-noborder-blue">
                                <b-button>ver mais</b-button>
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="6" sm="12">
                        <div class="col2" v-bind:style="{ backgroundImage: 'url(' + area3img4 + ')' }">
                            <div class="title center-obj-v">
                                <span></span>
                            </div>
                        </div>
                        <div class="under-img">
                            <span class="center-object-v">
                            Ideias que realmente farão um diferencial resultando em sucesso garantido
                            </span>
                            <div class="btn-noborder-blue">
                                <b-button>ver mais</b-button>
                            </div>
                        </div>
                    </b-col>
                </b-row>
                <b-row class="area-4">
                    <b-col lg="3" sm="12">
                        <div class="title">
                            <span>Que categorias <b>te interessam?</b></span>
                        </div>
                    </b-col>
                    <b-col lg="3" sm="12">
                        <div class="content">
                            <span>Nossa comunidade é muito ativa em prol de inovações. Aqui você encontra produtos inovadores nas mais diversas categorias.</span>
                        </div>
                    </b-col>
                    <b-col lg="3" sm="12">
                        <div class="btn-noborder-blue bt1">
                            <a href="/#/register">
                                <b-button>Cadastre-se e selecione suas preferências</b-button>
                            </a>
                        </div>
                    </b-col>
                    <b-col lg="3" sm="12">
                        <div class="btn-noborder-transp bt2">
                            <a href="/#/login">
                                <b-button>Já sou cadastrado</b-button>
                            </a>
                        </div>
                    </b-col>
                </b-row>
                <b-row class="area-5">
                    <b-col lg='12' id='container-circle' v-if="categories.length > 0">
                        <div  v-for="cat in categories" :id='"cat"+cat.id' :class="selectedId == cat.id ? 'circle circle' + cat.id + ' act': 'circle circle' + cat.id" @click="selectCategory(cat.id)">
                            <div class="title center-obj">
                                <div class="img">
                                    <i class="material-icons"  @click="selectCategory(cat.id)">{{cat.icon_name}}</i>
                                </div>
                                <span>{{cat.name | fix}}</span>
                            </div>
                            <div :id="'seta-cat'+cat.id" v-bind:class="selectedId == cat.id ? 'show' : 'hide'" class="seta"></div>
                        </div>
                    </b-col>
                </b-row>
                <div id="destaque">
                    <div id='d-cat1' v-bind:class="selectedId == 1 ? 'show' : 'hide'"></div>
                    <div id='d-cat2' v-bind:class="selectedId == 2 ? 'show' : 'hide'"></div>
                    <div id='d-cat3' v-bind:class="selectedId == 3 ? 'show' : 'hide'"></div>
                    <div id='d-cat4' v-bind:class="selectedId == 4 ? 'show' : 'hide'"></div>
                    <div id='d-cat5' v-bind:class="selectedId == 5 ? 'show' : 'hide'"></div>
                    <div id='d-cat6' v-bind:class="selectedId == 6 ? 'show' : 'hide'"></div>
                    <div id='d-cat7' v-bind:class="selectedId == 7 ? 'show' : 'hide'"></div>
                    <div id='d-cat8' v-bind:class="selectedId == 8 ? 'show' : 'hide'"></div>
                    <div id='d-cat9' v-bind:class="selectedId == 9 ? 'show' : 'hide'"></div>
                    <b-row class='title'>
                        <b-col lg="12">
                            <span>Destaques nessa categoria</span>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="3">
                            <div class="img" v-bind:style="{ backgroundImage: 'url(' + catImg1 + ')' }"></div>
                        </b-col>
                        <b-col lg="3">
                            <div class="img" v-bind:style="{ backgroundImage: 'url(' + catImg2 + ')' }"></div>
                        </b-col>
                        <b-col lg="3">
                            <div class="img" v-bind:style="{ backgroundImage: 'url(' + catImg3 + ')' }"></div>
                        </b-col>
                        <b-col lg="3">
                            <div class="img" v-bind:style="{ backgroundImage: 'url(' + catImg4 + ')' }"></div>
                        </b-col>
                    </b-row>
                    <b-row class='button'>
                        <b-col lg="12">
                            <div class="btn-noborder">
                                <b-button @click="goCategory(selectedId)">Veja mais dessa categoria</b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
            </b-container>
        </div>
        <pre-footer></pre-footer>
        <main-footer></main-footer>
    </div>
</template>

<script>
import {
    Glide,
    GlideSlide
} from 'vue-glide-js';


import {
    mapState,
    mapActions
} from 'vuex'


export default {
    computed: {
        ...mapState(['user'])
    },
    components: {
        [Glide.name]: Glide,
        [GlideSlide.name]: GlideSlide,
    },
    data() {
        return {
            mymsg: 'Deu certo agora!',
            slide: 0,
            sliding: null,
            slidesData: [],
            selectSlide: {},
            selectedId: 1,
            categories: [],
            area1img1: require('Img/area-1-imagem-1.png'),
            area1img2: require('Img/area-1-imagem-2.png'),
            area1icn1: require('Img/area-1-icone-1.png'),
            area1icn2: require('Img/area-1-icone-2.png'),
            area2bg: require('Img/area-2-bg.png'),
            area2icn1: require('Img/area-2-icone-1.png'),
            area2icn2: require('Img/area-2-icone-2.png'),
            area2icn3: require('Img/area-2-icone-3.png'),
            area3bg: require('Img/area-3-bg.png'),
            area3img1: require('Img/area-3-img-1.png'),
            area3img2: require('Img/area-3-img-2.png'),
            area3img3: require('Img/area-3-img-3.png'),
            area3img4: require('Img/area-3-img-4.png'),

            catImg1: require('Img/catimg1.png'),
            catImg2: require('Img/catimg2.png'),
            catImg3: require('Img/catimg3.png'),
            catImg4: require('Img/catimg4.png')

        }
    },
    methods: {
        goProducts() {
            location.href = '/#/projects-type/marketplace'
        },
        goFunding() {
            location.href = '/#/projects-type/funding'
        },
        goCategory(id) {
            location.href = '/#/projects-category/' + id
        },
        onSlideStart(slide) {
            this.selectSlide = this.slidesData[slide]
            this.selectSlide.percentage = Math.round(100 / this.selectSlide.cash * this.selectSlide.cash_received)
            if (this.selectSlide.percentage > 100) this.selectSlide.percentage = 100
            this.sliding = true
        },
        onSlideEnd(slide) {
            this.sliding = false
        },
        isMobile() {
            if (typeof window.orientation === 'undefined') {
                return false
            } else {
                return true
            }
        },
        loadSlides() {
            this.slidesData = []

            this.$awn.asyncBlock(global.$post("/Campaign/cover_campaigns", {}))
                .then(response => {
                    this.slidesData = response.data
                    this.selectSlide = this.slidesData[0]
                    this.selectSlide.percentage = Math.round(100 / this.selectSlide.cash * this.selectSlide.cash_received)
                    if (this.selectSlide.percentage > 100) this.selectSlide.percentage = 100
                })
                .catch(err => {})
        },
        selectCategory: function(id) {
            if (typeof window.orientation === 'undefined') {
                this.selectedId = id
            }
        },
        loadCategory() {
            this.$awn.asyncBlock(global.$post("/Other/category_list", {}))
                .then(response => {
                    this.categories = response.data
                })
                .catch(err => {
                  
                })
        }
    },
    mounted() {
        this.loadSlides()
        this.loadCategory()
    }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/home.scss";
</style>
