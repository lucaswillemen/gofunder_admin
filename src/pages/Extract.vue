<template>
<main>
  <md-tabs class="md-primary">
    <md-tab id="tab-home" :md-label="$f('EXTRACT::Extratos de Usuário')" md-icon="payment">
      <UserExtract></UserExtract>
    </md-tab>
    <md-tab id="tab-doacoes" :md-label="$f('EXTRACT::Extratos de Campanha')" md-icon="card_giftcard">
      <CampaignExtract></CampaignExtract>
    </md-tab>
    <md-tab id="tab-affiliate" :md-label="$f('EXTRACT::Extratos de Produtos')" md-icon="card_membership">
      <ProductExtract></ProductExtract>
    </md-tab>

  </md-tabs>

</main>
</template>

<script>
import UserExtract from "@/components/Extract/UserExtract"
import CampaignExtract from "@/components/Extract/CampaignExtract"
import ProductExtract from "@/components/Extract/ProductExtract"


export default {
  name: 'Extract',
  components: {
    UserExtract,
    CampaignExtract,
    ProductExtract
  }
}
</script>

<style lang="scss" scoped>

</style>
