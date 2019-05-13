<template class=" md-grutter">
  <div class="md-layout md-grutter">
  
  </div>
</template>
<script>
import {mapState} from 'vuex'
export default {
  data() {
    return {
      campaigns: []
    }
  },
  computed: {
    ...mapState(['user'])
  },
  methods: {    
  },
  mounted() {

  }
}
</script>

