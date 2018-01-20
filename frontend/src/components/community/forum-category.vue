<template>
  <div class="forum-category">
    <div class="forum-post__header section-block mt-2" v-for="category in categories" v-bind:key="category">
      <a class="forum-post__title ">
        <router-link class="nav-item forum__title" :to="`/community/${category.slug}`">
          {{category.name}}
        </router-link>
      </a>
      <div class="forum__sub-title p-1 text-center">{{category.title}} Has {{category.threads.length}} Discussions!</div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'forum-category',
    data() {
      return {
        categories: {}
      }
    },
    methods: {
      // init() {
      //   console.log(this.$route); //should return object
      //   console.log(this.$route.params); //should return object 
      //   console.log(this.$route.params.id); //should return id of URL param 
      // }
    },
    mounted() {
      this.$http.get('api/channels')
        .then(response => {
          this.categories = response.body
          console.log(response.body)
        })
      //   axios.get('/threads' )
      //         .then(({
      //             data
      //         }) => then(data)); 
    },
  }

</script>
<style lang="scss">
  .picture-placeholder {
    width: 50px;
  }

  .feed-block {
    width: 100%;
    .feed-block-inner {
      //border: 1px solid #000;
      .feed-block-inner__header {}
      .feed-block-inner__post {
        img {
          width: 40px;
        }
      }
    }
  }

</style>
