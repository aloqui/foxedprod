<template>
  <div>
    <div class="forum-post__header full-block__post m-2 p-3" v-for="post in posts">
      <a class="forum-post__title mb-5">{{post.title}}</a>
      <div class=" d-flex flex-row justify-content-start  align-items-center mt-3">
        <img class="picture-placeholder mr-3" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
          alt="">
        <a class="mb-0" href="">{{post.username}} </a>
        <p class="mb-0 ml-1"> posted this 3 minutes ago</p>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'hot-topics',
    data() {
      return {
        posts: [{
            username: 'Franchette Dizon',
            title: 'Web Development technologies to be used!',
            content: 'Pellentesque vel purus a diam consectetur consectetur. Vivamus ut molestie ligula. Donec dignissim nulla vitae ligula rutrum, semper aliquam nisi vulputate. Nunc ut suscipit mauris. Integer ut neque facilisis, lobortis lorem vitae, vehicula risus. Cras..'
          },
          {
            username: 'Chester Cueto',
            title: 'Vue vs. React',
            content: 'Ut lacinia in sapien nec fringilla. Nullam non mauris magna. Curabitur iaculis placerat ex, ac cursus leo rutrum eget. Morbi viverra nisl eget massa fermentum accumsan. Congue quis..'
          },
          {
            username: 'Al Oquindo',
            title: 'Found this new technology. Might be useful for you guys!',
            content: 'Curabitur iaculis placerat ex, ac cursus leo rutrum eget. Morbi viverra nisl eget massa fermentum accumsan.'
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
      .feed-block-inner__header {}
      .feed-block-inner__post {
        img {
          width: 100%;
        }
      }
    }
  }
</style>