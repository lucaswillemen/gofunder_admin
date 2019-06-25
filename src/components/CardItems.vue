<template>
  <section class="cards-container">
    <div class="card-container" v-for="(item, index) in items" :key="index">
      <slot name="img" :item="item">
        <div class="img-container">
          <img :src="$url +item.cover_url" onerror="this.src='https://via.placeholder.com/150'" alt="">
          <md-button v-if="!hideDelete" class="md-fab md-mini delete-btn" @click="openDeleteConfirmation(item.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </div>
      </slot>
      <slot name="body" :item="item">
        <div class="item-body">
          <div class="item-title">
            <h2>{{item.title}}
            </h2>
          </div>
          <div class="item-description">
            <p>{{item.description}}
            </p>
          </div>
        </div>
      </slot>
      <slot v-if="!hideFooter" name="footer" :item="item">  
        <div class="item-footer">
          <router-link :to="`/edit/${item.id}`">
            <md-button class="custom-color-1">
              <md-icon>edit</md-icon>{{"CARD_ITEMS::Editar" | fix}}
            </md-button>
          </router-link>
          <md-button class="custom-color-2" @click="previewCampaign(item.id, item.title)">
            <md-icon>find_in_page</md-icon>{{"CARD_ITEMS::Prévia" | fix}}
          </md-button>
          <md-button class="custom-color">
            <md-icon>send</md-icon>{{"CARD_ITEMS::Publicar" | fix}}
          </md-button>
        </div>
      </slot>
    </div>
  </section>
</template>

<script>
export default {
  name: 'CardItems',
  props: ['items', 'hideDelete', 'hideFooter'],
  data() {
    return {

    }
  },
  methods: {
    previewCampaign(id, title) {
      window.open(this.$urlFrontend + '/project-info/' + id + title);
    }
  }
  
}
</script>

<style lang="scss" scoped>
.cards-container {
  display: flex;
  flex-wrap: wrap;
  // display: grid;
  // grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  // grid-gap: 20px;
  @media (max-width: 679px) {
    justify-content: center;
  }

  .card-container {
    box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);
    margin-top: 1rem;
    margin-right: 1rem;
    display: flex;
    flex-direction: column;
    background-color: white;
    // margin-bottom: 1rem;
    width: 310px;
    @media (max-width: 330px) {
      width: 295px;
      margin-right: 0;
    }
    .img-container {
      position: relative;
      img {
        width: 100%;
        height: 225px;
      }
      .delete-btn {
        position: absolute;
         right: 0;
      }
    }
    .item-body {
      display: flex;
      flex-direction: column;
      flex-wrap: wrap;
      padding: 1rem;
      word-break: break-word;
      .item-title {
        h2 {
          font-weight: 500;
        }
      }
      .item-description {
        p {
          margin: 0;
        }
      }
    }
    .item-footer {
      display: flex;
      position: relative;
      margin-top: auto; 
      justify-content: center;
      .custom-color {
        .md-icon.md-icon-font.md-theme-default{
          color: #31a235;
        }
      }
      .custom-color-2 {
        .md-icon.md-icon-font.md-theme-default{
          color: #244584;
        }
      }
      .custom-color-1 {
        .md-icon.md-icon-font.md-theme-default{
          color: rgb(134, 41, 168);

        }
      }
      &::before {
        position: absolute;
        content: '';
        border-bottom: 1px solid rgba(0,0,0,0.12);;
        width: 90%;
        transform: translateX(-50%);
        left: 50%;
      }
    }
  }
}

</style>
