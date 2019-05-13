<template>
  <div class="md-layout md-grutter md-alignment-center-center">
    <div class="md-layout-item md-small-size-100 md-size-100">
      <md-card>
        <md-card-content>
          <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
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
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  props: ['loadingFlag'],
  data() {
    return {
			editorData: null,
      editor: ClassicEditor,
			editorConfig: {},
			
			config: {
				height: 400,
				extraPlugins: ["youtube", "imageresize", "emoji"]
			},
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
