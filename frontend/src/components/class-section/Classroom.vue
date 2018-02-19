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
              <p class="content__helper mt-2">Summary</p>
              <p class="font--normal">{{classDetails.body}}</p>

              <hr>
              <div class="mb-2 d-flex flex-column">
                <p class="content__helper mb-2">Navigation</p>
                <div class="hover-pointer d-flex align-items-center content__sub-title" @click="discussionView = true; activityView = false; listStudentsView = false">
                  <i class="fas fa-code-branch  mr-2 ml-1"></i>
                  <p class="">Discussions</p>
                </div>
                <div class="hover-pointer d-flex align-items-center content__sub-title" @click="activityView = true; discussionView = false; listStudentsView = false">
                  <i class="fas fa-code  mr-2"></i>
                  <p class="">Activities</p>
                </div>
                <div class="hover-pointer d-flex align-items-center content__sub-title" @click="listStudentsView = true; discussionView = false; activityView = false">
                  <i class="fas fa-ellipsis-v ml-2 mr-2"></i>
                  <p class="">List of Students</p>
                </div>
                <hr>
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
          <div class="col-xs-12 col-sm-12 col-md-6 mb-3 " v-if="activityView == true">
            <view-activities class="section-block" :user="user"></view-activities>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 mb-3 " v-if="discussionView == true">
            <view-discussions class="section-block" :classDetails="classDetails" :discussions="discussions" :hasDiscussion="hasDiscussion"></view-discussions>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 mb-3 " v-if="listStudentsView == true">
            <view-list-of-students class="section-block" :classDetails="classDetails" :discussions="discussions"></view-list-of-students>
          </div>
          <div class="col-md-3 hidden-xs hidden-sm">
            <div class="mb-2 confirm-account">
              <div class="confirm-account-block d-flex flex-column flex-sm-row flex-md-column flex-lg-row justify-content-between">
                <p class="font--semi-bold">Classroom Code </p>
                <p class="font--semi-bold">
                  <span class="font--normal">#</span>{{ classDetails.id }}</p>
              </div>
            </div>
            <div class="block-full-height ">
              <div class="section-block">
                <!-- <p class="">Popular discussions</p> -->
                <forum-category></forum-category>
              </div>
            </div>
          </div>

        </div>
        <div class=" d-flex justify-content-center align-items-center not-member " v-else>
          <p class="section-block m-auto text-center content content__helper">{{notMember}}</p>
        </div>

      </div>
    </div>
    <div class="modal fade modal--cover" id="createActivity" tabindex="-1" role="dialog" aria-labelledby="createActivity" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content section-block">
          <div class="modal-header">
            <h5 class="forum__title" id="exampleModalLabel">Create An Activity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <create-activity :user="user" v-show="user.prof"></create-activity>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="createDiscussion" tabindex="-1" role="dialog" aria-labelledby="createDiscussion" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content section-block">
          <div class="modal-header">
            <h5 class="forum__title" id="exampleModalLabel">Create A Discussion Room</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <add-discussion :classDetails="classDetails" @discussionCreated="fetch"></add-discussion>
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
  import AddDiscussion from './actions/add-discussion.vue';
  import ViewDiscussions from './view-discussions.vue';
  import ViewListOfStudents from './view-list-of-students.vue';
  export default {
    data() {
      return {
        classDetails: {},
        isMember: false,
        authenticatedUser: this.$auth.getAuthenticatedUser(),
        notMember: 'You are not a member of this class.',
        user: {},
        discussionView: true,
        activityView: false,
        listStudentsView: false,
        discussions: {},
        hasDiscussion: false
      }
    },
    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'forum-category': forumCategories,
      'view-activities': Activities,
      'create-activity': CreateAct,
      'add-discussion': AddDiscussion,
      'view-discussions': ViewDiscussions,
      'view-list-of-students': ViewListOfStudents,
      //'related-topics': relatedTopics
    },
    mounted() {
      this.getData()

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
              // this.fetch()
            }
          );
      },
      fetch() {
        this.$http.get(`api/classroom/discussion/${this.classDetails.id}`)
          .then(this.refresh)
      },
      refresh(data) {
        this.discussions = data.body
        if (data.body.length > 0)
          this.hasDiscussion = true
      },
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
.modal--cover{

.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}
.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}
.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
  width: 100vw;
}
.modal-header {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 50px;
  padding: 10px;
  border: 0;
}
.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: rgb(68, 68, 68);
  line-height: 30px;
}
.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
  display: flex;
  flex-direction: column;
  justify-content: stretch;
  align-items: center; 
}
.modal-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  height: 60px;
  padding: 10px;
  background: #f1f3f5;
}
}
</style>
