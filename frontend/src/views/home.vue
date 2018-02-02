<template v-cloak>
  <div class="home pt-1">
    <!-- <nav-list></nav-list> -->
    <div class="container">
      <div class="row mt-4">
        <div class="col-12 mb-4" v-if="!user.confirmed">
          <confirm-account :user="user"></confirm-account>
        </div>
        <div class="col-3">
          <div class="block-full-height d-flex  align-items-start text-left">
            <div class="section-block">
              <classroom :user="user"></classroom>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="block-full-height d-flex justify-content-center align-items-start">
            <div class="section-block">
              <timeline></timeline>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="block-full-height d-flex align-items-start">
            <div class="section-block">
              <forum-category></forum-category>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="container-fluid">
      <div class="row">
        <div class="col full-block__post">
          <div class="d-flex">
            <div>
              One
            </div>
            <div>
              Two
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</template>

<script>
  //import Navigation from '../components/navigation.vue';
  import feedBlock from '../components/community/feed-block.vue';
  import Classroom from '../components/community/enrolled-class.vue';
  import forumCategories from '../components/community/forum-category.vue';
  import JoinClass from '../components/community/join-class.vue';
  import CreateClass from '../components/community/create-class.vue';
  import Timeline from '../components/community/Timeline.vue';
  import ConfirmAccount from '../components/community/confirm-account.vue';

  export default {

    data() {
      return {
        user: {}
      }
    },
    components: {
      // 'nav-list': Navigation,
      'feed-block': feedBlock,
      'forum-category': forumCategories,
      'classroom': Classroom,
      'join-class': JoinClass,
      'create-class': CreateClass,
      'timeline': Timeline,
      'confirm-account': ConfirmAccount
    },
    mounted() {
      this.user.prof = false;
      this.$http.get(`api/user`)
        .then(this.refresh)
        .catch()
    },
    methods: {
      refresh(data) {
        this.user = data.body;
      }
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
    padding: 20px;
    border-radius: 50px;
    width: 200px;

    max-width: 100%;
  }

  ul {
    list-style: none;
    padding: 0;
    li {
      margin: 0;
    }
  }

</style>
