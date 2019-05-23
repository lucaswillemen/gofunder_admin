<template>
  <main>
    <md-tabs class="md-primary" >
      <md-tab id="tab-home" md-label="Extratos de Saques" md-icon="payment">
        <WithdrawExtract></WithdrawExtract>
      </md-tab>
       <md-tab id="tab-doacoes" md-label="Extratos de Doações" md-icon="card_giftcard">
        <DonationExtract></DonationExtract>
      </md-tab>
      <md-tab id="tab-affiliate" md-label="Extratos de Afiliados" md-icon="card_membership">
        <AffiliateExtract></AffiliateExtract>
      </md-tab>
      <md-tab id="tab-quota" md-label="Extratos de Cotas" md-icon="local_atm">
        <QuotaExtract></QuotaExtract>
      </md-tab>
      
    </md-tabs>
    
  </main>
</template>

<script>
import WithdrawExtract from "@/components/Extract/WithdrawExtract"
import DonationExtract from "@/components/Extract/DonationExtract"
import AffiliateExtract from "@/components/Extract/AffiliateExtract"
import QuotaExtract from "@/components/Extract/QuotaExtract"

export default {
  name: 'Extract',
  components: {
    WithdrawExtract,
    DonationExtract,
    AffiliateExtract,
    QuotaExtract
  }
}
</script>

<style lang="scss" scoped>

</style>

