<template v-cloak>
  <div class="classroom mt-5">
    <!-- <nav-list></nav-list> -->
    <div class="container-fluid">
      <div class="row justify-content-sm-center mt-5"  v-cloak>
        <div class="col-10">
          <div v-if="isMember">
            <div class="row">
              <div class="col-2 mt-5">
                <div class="block-full-height d-flex justify-content-center align-items-start ">

                  <div class="text-left">
                    <a href="">
                      <h3 class="classroom__title">{{classDetails.name}}</h3>
                    </a>
                    <hr>
                    <a class="btn btn-success text-center mb-2" type="submit">Code Play</a>
                    <br>
                    <a class="content__sub-title" href="">Announcements</a>
                    <br>
                    <a class="content__sub-title" href="">Assignments</a>
                    <br>
                    <a class="content__sub-title" href="">Members</a>
                    <br>
                    <a class="content__sub-title" href="">Files</a>
                    <hr>
                    <div>
                      <h5>Members:</h5>
                      <ul>
                        <li v-for="member in classDetails.members">
                          <a href="" v-for="profile in member"> {{profile.name}} </a>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>
              </div>
              <div class="col-7 mt-5">
                <div class="block-full-height d-flex justify-content-center align-items-start">
                  <!-- <class-feed-block></class-feed-block> -->
                  <create-activity v-show="authenticatedUser.prof"></create-activity>
                </div>
                <view-activities></view-activities>
              </div>
              <div class="col-3 mt-5">
                <div class="block-full-height">
                  <div class="row">
                    <p class=" ml-3">Popular discussions</p>
                    <hr>
                    <forum-category></forum-category>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="block-full-height d-flex" v-else>
            <p class=" m-auto">{{notMember}}</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  // import Navigation from '../components/navigation.vue';
  import classFeedBlock from '../community/class-feed-block.vue';
  // import relatedTopics from '../components/community/related-topics.vue';
  import forumCategories from '../community/forum-category.vue';
  import Activities from './Activities.vue';
  import CreateAct from './CreateActivity.vue';
  export default {
    data() {
      return {

        classDetails: {},
        isMember: false,
        authenticatedUser: this.$auth.getAuthenticatedUser(),
        notMember: 'You are not a member of this class.'
      }
    },
    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'forum-category': forumCategories,
      'view-activities': Activities,
      'create-activity': CreateAct
      //'related-topics': relatedTopics
    },
    mounted() {
      this.getData();
    },
    methods: {
      getData() {
        this.$http.get(`api/classroom/${this.$route.params.id}`)
          .then(
            data => {
              this.classDetails = data.body;
              if (data.body.isMember == true || data.body.isOwner == true) {
                this.isMember = true;
              }
            }
          );


      }
    },
    created() {

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
