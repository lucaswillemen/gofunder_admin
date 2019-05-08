<template>
<div>
  <div class="loading-overlay" v-if="loading">
    <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
  </div>
  <md-tabs class="md-primary" md-alignment="fixed">
    
    <md-tab id="tab-pages" md-label="Resumo" md-icon="pages">

      <div class="md-layout md-grutter md-alignment-center-center">
        <div class="md-layout-item md-small-size-100  md-size-100">
          <md-card>
            <md-card-content>
          <vue-ckeditor  v-model="editorData" :config="config" />
            </md-card-content>
          </md-card>
        </div>
        <div class="md-layout md-grutter md-alignment-center-center">
          <md-button class="md-fab md-primary">
            <md-icon>close</md-icon>
          </md-button>
          <md-button class="md-fab md-primary" style="background:green">
            <md-icon>save</md-icon>
          </md-button>
        </div>
      </div>
    </md-tab>
    <md-tab id="tab-gift" md-label="perks" md-icon="card_giftcard">
      <div class="md-layout md-grutter">
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
          <md-card>
            <md-card-area md-inset>
              <md-card-media md-ratio="16:9">
                <img src="https://www.raspberrypi.org/wp-content/uploads/2014/09/IMG_4456.jpg">
              </md-card-media>
              <md-card-header>
                <h2 class="md-title">Coffee When Wakeup</h2>
                <div class="md-subhead">
                  <md-icon>attach_money</md-icon>
                  <span> 100</span>
                </div>
              </md-card-header>
            </md-card-area>
            <md-card-content>
              <md-list>
                <md-list-item>
                  <md-icon>star</md-icon>
                  <span class="md-list-item-text">Um chicara</span>
                </md-list-item>
                <md-list-item>
                  <md-icon>star</md-icon>
                  <span class="md-list-item-text">Um pires</span>
                </md-list-item>
              </md-list>
            </md-card-content>
            <md-card-actions>

              <md-checkbox v-model="allow" value="1">Mostrar disponivel</md-checkbox>
            </md-card-actions>
          </md-card>
        </div>
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
          <br>
          <md-button class="md-fab md-primary" @click="showDialog = true">
            <md-icon>add</md-icon>
          </md-button>
        </div>
      </div>
      <div>
        <md-dialog :md-active.sync="showDialog">
          <md-dialog-title>Create new perk</md-dialog-title>
          <md-dialog-content>
            <md-button class="md-fab md-primary">
              <md-icon>add_a_photo</md-icon>
            </md-button>
            <md-field>
              <label>Qual o nome do seu perk?</label>
              <md-input required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
            <md-field>
              <label>Qual o valor do seu perk?</label>
              <md-input required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
            <md-field>
              <label>Seu perk tem estoque?</label>
              <md-input required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
            <md-button class="md-primary md-raised">Add item</md-button>
          </md-dialog-content>
          <md-dialog-actions>
            <md-button class="md-acent md-raised" @click="showDialog = false">Close</md-button>
            <md-button class="md-primary md-raised" @click="showDialog = false">Add</md-button>
          </md-dialog-actions>
        </md-dialog>
      </div>
    </md-tab>
    <md-tab id="tab-collections" md-label="Gallery" md-icon="collections">
      <div class="md-layout md-grutter">
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
          <md-dialog :md-active.sync="showAddImg">
            <md-dialog-title>Escolha uma imagem</md-dialog-title>
            <md-dialog-content>
              <input type="file" style="display: none" id="input-file" @change="pickImg($event)">
              <md-button v-if="!imageToUpload" @click="clickOnFileInput()" class="md-fab md-primary">
                <md-icon>add_a_photo</md-icon>
              </md-button>
              <div v-else class="profile-picture">
                <!-- <img src="https://picsum.photos/200/200" alt=""> -->
                <img class="rounded-circle" :src="base64File">
                <md-button @click="clickOnFileInput()" class="md-fab md-primary">
                  <md-icon>add_a_photo</md-icon>
                </md-button>
              </div>
              <md-field v-if="imageToUpload" style="margin-top: 1rem;">
                <label>Insira a descrição da imagem</label>
                <md-input v-model="imgCaption" required></md-input>
              </md-field>
            </md-dialog-content>
            <md-dialog-actions>
              <md-button class="md-acent md-raised" @click="closeAddImgModal()">Close</md-button>
              <md-button :disabled="!imageToUpload || !imgCaption" class="md-primary md-raised" @click="uploadNewImage()">Add</md-button>
            </md-dialog-actions>
          </md-dialog>
          <p class="no-pic-message" v-if="pictures.length == 0">
            Nenhuma imagem inserida, clique no botão ' + ' para adicionar
          </p>
          <md-card v-else v-for="(picture, index) in pictures" :key="index" >
            <div class="close-icon-container" @click="deleteImage(picture.id)">
              <md-icon>delete</md-icon>
            </div>
            <md-card-media-cover md-solid style="clear:both">
              <md-card-media md-ratio="1:1">
                <img :src="'http://25.20.118.56/gofunder/'+picture.picture_url">
              </md-card-media>
              <md-card-area>
                <div class="image-description">
                  <p>{{picture.name}}</p>
                </div>
              </md-card-area>
            </md-card-media-cover>
          </md-card>
        </div>
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
          <br>
          <md-button :disabled="loading" class="md-fab md-primary" @click="showAddImg = true">
            <md-icon>add</md-icon>
          </md-button>
        </div>
      </div>
    </md-tab>
    <md-tab id="tab-question_answer" md-label="Faqs" md-icon="question_answer">
      <div class="md-layout md-grutter md-alignment-center-center">
        <md-list class="md-double-line md-size-100">
          <md-subheader>Faqs</md-subheader>

          <md-divider></md-divider>
          <md-list-item v-for="(faq, index) in faqList" :key="index" class="bordered">
            <div class="md-list-item-text">
              <span>{{faq.question}}</span>
              <span>{{faq.answer}}</span>
            </div>
            <md-button class="md-icon-button" @click="openEditFaqModal(faq)">
              <md-icon>edit</md-icon>
            </md-button>
            <md-button class="md-icon-button" @click="deleteFaq(faq.id)">
              <md-icon>delete</md-icon>
            </md-button>
          </md-list-item>
        </md-list>
      </div>
      <div class="md-layout md-grutter md-alignment-center-center">
        <md-button class="md-fab md-primary" @click="createFaq = true">
          <md-icon>add</md-icon>
        </md-button>
      </div>

      <div>
        <md-dialog :md-active.sync="createFaq">
          <md-dialog-title>Criar novo FAQ</md-dialog-title>
          <md-dialog-content>
            <md-field>
              <label>Escreva uma pergunta</label>
              <md-input v-model="faqQuestion" required></md-input>
            </md-field>
            <md-field>
              <label>Escreva uma resposta</label>
              <md-input v-model="faqAnswer" required></md-input>
            </md-field>
          </md-dialog-content>
          <md-dialog-actions>
            <md-button class="md-acent md-raised" @click="resetFaq()">Close</md-button>
            <md-button :disabled="!faqQuestion || !faqAnswer" class="md-primary md-raised" @click="addFaq()">Add</md-button>
          </md-dialog-actions>
        </md-dialog>
        <md-dialog :md-active.sync="edittingFaq">
          <md-dialog-title>Editar FAQ</md-dialog-title>
          <md-dialog-content>
            <md-field>
              <label>Edite sua pergunta</label>
              <md-input v-model="faqEditQuestion" required></md-input>
            </md-field>
            <md-field>
              <label>Edite sua resposta</label>
              <md-input v-model="faqEditAnswer" required></md-input>
            </md-field>
          </md-dialog-content>
          <md-dialog-actions>
            <md-button class="md-acent md-raised" @click="resetFaq()">Close</md-button>
            <md-button :disabled="!faqEditQuestion || !faqEditAnswer" class="md-primary md-raised" @click="editFaq()">Edit</md-button>
          </md-dialog-actions>
        </md-dialog>
      </div>
    </md-tab>
    <md-tab id="tab-share" md-label="Social networks" md-icon="share"></md-tab>
  </md-tabs>
</div>
</template>
<script>
import VueCkeditor from '@/components/ckeditor/'
import {mapState} from 'vuex'
export default {
  components: {
    VueCkeditor
  },
  data() {
    return {
      faqOnEdit: null,
      edittingFaq: false,
      faqEditAnswer: null,
      faqEditQuestion: null,
      faqQuestion: null,
      faqAnswer: null,
      faqList: [],
      loading: false,
      pictureUrl: null,
      editorData: null,
      imageToUpload: null,
      base64File: null,
      imgCaption: null,
      showAddImg: false,
      config: {
        height: 400,
        extraPlugins: ['youtube', 'imageresize', 'emoji']
      },
      showDialog: false,
      createFaq: false,
      allow: true,
      pictures: [],
    }
  },
  computed: {
    ...mapState(['user']),
  },
  methods: {
    //GALLERY
    loadGallery() {
      global.$get("/Campaign/getgalery?campaign_id="+this.$route.params.id, {}, this.user.token)
        .then(response => {
            this.pictures = response.data
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
    },
    clickOnFileInput() {
      document.getElementById('input-file').click()
    },
    pickImg(evt) {
      let reader = new FileReader()
      this.imageToUpload = evt.target.files[0]
      reader.onload = (e) => {
        this.base64File = e.target.result;
      }
      reader.readAsDataURL(evt.target.files[0])
    },
    uploadNewImage() {
      this.showAddImg = false
      this.loading = true
      let data = {
        image: this.imageToUpload,
        title: this.imgCaption
      }
      global.$post("/Campaign/upload_gallery", data, this.user.token)
        .then(response => {
            this.pictureUrl = response.data.gallery_url
            let data = {
              picture_url: this.pictureUrl,
              campaign_id: this.$route.params.id,
              legend: this.imgCaption
            }
            global.$post("/Campaign/addgalery", data, this.user.token)
            .then(res => {
                this.loadGallery()
            })
            .catch(err => {
              let validErr = (err && err.response && err.response.data && err.response.data.error)
              alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
            })
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
        .finally(() => {
          this.loading = false

        })
    },
    deleteImage(id) {
      this.loading = true
      let data = {
        id: id
      }
      global.$post("/Campaign/deletegalery", data, this.user.token)
      .then(res => {
          this.loadGallery()
      })
      .catch(err => {
        let validErr = (err && err.response && err.response.data && err.response.data.error)
        alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
      })
      .finally(() => {
        this.loading = false
      })
    },
    closeAddImgModal(){
      this.showAddImg = false
      this.imageToUpload = null
      this.base64File = null
      this.imgCaption = null
    },
    //FAQ
    loadFaq() {
      global.$get("/Campaign/getfaq?campaign_id="+this.$route.params.id, {}, this.user.token)
      .then(res => {
          this.faqList = res.data
      })
      .catch(err => {
        let validErr = (err && err.response && err.response.data && err.response.data.error)
        alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
      })
    },
    addFaq() {
      this.createFaq = false
      this.loading = true
      let data = {
        campaign_id: this.$route.params.id,
        question: this.faqQuestion,
        answer: this.faqAnswer
      }
      global.$post("/Campaign/addfaq", data, this.user.token)
      .then(res => {
          this.loadFaq()
      })
      .catch(err => {
        let validErr = (err && err.response && err.response.data && err.response.data.error)
        alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
      })
      .finally(() => {
        this.loading = false
      })
    },
    resetFaq() {
      this.createFaq = false
      this.faqQuestion = null,
      this.faqAnswer = null
    },
    deleteFaq(id) {
      this.loading = true
      let data = {
        id: id
      }
      global.$post("/Campaign/deletefaq", data, this.user.token)
      .then(res => {
          this.loadFaq()
      })
      .catch(err => {
        let validErr = (err && err.response && err.response.data && err.response.data.error)
        alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
      })
      .finally(() => {
        this.loading = false
      })
    },
    openEditFaqModal(faq) {
      this.edittingFaq = true
      this.faqOnEdit = faq
      this.faqEditAnswer = faq.answer
      this.faqEditQuestion = faq.question
    },
    editFaq() {
      this.loading = true
      this.edittingFaq = false
      let data = {
        id: this.faqOnEdit.id,
        answer: this.faqEditAnswer,
        question: this.faqEditQuestion
      }
      global.$post("/Campaign/deletefaq", data, this.user.token)
      .then(res => {
          this.loadGallery()
      })
      .catch(err => {
        let validErr = (err && err.response && err.response.data && err.response.data.error)
        alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
      })
      .finally(() => {
        this.loading = false
      })
    },
  },
  
  mounted() {
    this.loadGallery()
    this.loadFaq()
  }
}
</script>
<style lang="scss" scoped>
.bordered {
  &:not(:last-child) {
    border-bottom: 1px solid var(--md-theme-default-divider, rgba(0,0,0,0.12));
  }
}
.md-dialog {
    width: 568px;
}
.loading-overlay {
  z-index: 10;
  top: 0;
  left: 0;
  right: 0;
  position: absolute;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
}
.no-pic-message {
  font-weight: bold;
}
.close-icon-container {
    padding: 10px;
    position: absolute;
    right: 0;
    z-index: 100;
  &:hover {
    background: #ccc;
    cursor: pointer;
  }
  i {
    font-size: 2rem !important;
  }
}
.image-description {
  text-align: center;
  p {
    color:white;
  }
}
.profile-picture {
  position: relative;
  img {
    width: 300px;
    height: auto;
  }
  button {
    position: relative;
  }

}
</style>
