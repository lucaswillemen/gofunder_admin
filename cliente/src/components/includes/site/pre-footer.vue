<template>
<div class="area-6">
  <div class="bg" v-bind:style="{ backgroundImage: 'url(' + area6bg + ')' }">
    <b-container>

      <!-- <section>
        <div class="header">
          <span class="title blue">Nosso <b class="orange">Blog</b></span>
          <span class="text">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
          </span>
        </div>
        <vue-glide :breakpoints="{800:{perView:1}}">
          <vue-glide-slide v-for="i in 6" :key="i">
            <div :id="'card'+i" class="my-card">
              <b-img :src='getValueDynamicVar("blogImg",i)'></b-img>
              <div class="btn-noborder see-container">
                <b-button>ver mais</b-button>
              </div>
              <div class="title">
                <span>{{ getValueDynamicVar("blogTitle", i) }}</span>
              </div>
              <div class="text">
                <span>{{ getValueDynamicVar("blogText", i) }}</span>
              </div>
            </div>
          </vue-glide-slide>
          <template slot="control">
            <button class="control ctrl-left" data-glide-dir="<">
              <font-awesome-icon icon="chevron-left" /></button>
            <button class="control ctrl-right" data-glide-dir=">">
              <font-awesome-icon icon="chevron-right" /></button>
          </template>
        </vue-glide>
      </section> -->


      <div class="register" >
        <div class="title">
          <span>Descubra o novo e <b class="orange">faça parte do futuro</b></span>
        </div>
        <div class="text">
          <span>
            Campanhas inteligentes para seres humanos curiosos e empreendedores
            Não há lugar melhor para começar a busca por algo inovador. Comece no GoFunder para encontrar idéias inteligentes e não convencionais que resolvam os problemas cotidianos grandes e pequenos, escolha em inúmeras possibilidades de apoiar ou
            investir em algo inovador!</span>
        </div>
        <div class="buttons">
          <div class="button btn-noborder-transp">
            <a href="/#/register">
              <b-button>Cadastre-se</b-button>
            </a>
          </div>
          <span>ou</span>
          <div class="button btn-noborder">
            <a href="/#/login">
              <b-button>Logar na Plataforma</b-button>
            </a>
          </div>
        </div>
      </div>
    </b-container>
  </div>
</div>
</template>


<script>
export default {
  data() {
    return {
      area6bg: require('Img/area-6-bg.png'),
      blogImg1: require('Img/blogImg1.png'),
      blogTitle1: 'Como ter mais apoiadores?',
      blogText1: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
      blogImg2: require('Img/blogImg2.png'),
      blogTitle2: 'Membros robóticos para amputados',
      blogText2: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
      blogImg3: require('Img/blogImg3.png'),
      blogTitle3: 'O que mudou com o Go Funder?',
      blogText3: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
      blogImg4: require('Img/blogImg1.png'),
      blogTitle4: 'Como ter mais apoiadores?',
      blogText4: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
      blogImg5: require('Img/blogImg2.png'),
      blogTitle5: 'Membros robóticos para amputados',
      blogText5: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
      blogImg6: require('Img/blogImg3.png'),
      blogTitle6: 'O que mudou com o GoFunder?',
      blogText6: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
    }
  },
  methods: {
    getValueDynamicVar(variable, i) {
      var name = variable + i;
      return this[name];
    }
  }
}
</script>


<style lang="scss">
@import "Styles/colors.scss";

.area-6 {

    margin-top: 30px;
    margin-bottom: 10px;
    position: relative;

    .bg {
      height: 300px;
      background-position: center;
    }

    // .header {
    //     margin-bottom: 20px;
    //     font-size: 33px;
    //     line-height: 22px;

    //     .title {
    //         display: block;
    //         margin-bottom: 8px;
    //     }

    //     .text {
    //         font-size: 15px;
    //     }

    // }

    // .glide {
    //     height: 408px;
    // }

    .register {
      width: 760px;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      margin: 0 auto;

        .title {
            font-size: 33px;
            font-weight: 100;

            b {
                font-weight: 700;
            }
        }

        .text {
            font-size: 13px;
        }

        .buttons {
            display: inline-flex;
            margin-top: 35px;

            .button,
            span {
                padding-right: 14px;
            }

            .button button {
                padding-right: 40px;
                padding-left: 40px;
                padding-top: 2px;
                font-size: 16px;
                font-weight: 400;
            }
        }

    }

    // $colorControl: #0000003b;
    // .control {
    //     border-radius: 15px;
    //     background-color: transparent;
    //     border: 1px solid $colorControl;
    //     width: 27px;
    //     height: 27px;
    //     color: $colorControl;
    //     font-size: 13px;
    //     cursor: pointer;
    // }

    // .ctrl-left {
    //     position: absolute;
    //     top: -56px;
    //     right: 35px;
    // }
    // .ctrl-right {
    //     position: absolute;
    //     top: -56px;
    //     right: 0;
    // }

    // .my-card {
    //     height: 392px;
    //     position: relative;
    //     color: white;

    //     button {
    //         position: absolute;
    //         bottom: 139px;
    //         right: 26px;
    //     }

    //     img {
    //         width: 100%;
    //     }

    //     .title {
    //         margin-top: 25px;
    //         font-size: 18px;
    //         font-weight: 600;
    //     }

    //     .text {
    //         font-size: 13px;
    //         width: 88%;
    //     }

    // }

}

@media only screen and (max-width: 768px) {
    .area-6 {

        padding-bottom: 35px;

        .register {
            width: auto;
            padding-top: 0;

            .buttons .button button {
                padding-top: 5px;
                padding-bottom: 10px;
                font-size: 11px;
            }
        }

        .bg {
            height: 548px;
            top: 339px;
        }

        .ctrl-left,
        .ctrl-right {
            top: -98px;
        }

        .my-card button {
            bottom: 163px;
        }
    }
}
</style>
