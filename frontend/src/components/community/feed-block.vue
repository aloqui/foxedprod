<template>
  <div class="feed-block">

    <div class="feed-block-inner mt-4 p-2" v-for="item in items">
      <div class="feed-block-inner__header mb-3">
        <img class="picture-placeholder m-1" src="http://alloutput.com/wp-content/uploads/2013/11/black-circle-mask-to-fill-compass-outline.png" alt="">
        <a class="mt-2" href="">{{item.name}}</a>
      </div>
      <div class="feed-block-inner__post">
        <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'feed-block',
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
      .feed-block-inner__header {
 
      }
      .feed-block-inner__post {
      }
    }
  }
</style>