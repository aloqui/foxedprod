<template v-cloak>
  <div class="classroom mt-5">
    <!-- <nav-list></nav-list> -->
    <div class="container" v-cloak>
      <div class="pt-4">
        <div v-if="isMember" class="row">
          <div class=" col-md-3  hidden-xs hidden-sm mb-3">
            <div class="text-left section-block">
              <p class="content__helper">Classroom Name</p>
              <a href="#">
                <h3 class="forum__title">{{classDetails.name}}</h3>
              </a>
              <p class="content__helper">Summary</p>
              <p class="font--normal">{{classDetails.body}}</p>
              <hr>
              <div class="mb-2 d-flex flex-column">
              <p class="content__helper mb-2">Actions</p>
              <!-- <class-feed-block></class-feed-block> -->
              <button type="button" class="btn form__button--positive-dark mb-2" data-toggle="modal" data-target="#createActivity">
                Add Activity
              </button>
              <button type="button" class="btn form__button--positive-dark" data-toggle="modal" data-target="#createDiscussion">
                Add Discussion
              </button>
            </div>
              <br>
              <div>
                <p class="content__helper">Members:</p>
                <ul>
                  <li v-for="member in classDetails.members">
                    <span href="" v-for="profile in member">
                      <router-link :to="'/'+profile.username +'/codes'">
                        <p>{{profile.name}}</p>
                      </router-link>
                    </span>
                  </li>
                </ul>
              </div>
            </div>

          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 mb-3 section-block">
              <view-activities class="" :user="user"></view-activities>
          </div>
          <div class="col-md-3 hidden-xs hidden-sm">
            <div class="block-full-height ">
              <div class="section-block">
                <!-- <p class="">Popular discussions</p> -->
                <forum-category></forum-category>
              </div>
            </div>
          </div>

        </div>
        <div class=" d-flex justify-content-center align-items-center not-member" v-else>
          <p class=" m-auto">{{notMember}}</p>
        </div>

      </div>
    </div>
    <div class="modal fade" id="createActivity" tabindex="-1" role="dialog" aria-labelledby="createActivity" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content section-block">
          <div class="modal-header">
            <h5 class="forum__title" id="exampleModalLabel">Create An Activity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <create-activity v-show="user.prof"></create-activity>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="createDiscussion" tabindex="-1" role="dialog" aria-labelledby="createDiscussion" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create An Activity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <create-activity  class="section-block" v-show="user.prof"></create-activity>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Create</button>
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
        notMember: 'You are not a member of this class.',
        user: {}
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
      this.$http.get(`api/user`)
        .then(mes => this.user = mes.body)
        .catch()
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
  .not-member {
    width: 100%;
    height: 100vh;
  }

  .page-layout {}

  form input {
    width: 100%;
  }

  .pop-dis {
    background: #ffffff;
    padding: 12px;
    align-items: center;
  }

  .green {
    background-color: green;
  }


  ul {
    list-style: none;
    padding: 0;
    li {
      margin: 0;
      a {
        text-decoration: none;
        color: #000;
      }
    }
  }

  @media ( max-width: 860px) {
    // .pop-dis{
    //   display: none!important;
    // }
    // .category--hide{
    //   display: none !important;
    // } 
    .width--after {
      // width: 100%;
    }
  }

  @media ( max-width: 667px) {

    .pop-dis {
      display: none !important;
    }
    .category--hide {
      display: none !important;
    }
  }

</style>
