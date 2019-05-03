<template>
<div class="mainContentCss">
  <main-header></main-header>

  <div class="container wrap-admin">
    <b-row>
      <b-col lg="3">
        <sidebar-admin></sidebar-admin>
      </b-col>
      <b-col lg="9">
        <div class="alert alert-danger" role="alert" v-show="hasChanges">
          <small><i class="fa fa-exclamation-circle"></i> Existem alterações não salvas, clique em <b>Salvar Campanha</b> para salva-las! </small>
        </div>
        <div class="container admin-right-container">
          <b-row class="top">
            <b-col lg="12">
              <topbar-admin :items="[{ text: 'Rascunho', href: '#' }, { text: 'Conteúdo de Campanha', active: true }]"></topbar-admin>
            </b-col>
          </b-row>
          <b-row class="area-1">
            <b-col lg="12">
              <div>
                <div class="main-title">
                  <span>Conteúdo da minha campanha</span>
                </div>
                <div class="subtitle">
                  Coloque aqui conteúdo relacionado a sua campanha
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="area-2">
            <b-col lg="12">
              <div class="inputs">
                <span class="title">
                  Imagem de Overlay <font color=red style="opacity:0.7;">*</font>
                </span>
                <span class="info">
                  Clique na imagem abaixo para editar a imagem que irá aparecer no topo da sua campanha
                </span>
                <br>
                <div class="upload-wrapper">
                  <div class="boxBlockUpload" v-if="!imageOverlay">
                    <b-img :src="$apiEndpoint + 'uploads/upload.png'" class="overlayImageUpload"></b-img>
                  </div>
                  <div class="boxBlock" v-if="imageOverlay">
                    <b-img :src="$apiEndpoint + imageOverlay" class="overlayImage"></b-img>
                  </div>
                  <input type="file" name="myFile" v-on:change="setOverlayImage">
                </div>
              </div>
              <div class="inputs">
                <span class="title">Galeria de imagens</span>
                <span class="info">
                  Adicione aqui várias imagens para aparecer na galeria da sua campanha
                </span>
                <div class="galery">
                  <b-img v-for="img in imagesGalery"  v-bind:key="img"  :src=" $apiEndpoint + img" @click="removeImgGalery(img)"></b-img>
                </div>
                <div class="sbs mt-3">
                  <div class="upload">
                    <input type="file" name="myFile" v-on:change="changeImage">
                  </div>
                  <div class="add">
                    <i class="fa fa-plus-square"></i> Adicionar mais uma imagem
                  </div>
                </div>
              </div>
            </b-col>
            <b-col lg="12">
              <div class="inputs">
                <span class="title">Resumo da campanha <font color=red style="opacity:0.7;">*</font></span>
                <span class="info">
                  Adicione aqui um resumo geral da sua campanha
                </span>
                <div class="sbs mt-3">
                  <b-form-textarea :rows="3" v-on:change="hasChanges = true" v-model="form.campaign_overview" placeholder="Digite um um resumo da campanha"></b-form-textarea>
                </div>
                <small class="sbs text-danger" v-show="form.campaign_overview.length < 192 ||  form.campaign_overview.length > 320">O resumo de sua campanha deve ter entre 192 e 320 caracteres</small>
              </div>
              <div class="inputs">
                <span class="title">Conte uma História <font color=red style="opacity:0.7;">*</font></span>
                <span class="info">
                  Digite abaixo a história do seu projeto como tudo começou e maiores detalhes sobre o que é
                </span>
              </div>
              <div class="mb-5 editor">
                <vue-ckeditor @change="hasChanges = true" v-model="form.campaign_history" :config="config" />
              </div>
              <div class="inputs">
                <span class="title">FAQ</span>
                <span class="info">
                  Digite abaixo dúvidas e respostas mais comuns dos consumidores para seu produto
                </span>
              </div>
              <div class="mb-2 faq" v-for="faq in faqText">
                P: {{faq.question}} <br>
                R: {{faq.answer}} <br>
                <button type="button" class="btn btn-danger btn-xs" @click="remFaq(faq)">
                  <i class="fa fa-eraser"></i> Remover
                </button>
                <br>
                <br>
              </div>
              <div class="inputs mt-5 mb-2">
                <span class="labelQuestion">Adicionar mais questões</span>
                <b-input-group size="sm" prepend='<i class="fa fa-question-circle"></i>'>
                  <b-form-input class="inputQuestion  mb-2" @change="hasChanges = true" v-model="faqQuestion" :rows="1" placeholder="Digite aqui uma dúvida" type="text"></b-form-input>
                </b-input-group>
                <b-input-group size="sm" prepend='<i class="fa fa-info-circle"></i>'>
                  <b-form-input class="inputQuestion mb-2" @change="hasChanges = true" v-model="faqAnswer" :rows="1" placeholder="Digite aqui uma resposta" type="text"></b-form-input>
                </b-input-group>
              </div>
              <div>
                <button type="button" class="btn btn-primary btn-sm" @click="addFaq()" v-show="faqQuestion && faqAnswer">
                  <i class="fa fa-plus"></i> Adicionar Questão
                </button>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
    </b-row>
  </div>
  <main-footer></main-footer>
</div>
</template>

<script>
import {
  mapState,
  mapActions
} from 'vuex'

import VueCkeditor from '@/components/ckeditor/'

export default {
  components: {
    VueCkeditor
  },
  computed: {
    ...mapState(['user'])
  },
  mounted() {
    this.loadCampaign()
  },
  methods: {
    setOverlayImage(e) {
      this.$awn.asyncBlock(global.$post("/Campaign/send_img", {
          fileToUpload: e.target.files[0]
        }, this.user.token))
        .then(response => {
          this.imageOverlay = response.data.MSG
          this.hasChanges = true
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao hospedar imagem")
        })
    },
    removeImgGalery(img) {
      this.hasChanges = true
      var index = this.imagesGalery.indexOf(img);
      if (index > -1) {
        this.imagesGalery.splice(index, 1);
      }
    },
    remFaq(obj) {
      this.hasChanges = true
      this.faqText = this.faqText.filter((el) => el !== obj)
    },
    addFaq() {
      this.hasChanges = true
      this.faqText.push({
        question: this.faqQuestion,
        answer: this.faqAnswer
      })
      this.faqQuestion = ''
      this.faqAnswer = ''
    },
    changeImage(e) {
      this.$awn.asyncBlock(global.$post("/Campaign/send_img", {
          fileToUpload: e.target.files[0]
        }, this.user.token))
        .then(response => {
          this.imagesGalery.push(response.data.MSG)
          this.hasChanges = true
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao hospedar imagem")
        })
    },
    saveCampaign() {
      this.hasChanges = false
      this.form.image_galery = this.imagesGalery.join("|")
      this.form.image_overlay = this.imageOverlay
      this.form.campaign_faq = JSON.stringify(this.faqText)
      this.form.id = this.$route.params.id

      this.$awn.asyncBlock(global.$post("/Campaign/content_edit", this.form, this.user.token))
        .then(response => {
          this.$awn.success("Campanha salva com sucesso!")
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao salvar as alterações")
        })
    },
    loadCampaign() {
      this.$awn.asyncBlock(global.$post("/Campaign/info", {
          id: this.$route.params.id
        }, this.user.token))
        .then(response => {
          if (response.data.MSG.image_galery) {
            this.imagesGalery = response.data.MSG.image_galery.split("|")
          }
          if (response.data.MSG.image_overlay) {
            this.imageOverlay = response.data.MSG.image_overlay
          }
          if (response.data.MSG.campaign_faq && response.data.MSG.campaign_faq.length > 1) {
            this.faqText = JSON.parse(response.data.MSG.campaign_faq)
          }
          if (response.data.MSG.campaign_history && response.data.MSG.campaign_history.length > 1) {
            this.form.campaign_history = response.data.MSG.campaign_history
          }
          this.form.campaign_overview = response.data.MSG.campaign_overview

        })
        .catch(err => {
          this.$awn.alert("Campanha não encontrada!")
        })
    }
  },
  watch: {
    hasChanges: function(next) {
      window.onbeforeunload = next ? (function() {
        return "Are you sure you want to close the window?"
      }) : null
    }
  },
  beforeRouteLeave(to, from, next) {
    if (this.hasChanges) {
      const answer = window.confirm('Deseja sair antes de salvar a campanha?')
      if (answer) {
        next()
      } else {
        next(false)
      }
    } else {
      next()
    }
  },
  data() {
    return {
      hasChanges: false,
      content: '',
      config: {
        height: 400,
        extraPlugins: ['youtube', 'imageresize', 'emoji']
      },
      faqQuestion: '',
      faqAnswer: '',
      imagesGalery: [],
      imageOverlay: '',
      faqText: [],
      form: {
        id: null,
        campaign_overview: '',
        campaign_history: "<div><h3>Short Summary</h3><p>Contributors fund ideas they can be passionate about and to people they trust. Here are some things to do in this section:</p><ul><li>Introduce yousafasfas</li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li> </li><li>rself and your background.</li><li>Briefly describe your campaign and why it's important to you.</li><li>Express the magnitude of what contributors will help you achieve.</li></ul><p>Remember, keep it concise, yet personal. Ask yourself: if someone stopped reading here would they be ready to make a contribution?</p></div><div><h3>What We Need &amp; What You Get</h3><p>Break it down for folks in more detail:</p><ul><li>Explain how much funding you need and where it's going. Be transparent and specific-people need to trust you to want to fund you.</li><li>Tell people about your unique perks. Get them excited!</li><li>Describe where the funds go if you don't reach your entire goal.</li></ul></div><div><h3>The Impact</h3><p>Feel free to explain more about your campaign and let people know the difference their contribution will make:</p><ul><li>Explain why your project is valuable to the contributor and to the world.</li><li>Point out your successful track record with projects like this (if you have one).</li><li>Make it real for people and build trust.</li></ul></div><div><h3>Risks &amp; Challenges</h3><p>People value your transparency. Be open and stand out by providing insight into the risks and obstacles you may face on the way to achieving your goal.</p><ul><li>Share what qualifies you to overcome these hurdles.</li><li>Describe your plan for solving these challenges.</li></ul></div><div><h3>Other Ways You Can Help</h3><p>Some people just can't contribute, but that doesn't mean they can't help:</p><ul><li>Ask folks to get the word out and make some noise about your campaign.</li><li>Remind them to use the Indiegogo share tools!</li></ul></div><p>And that's all there is to it.</p>",
        campaign_faq: '',
        image_galery: '',
        image_overlay: ''
      }
    }
  },

}
</script>

<style lang="scss">
@import "Styles/colors.scss";
@import "Styles/ckeditor.scss";

.mainContentCss {
    .btn-group-xs > .btn,
    .btn-xs {
        padding: 0.15rem 0.2rem;
        font-size: 0.5rem;
        line-height: 0.3;
        border-radius: 0.1rem;
    }
    .area-2 {
        .editor {
            max-height: 500px;
            height: 500px!important;
        }
        .upload {
            position: absolute;
            opacity: 0;
            z-index: 999;
            cursor: pointer;
        }
        .inputQuestion {
            border-right-width: 1px!important;
            border-bottom-width: 1px!important;
            border-top-width: 1px!important;
            border-left-width: 0px!important;
            height: 31px!important;
        }
        .labelQuestion {
            font-size: 11px;
            font-weight: bold;
            color: gray;
            opacity: 0.7;
        }
        .boxBlockUpload {
            border: 2px;
            position: relative;
            color: gray;
            background-color: transparent;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            height: 100px;
            .overlayImageUpload {
                display: block;
                height: 100px;
            }
        }
        .boxBlock {
            position: relative;
            color: gray;
            background-color: transparent;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
            height: 400px;
            .overlayImage {
                display: block;
                width: 90%;
                height: 100%;
            }
        }
        .title {
            font-size: 17px!important;
            font-weight: 600!important;
        }
        .inputs {
            margin-top: 30px;
        }
        .galery {
            margin-top: 15px;
            img {
                margin-right: 5px;
                max-width: 60px;
                max-height: 60px;
                cursor: pointer;
            }
        }
        .add {
            opacity: 0.5;
            color: gray;
            cursor: pointer;
        }
    }

    @media (max-width: 600px) {
        .inputs {
            margin-top: 250px!important;
        }
        .maxWidth {
            max-width: 60%;

        }
    }

    .wrap-admin {
        margin-top: 30px;
        .admin-right-container {
            $gray: gray;
            .area-1 {
                margin-top: 15px;
                .title {
                    font-size: 20px;
                    color: $blue;
                    font-weight: 600;
                }
                .subtitle {
                    font-size: 11px;
                    color: $gray;
                }
            }
            .inputs {
                margin-bottom: 20px;
            }
            .botoes {
                margin-bottom: 40px;
            }
        }
    }
}
</style>
