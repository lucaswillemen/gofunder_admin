<template>
<main>
  <div class="md-layout-item md-small-size-100 md-size-100">
    <md-card>
      <md-empty-state style="padding-bottom: 0 !important;" md-icon="find_in_page" :md-label="$f('ANALYSIS::Publique sua campanha!')"
        :md-description="$f('ANALYSIS::Aqui você concorda que finalizou todas as edições da campanha e a envia para nossos profissionais analisarem para você!')"></md-empty-state>
      <md-card-content style="display:flex; align-items: center; flex-direction: column;">
        <md-checkbox id="agree" v-model="agree">{{"ANALYSIS::Você concorda que ja editou tudo que precisava em sua campanha?" | fix}}</md-checkbox>
        <p v-if="agree">
          {{"ANALYSIS::Ao clicar em enviar campanha você" | fix}}
          <strong>{{"ANALYSIS::NUNCA MAIS!" | fix}}</strong> {{"ANALYSIS::poderá editá-la novamente. Apenas envie sua campanha caso tenha certeza que tudo está dentre os conformes!" | fix}}
        </p>
      </md-card-content>
      <md-card-actions>
        <md-button class="md-raised preview-btn" @click="previewCampaign()">{{"ANALYSIS::Pré Visualizar Campanha" | fix}}</md-button>
        <md-button :disabled="!agree" class="md-primary md-raised">{{"ANALYSIS::Enviar campanha" | fix}}</md-button>
      </md-card-actions>
    </md-card>
  </div>
</main>
</template>

<script>
export default {
  data() {
    return {
      agree: false
    };
  },
  methods: {
    previewCampaign() {
      window.open(`${this.$urlFrontend}/project-info/${this.$route.params.id}/${this.$route.params.title}`);
    }
  },
  mounted() {

  }
};
</script>

<style lang="scss" scoped>
.preview-btn {
    background-color: #244584 !important;

}
</style>
