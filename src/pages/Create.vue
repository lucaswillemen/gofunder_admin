<template>
<md-steppers :md-active-step.sync="actualStep" md-linear md-alternative>
  <md-step id="first" md-label="Objetivo" :md-done.sync="steps.first">
    <div class="md-layout md-gutter md-alignment-center-center">
      <md-layout class="md-layout-item  md-size-40 md-small-size-100 md-medium-size-50 ">
        <div @click="objetivo.allow_funds = !objetivo.allow_funds" style="cursor:pointer;">
          <md-card class="md-layout md-alignment-center-center md-elevation-4" :class="{'md-primary': objetivo.allow_funds}">
            <md-empty-state class="md-empty-state-icon-first" md-icon="account_balance_wallet" md-label="Arrecadar fundos" md-description="Receba doacoes e envie recompensas para os apioadores da sua campanha em forma de gratidao pela ajuda.">
            </md-empty-state>

          </md-card>
        </div>
        <div @click="objetivo.allow_sppedup = !objetivo.allow_sppedup" style="cursor:pointer;">
          <md-card class="md-layout md-alignment-center-center " :class="{'md-primary': objetivo.allow_sppedup}">
            <md-empty-state class="md-empty-state-icon-first" md-icon="fast_forward" md-label="Acelerar seu projeto" md-description="Mostre seu projeto para tutores e investidores para ganhar apoio qualificado para fazer sua ideia acontecer.">
            </md-empty-state>

          </md-card>
        </div>
      </md-layout>
      <md-layout class="md-layout-item  md-size-40 md-small-size-100 md-medium-size-50">
        <div @click="objetivo.allow_presale = !objetivo.allow_presale" style="cursor:pointer;">
          <md-card class="md-layout md-alignment-center-center " :class="{'md-primary': objetivo.allow_presale}">
            <md-empty-state class="md-empty-state-icon-first" md-icon="shopping_basket" md-label="Venda antes de terminar"
              md-description="Faca uma prevenda do seu produto enquanto vc finaliza seu projeto e analise o comportamento e aprovacao do publico.">
            </md-empty-state>

          </md-card>
        </div>
        <div @click="objetivo.allow_share = !objetivo.allow_share" style="cursor:pointer;">
          <md-card class="md-layout md-alignment-center-center " :class="{'md-primary': objetivo.allow_share}">

            <md-empty-state class="md-empty-state-icon-first" md-icon="share" md-label="Compartilhe sua ideia" md-description="Encontre acionistas que irao ajudar a financiar seu projeto e divida os lucros com quem te ajudou.">
            </md-empty-state>

          </md-card>
        </div>
      </md-layout>
    </div>
    <div class="md-layout md-alignment-center-center">
      <md-button class="md-fab md-primary" :disabled="!Object.values(objetivo).includes(true)" @click="moveStep('first', 'second')">
        <md-icon>arrow_forward</md-icon>
      </md-button>
    </div>

  </md-step>

  <md-step id="second" md-label="Caracteristicas" :md-done.sync="steps.second" :md-editable="false">
    <div class="md-layout md-gutter md-alignment-center-center">
      <md-card class="md-layout-item md-size-50 md-small-size-100">
        <md-card-header class="md-layout md-gutter md-alignment-center-center">
          <div class="md-title">Vamos identificar o tipo do seu projeto</div>
        </md-card-header>
        <md-card-content>

          <md-field>
            <label>Qual valor vc espera arrecadar para concluir seu projeto?</label>
            <span class="md-prefix">$</span>
            <md-input v-model="caracteristicas.amount" required></md-input>
      <span style="color:red" v-if="caracteristicas.amount< 100">O valor mínimo da sua campanha precisa ser $100,00 </span>
          </md-field>
          <md-field>
            <label for="developSelect">O seu projeto esta sendo desenvolvido por</label>
            <md-select v-model="caracteristicas.opt_develop" id="developSelect">
              <md-option :value="opt.id" v-for="(opt, index) in options.campaing_develop" :key="index">{{opt.name}}</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label for="typeSelect">Qual tipo de seu projeto</label>
            <md-select v-model="caracteristicas.opt_type" id="typeSelect">
              <md-option :value="opt.id" v-for="(opt, index) in options.campaing_type" :key="index">{{opt.name}}</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label for="categorySelect">Escolha a categoria que melhor se adapta ao seu projeto</label>
            <md-select v-model="caracteristicas.opt_category" id="categorySelect">
              <md-option :value="opt.id" v-for="(opt, index) in options.campaing_category" :key="index">{{opt.name}}</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label for="mfundsSelectovie">Como voce gostaria de receber seus fundos</label>
            <md-select v-model="caracteristicas.opt_funds" id="fundsSelect">
              <md-option :value="opt.id" v-for="(opt, index) in options.campaing_funds" :key="index">{{opt.name}}</md-option>
            </md-select>
          </md-field>
        </md-card-content>
      </md-card>
    </div>
    <div class="md-layout md-alignment-center-center">
      <md-button class="md-fab md-primary" @click="moveStep('second', 'third')">
        <md-icon>arrow_forward</md-icon>
      </md-button>
    </div>
  </md-step>

  <md-step id="third" md-label="Informacoes" :md-done.sync="steps.third">
    <div class="md-layout md-gutter md-alignment-center-center">
      <md-card class="md-layout-item md-size-50 md-small-size-100">
        <md-card-header class="md-layout md-gutter md-alignment-center-center">
          <div class="md-title">Vamos ver como esta o andamento</div>
        </md-card-header>
        <md-card-content>
          <md-field>
            <label>Qual o nome/titulo do seu projeto</label>
            <md-input v-model="informacoes.title"></md-input>
          </md-field>
          <md-field>
            <label>Faca um resumo basico do seu projeto</label>
            <md-textarea v-model="informacoes.description" md-counter="80"></md-textarea>
          </md-field>

          <!-- <md-autocomplete v-model="selectedCountry" :md-options="options.country" md-dense md-layout="box" :md-open-on-focus="false" @md-selected="selected()">
                            <label>Em qual pais o seu projeto esta sendo desenvolvido?</label>
                            <template slot="md-autocomplete-item" slot-scope="{item, term }">
                                <md-highlight-text :item="item.country_name" :md-term="term">{{ item.country_name }} ({{item.country_code}})</md-highlight-text>
                            </template>
                        </md-autocomplete> -->
          <md-field>
            <md-select v-model="informacoes.country_id" name="movie" id="movie" placeholder="Em qual pais o seu projeto esta sendo desenvolvido?">
              <md-option :value="opt.id" v-for="(opt, index) in options.country" :key="index">{{opt.country_name}}</md-option>
            </md-select>
          </md-field>
          <md-checkbox v-model="informacoes.isStarted" class="md-primary">Seu projeto ja foi iniciado?</md-checkbox>

          <md-datepicker v-model="informacoes.startAt" md-immediately>
            <label>Quando pretende iniciar</label>
          </md-datepicker>

          <md-datepicker v-model="informacoes.finishAt" md-immediately>
            <label>E quando pretende finalizar</label>
          </md-datepicker>

          <md-checkbox v-model="informacoes.isCountryShared" class="md-primary">Voce gostaria que pessoas de outros paises vissem seu projeto?</md-checkbox>
        </md-card-content>
      </md-card>
    </div>
    <div class="md-layout md-alignment-center-center">
      <md-button class="md-fab md-primary">
        <md-icon>arrow_forward</md-icon>
      </md-button>
    </div>
  </md-step>

  <md-step id="fourth" md-label="Fourth Step" :md-done.sync="steps.fourth">
    <div class="md-layout md-gutter md-alignment-center-center">
      <md-card class="md-layout-item md-size-50 md-small-size-100">
        <md-empty-state md-icon="access_time" md-label="Por enquanto e so!"
          md-description="Para manter nossa plataforma sempre atrativa para as pessoas interessados, cuidamos manualmente de cada projeto publicado com muito carinho. Nosso time de especialista vai analizar a sua proposta e retornaremos em breve">
          <md-button class="md-raised md-primary" @click="createCampaing()">Finalizar Camapanha</md-button>
        </md-empty-state>
      </md-card>
    </div>
  </md-step>
</md-steppers>
</template>
<script>
import {
  mapState
} from 'vuex'
export default {
  name: 'Create',
  data() {
    return {
      objetivo: {
        allow_funds: false,
        allow_sppedup: false,
        allow_presale: false,
        allow_share: false
      },
      caracteristicas: {
        amout: null,
        opt_category: null,
        opt_develop: null,
        opt_funds: null,
        opt_type: null,
      },
      informacoes: {
        title: null,
        description: null,
        isStarted: false,
        startAt: null,
        finishAt: null,
        country_id: null,
        isCountryShared: false,
      },
      options: {},
      steps: {
        first: false,
        second: false,
        third: false,
        fourth: false
      },
      actualStep: null
    }
  },
  computed: {
    ...mapState(['user']),
  },
  methods: {
    getOptions() {
      global.$get("/Campaing/option", {}, this.user.token)
        .then(response => {
          console.log('deu', response)
          this.options = {
            ...response.data
          }
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })
    },
    createCampaing() {
      let data = {
        ...this.objetivo,
        ...this.caracteristicas,
        ...this.informacoes,
        finishAt: this.informacoes.finishAt ? this.informacoes.finishAt.toISOString() : null,
        startAt: this.informacoes.startAt ? this.informacoes.startAt.toISOString() : null
      }
      console.log('data:', data)

      global.$get("/Campaing/create", data, this.user.token)
        .then(response => {
          console.log('deu', response)
        })
        .catch(err => {
          let validErr = (err && err.response && err.response.data && err.response.data.error)
          alert(validErr ? err.response.data.error : "INVALID_ERROR") // enviar alerta
        })

    },
    moveStep(actual, next) {
      this.steps[actual] = true
      if (next) {
        this.actualStep = next
      }
    },

  },
  mounted() {
    this.getOptions()
  }
}
</script>

<style lang="scss">
.md-card.md-theme-default {
    background-color: #fff;
    background-color: var(--md-theme-default-background, #fff);
    color: rgba(0,0,0,0.87);
    color: var(--md-theme-default-text-primary-on-background, rgba(0,0,0,0.87));
    margin-bottom: 40px;
}

.md-empty-state-icon-first > div > .md-empty-state-icon {
    color: var(--md-theme-default-icon-on-background, rgba(0, 0, 0, 0.08))!important;
    width: 160px;
    position: relative;
    top: 50px;
    min-width: 160px;
    height: 24px;
    font-size: 160px!important;
    margin: 0;
}
</style>
