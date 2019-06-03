<template>
  
</template>

<script>
export default {

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
    width: 350px;
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
    .campaign-body {
      display: flex;
      flex-direction: column;
      flex-wrap: wrap;
      padding: 1rem;
      .campaign-title {
        h2 {
          font-weight: 500;
        }
      }
      .campaign-description {
        p {
          margin: 0;
        }
      }
    }
    .campaign-footer {
      display: flex;
      position: relative;
      margin-top: auto; 
      justify-content: center;
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
