<template>
  <div class="forum-category">
    <p class="font--bold mb-2">New Communities</p>
    <div class="" v-for="category in categories" v-bind:key="category">
      <router-link class="no-decoration" :to="`/community/${category.slug}`">
        <div class="mb-3">
          <p class="font--bold">
            {{category.name}}
          </p>
          <p class="content__helper">
            {{category.title}} Has {{category.threads.length}} Discussions!
          </p>
        </div>
      </router-link>
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
