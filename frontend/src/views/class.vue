<template>
  <div class="home">
    <!-- <nav-list></nav-list> -->
    <div class="container-fluid">
      <div class="row justify-content-sm-center">
        <div class="col-10">
          <div class="row">
            <div class="col-2">
              <div class="block-full-height d-flex justify-content-center align-items-start ">

                <div class="text-left mt-5">
                  <a href="">HI</a>
                  <hr>
                  <a class="btn btn-success text-center mb-2" type="submit">Code Play</a>
                  <br>
                  <a href="">Announcements</a>
                  <br>
                  <a href="">Assignments</a>
                  <br>
                  <a href="">Files</a>
                </div>

              </div>
            </div>
            <div class="col-6">
              <div class="block-full-height d-flex justify-content-center align-items-start">
                <class-feed-block></class-feed-block>
              </div>
            </div>
            <div class="col-4"> 
              <div class="block-full-height">
                <hr>
                <div class="row mt-3">
                  <p class="ml-2">Some discussions related to your group</p>
                  <hr>
                  <related-topics></related-topics>
                </div>
                <hr>
                <div class="row">
                  <p class=" ml-3">Popular discussions</p>
                  <hr>
                  <hot-topics></hot-topics>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
 // import Navigation from '../components/navigation.vue';
  import classFeedBlock from '../components/class-feed-block.vue';
  import relatedTopics from '../components/related-topics.vue';
  import hotTopics from '../components/hot-topics.vue';
  export default {
    data() {
      return {
       class: {}
      }
    },
    components: {
      'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics,
      'related-topics': relatedTopics
    },
    created() {
      this.$http.get(`api/classroom/${this.$route.params.id}`)
          .then(
            data
          => this.class = data.body.classroom);
    }
  }
</script>

<style scoped lang="scss">
  form input {
    width: 100%;
  }

  .green {
    background-color: green;
  }


  ul {
    list-style: none;
    padding: 0;
    li {
      margin: 0;
    }
  }
</style>