<template>
<div>
  <md-tabs class="md-primary" md-alignment="fixed">
    <md-tab id="tab-pages" md-label="HTML Overview" md-icon="pages">

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
              <md-input v-model="title" name="title" required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
            <md-field>
              <label>Qual o valor do seu perk?</label>
              <md-input v-model="title" name="title" required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
            <md-field>
              <label>Seu perk tem estoque?</label>
              <md-input v-model="title" name="title" required></md-input>
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
          <md-card>
            <md-card-media-cover md-solid>
              <md-card-media md-ratio="1:1">
                <img src="https://cb2.scene7.com/is/image/CB2/BlackClayMug8ozSHF16/">
              </md-card-media>
              <md-card-area>

                <md-button class="">
                  <md-icon>delete</md-icon> Remove
                </md-button>
              </md-card-area>
            </md-card-media-cover>
          </md-card>
          <md-card>
            <md-card-media-cover md-solid>
              <md-card-media md-ratio="1:1">
                <img src="https://cb2.scene7.com/is/image/CB2/BlackClayMug8ozSHF16/">
              </md-card-media>
              <md-card-area>

                <md-button class="">
                  <md-icon>delete</md-icon> Remove
                </md-button>
              </md-card-area>
            </md-card-media-cover>
          </md-card>
          <md-card>
            <md-card-media-cover md-solid>
              <md-card-media md-ratio="1:1">
                <img src="https://cb2.scene7.com/is/image/CB2/BlackClayMug8ozSHF16/">
              </md-card-media>
              <md-card-area>

                <md-button class="">
                  <md-icon>delete</md-icon> Remove
                </md-button>
              </md-card-area>
            </md-card-media-cover>
          </md-card>
          <md-card>
            <md-card-media-cover md-solid>
              <md-card-media md-ratio="1:1">
                <img src="https://cb2.scene7.com/is/image/CB2/BlackClayMug8ozSHF16/">
              </md-card-media>
              <md-card-area>

                <md-button class="">
                  <md-icon>delete</md-icon> Remove
                </md-button>
              </md-card-area>
            </md-card-media-cover>
          </md-card>
        </div>
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-33 md-size-25">
          <br>
          <md-button class="md-fab md-primary" @click="showDialog = true">
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
          <md-list-item>
            <div class="md-list-item-text">
              <span>Alguma pergunta bem perguntada por aqui </span>
              <span>Alguma resposta com bom senso e logiga bem aqui em baixo pra ver o tamanho do espaco</span>
            </div>
          </md-list-item>
          <md-divider></md-divider>
          <md-list-item>
            <div class="md-list-item-text">
              <span>Alguma pergunta bem perguntada por aqui </span>
              <span>Alguma resposta com bom senso e logiga bem aqui em baixo pra ver o tamanho do espaco</span>
            </div>
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
          <md-dialog-title>Create new FAQ</md-dialog-title>
          <md-dialog-content>
            <md-field>
              <label>Escreva uma pergunta</label>
              <md-input v-model="title" name="title" required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
            <md-field>
              <label>Escreva uma resposta</label>
              <md-input v-model="title" name="title" required></md-input>
              <span class="md-error">Informe o titulo</span>
            </md-field>
          </md-dialog-content>
          <md-dialog-actions>
            <md-button class="md-acent md-raised" @click="createFaq = false">Close</md-button>
            <md-button class="md-primary md-raised" @click="createFaq = false">Add</md-button>
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

export default {
  components: {
    VueCkeditor
  },
  data() {
    return {
      editorData: null,
      config: {
        height: 400,
        extraPlugins: ['youtube', 'imageresize', 'emoji']
      },
      showDialog: false,
      createFaq: false,
      allow: true
    }
  }
}
</script>
<style lang="scss" scoped>
.md-dialog {
    width: 568px;
}
</style>
