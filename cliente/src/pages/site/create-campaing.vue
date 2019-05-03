<template>
<div class="createCampaignCss">
  <main-header></main-header>

  <div class="container">
    <b-row>
      <b-col lg="12">
        <div class="main-title">
          <span>Iniciar Campanha</span>
        </div>
        <div class="content">
          <div class="mb-5">
            <div class="title">
              <span>Quanto você quer arrecadar??</span>
            </div>

              <b-form-input id="value" step="0.01" placeholder="Digite o valor da sua campanha aqui..." type="number" v-model="form.cash"></b-form-input>

            <small class="text-danger" v-show="form.cash < 100 && form.cash">Valor mínimo $100,00</small>
          </div>


          <div class="mb-5">
            <div class="title">
              <span>Qual o título do seu projeto?</span>
            </div>
            <b-form-input id="title" type="text" v-model="form.title" placeholder="Titulo da Campanha"></b-form-input>
            <small class="text-danger" v-show="form.title && (form.title.length > 128 || form.title.length < 32)">Seu titulo deve ter entre 32 e 128 caracteres</small>
          </div>

          <div class="mb-5">
            <div class="title">
              <span>Qual descrição do projeto?</span>
            </div>
            <b-form-input id="description" type="text" v-model="form.description" placeholder="Digite aqui uma breve descrição de sua campanha"></b-form-input>
            <small class="text-danger" v-show="form.description && (form.description.length > 254 || form.description.length < 64)">Sua descrição deve ter entre 64 e 254 caracteres</small>
          </div>

          <div class="mb-5">
            <div class="title">
              <span>Qual prazo final da campanha?</span>
            </div>
            <b-form-input id="description" type="date" v-model="form.end_date" placeholder=""></b-form-input>
            <small class="text-danger" v-show="(new Date(form.end_date).getTime() <= new Date().getTime())">Sua data é inválida, deve ser superior ao dia de hoje</small>
          </div>


          <div class="btn-noborder">
            <b-button @click="createCampaign()" :disabled="(new Date(form.end_date).getTime() <= new Date().getTime()) || (form.cash < 100) || (!form.title || form.title.length > 128 || form.title.length < 32) || (!form.description || form.description.length > 254 || form.description.length < 64)">Criar
              Campanha</b-button>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>

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
  data() {
    return {
      form: {
        cash: '',
        description: '',
        title: '',
        end_date: null,
        coin_type: 'USD'
      }
    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {
    createCampaign: function() {
      this.$awn.asyncBlock(global.$post("/Campaign/create", this.form, this.user.token))
        .then(response => {
          this.$awn.success("Campanha criada com sucesso!")
          location.href = "/#/user/campaing/edit/" + response.data.MSG
        })
        .catch(err => {
          this.$awn.alert("Ocorreu um erro ao criar a campanha!")
        })
    }
  }
}
</script>

<style lang="scss" scoped>
@import "Styles/colors.scss";

.createCampaignCss {
    .container {
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .main-title {
        margin-bottom: 10px;
    }

    .content {
        padding: 30px 40px;
        // text-align: center;
        border: 1px solid $orange;
        border-radius: 5px;

        div {
            margin: 10px 0;
        }

        input,
        select {
            background-color: transparent;
            border-color: $blue;
        }

        #value {
            width: 40%;
        }

        #title {
            width: 50%;
        }
        #description {
            width: 70%;
            height: 35px;
        }
        select {
            width: 16%;
        }

        input::placeholder {
            color: $blue;
        }

    }

    @media only screen and (max-width: 768px) {

        #value {
            width: 60%!important;
        }

        #title {
            width: 100%!important;
        }

        select {
            width: 60%!important;
        }

    }
}
</style>
