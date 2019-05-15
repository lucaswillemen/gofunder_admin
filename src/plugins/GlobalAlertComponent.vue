<template>
  <main>
    <component>
      {{list.title}}
    </component>
  </main>
</template>

<script>
import plugin from './GlobalAlert'
import { events } from './events'
export default {
  data() {
    return {
      opts:{}
    }
  },
  methods: {
    addItem(event) {
      console.log('aqqqq')
      this.opts = event
    }
  },
  mounted() {
      console.log('mmm')

    events.$on('add', this.addItem);
  }
}
</script>

<style>

</style>
