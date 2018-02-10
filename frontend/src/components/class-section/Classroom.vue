<template v-cloak>
  <div class="classroom mt-5">
    <!-- <nav-list></nav-list> -->
    <div class="container" v-cloak>
      <div class="pt-4" >
          <div v-if="isMember" class="row">
              <div class="col-3 p-0">
                <div class="  pop-dis">

                  <div class="text-left">
                    <a href="">
                      <h3 class="classroom__title">{{classDetails.name}}</h3>
                    </a>
                    <hr>
                    <p>{{classDetails.body}}</p>
                    <br>
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
              <div class="col-6">
                <div>
                  <!-- <class-feed-block></class-feed-block> -->
                  <create-activity  class="section-block" v-show="user.prof"></create-activity>
                  <view-activities  class="section-block mt-3" :user="user"></view-activities> 
                </div>
                
              </div>
              <div class="col-3 p-0">
                <div class="block-full-height d-flex align-items-start">
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
        user:{}
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
.not-member{
  width: 100%;
  height: 100vh;
}
.page-layout{

}
  form input {
    width: 100%;
  }
  .pop-dis{
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
      a{
        text-decoration: none;
        color: #000;
      }
    }
  }

</style>
