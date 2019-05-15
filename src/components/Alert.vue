<template>
  <main>
    <md-dialog-alert
      :md-active.sync="first"
      md-content="Your post has been deleted!"
      md-confirm-text="Cool!" />
  </main>
</template>

<script>
export default {
  data() {
    return {
     first: true,
    }
  },
  methods: {
    show() {

    },
    hide() {
      
    }
  }
}
</script>

<style>

</style>
