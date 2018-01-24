<template>
  <div class="home">
    <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="forum-post">
                <!-- <forum-category></forum-category> -->
                <hot-topics></hot-topics>
              </div>
            </div>
            <div class="col">
            </div>
      </div>
    </div>
  </div>
</template>

<script>
  //import Navigation from '../components/community/navigation.vue';
  import classFeedBlock from '../components/community/class-feed-block.vue';
  import hotTopics from '../components/community/hot-topics.vue';
  import forumCategories from '../components/community/forum-category.vue';
  export default {

    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics,
      'forum-category': forumCategories
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

  .picture {
    background-color: #efefef;
    padding: 65px 30px;
    border-radius: 50%;
  }

  ul {
    list-style: none;
    padding: 0;
    li {
      margin: 0;
    }
  }

</style>
