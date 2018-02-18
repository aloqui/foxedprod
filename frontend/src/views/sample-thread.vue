<template>
  <div class="specific-thread">
    <!-- <nav-list></nav-list> -->
    <div class="container pt-4">
      <div class="row mt-2">
        <div class="col-12">
          <div class="section-block">
            <!-- <div v-for="thread in threads" v-bind:thread="thread" :key="thread.id"> -->
            <!-- Editing Thread -->
            <p class="content__helper text-center" v-if="!toShow">404 Not Found :(</p>
            <div v-bind:threads="threads" :key="threads.id">
              <thread :attriThread="threads" inline-template>
                <div class="content m-auto specific-thread__edit" v-if="editingThread">
                  <div class="mt-4">
                    <div class="trix__edit">
                      <div class="mb-4 d-flex">
                        <router-link class="no-decoration" :to="`/${attriThread.owner.username}/threads`">
                          <div class="d-flex align-items-center ">
                            <div class="picture-placeholder mr-3">
                              <img class="picture mr-3" :src="attriThread.owner.avatar_path" alt="">
                            </div>
                            <div class="d-flex flex-column">
                              <a class="m-0 content__username" href="">{{attriThread.owner.name}}</a>
                              <span class="content__helper">@{{attriThread.owner.username}} - {{attriThread.created_at | formatDate}}</span>
                              <!-- <p5 class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
                            </div>
                          </div>
                        </router-link>
                      </div>
                      <div class="form-group">
                        <!-- <h5 class="content__helper">Title</h5> -->
                        <h1>
                          <input class="font--semi-bold " type="text" v-model="editThread.title">
                        </h1>
                        <a href="#" class="content__helper">{{attriThread.created_at | formatDateFormal}}</a>
                      </div>
                      <div class="form-group">
                        <wysiwyg v-model="editThread.body" :value="editThread.body"></wysiwyg>
                        <!-- <textarea class="form-control" name="" id="" cols="30" rows="10" v-model="editThread.body"></textarea> -->
                      </div>
                      <a href="#" class="content__helper">{{attriThread.created_at | formatDateFormal}}</a>
                      <hr>
                    </div>
                    <div class="level d-flex">
                      <div>
                        <button class="btn content__helper text-uppercase" @click="update">
                          <i class="fas fa-check"></i>
                          <div class="content__helper-visual--update">
                            <p class="content__helper">Update</p>
                          </div>
                        </button>
                        <button class="btn content__helper text-uppercase" @click="editingThread = false; editThread.title = attriThread.title; editThread.body = attriThread.body">
                          <i class="fas fa-times"></i>
                          <div class="content__helper-visual--cancel">
                            <p class="content__helper">Cancel</p>
                          </div>
                        </button>


                      </div>
                      <div class="ml-auto">
                        <button class="btn content__helper text-uppercase " @click="deleteThread">
                          <i class="far fa-trash-alt"></i>
                          <div class="content__helper-visual--delete">
                            <p class="content__helper">Delete</p>
                          </div>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- thread -->
                <div class="content m-auto" v-else>
                  <div class="mt-4">
                    <div class="d-flex flex-column ">
                      <div class="mb-4 d-flex">
                        <router-link class="no-decoration" :to="`/${attriThread.owner.username}/threads`">
                          <div class="d-flex align-items-center ">
                            <div class="picture-placeholder mr-3">
                              <img class="picture " :src="attriThread.owner.avatar_path" alt="">
                            </div>
                            <div class="d-flex flex-column">
                              <a class="m-0 content__username" href="">{{attriThread.owner.name}}</a>
                              <span class="content__helper">@{{attriThread.owner.username}} - {{attriThread.created_at | formatDate}}</span>
                              <!-- <p5 class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
                            </div>
                          </div>
                        </router-link>
                        <div class="ml-auto" v-if="attriThread.owner.id != authUser.id && show">
                          <subscribe-button :active="active"></subscribe-button>
                        </div>
                      </div>
                      <div>
                        <h1 class="font--semi-bold">
                          <a class="content__title">{{attriThread.title}}</a>
                        </h1>
                        <a href="#" class="content__helper">{{attriThread.created_at | formatDateFormal}}</a>
                      </div>
                    </div>
                    <div class="mt-4 mb-4 content--paragraph">
                      <p v-html="attriThread.body"></p>
                    </div>
                    <a href="#" class="content__helper">{{attriThread.created_at | formatDateFormal}}</a>
                    <hr>

                    <div class="panel-footer level d-flex" v-if="attriThread.owner.id == authUser.id">
                      <div>

                        <button class="btn content__helper text-uppercase" @click="editingThread = true">
                          <i class="far fa-file-alt"></i>
                          <div class="content__helper-visual">
                            <p class="content__helper">Edit</p>
                          </div>
                        </button>
                      </div>
                      <div class="ml-auto">

                        <button class="btn content__helper text-uppercase " @click="deleteThread">
                          <i class="far fa-trash-alt"></i>
                          <div class="content__helper-visual--delete">
                            <p class="content__helper">Delete</p>
                          </div>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </thread>
            </div>
            <!-- </div> -->
          </div>
          <!-- reply -->
          <!-- <replies > -->
          <div>
            <replies v-show="toShow"></replies>
          </div>
          <!-- </replies> -->



        </div>
      </div>
    </div>
    <div class="col">
    </div>

  </div>
</template>

<script>
  //import Navigation from '../components/navigation.vue';
  import classFeedBlock from '../components/community/class-feed-block.vue';
  import hotTopics from '../components/community/hot-topics.vue';
  import swal from 'sweetalert';
  import Thread from '../components/community/thread';
  import Replies from '../components/community/replies.vue';


  // import forumReplies from '../components/forum-replies.vue';


  export default {
    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics,
      'replies': Replies,
      'thread': Thread
      // 'forum-replies': forumReplies
    },

    // props: [
    //   'thread',
    //   'authenticatedUser'
    // ],

    data() {
      return {
        threads: {},
        pageQuery: this.$route.query.page,
        endpoint: `api${this.$route.path}`,
        active: false,
        errorHandling: {},
        toShow: false
      }
    },
    mounted() {
      this.fetch()
    },
    methods: {
      fetch() {
        this.$http.get(this.endpoint)
          .then(this.refresh)
          .catch(response => {
            if(response.body.message) {
              this.toShow = false
              this.errorHandling = response.body
            }
          })
      },
      refresh(data) {
        this.toShow = true
        this.threads = data.body

      }
    },
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
