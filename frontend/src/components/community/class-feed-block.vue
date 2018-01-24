<template>
  <div class="feed-block">

    <div class="feed-block-inner mt-4 p-2" v-for="item in items">
      <div class="feed-block-inner__header mb-3">
        <img class="picture-placeholder mr-1" src="http://alloutput.com/wp-content/uploads/2013/11/black-circle-mask-to-fill-compass-outline.png" alt="">
        <a class="mt-2" href="">{{item.name}}</a>
      </div>
      <div class="feed-block-inner__post">
        <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
        <p>Lorem Ipsum this activity with best effort.</p>
        <a class="btn btn-success" type="submit">Start Coding</a>
      </div>
      
    </div>

  </div>
</template>
<script>
  export default {
    name: 'class-feed-block',
    data() {
      return {
        items: [{
            name: 'Anna Lumanlan',
            post: ''
          },
          {
            name: 'Franchette Dizon',
            post: ''
          },
          {
            name: 'Chester Cueto',
            post: ''
          }
        ]
      }
    }
  }
</script>

<style lang="scss">
  .feed-block {

    width: 100%;
    .feed-block-inner {
      //border: 1px solid #000;
      .feed-block-inner__header {
      }
      .feed-block-inner__post {
        img {
          width: 100%;
        }
      }
    }
  }
</style>