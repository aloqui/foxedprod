<template>
  <div class="create-category ">
    <!-- <nav-list></nav-list> -->
    <div class="container-fluid">
      <div class="row no-gutters justify-content-sm-center">
        <div class="col-10">
          <div class="row mt-2">
            <div class="col-6 block-full-height d-flex align-items-center">
              <div class="card ">
                <div class="card-body p-5">
                  <div class="forum-post">
                    <div class="forum-post__form">

                      <p class="mb-2 font--medium text-center">This is how we'll call you:
                        <div class="url pt-2 pb-2">
                          <span class="https font--light ssl  pl-2 pt-2 pb-2">
                            <i class="fa fa-lock mr-2" aria-hidden="true"></i>FoxedFolio Devs
                            <span class="font--light pl-1 divider">|</span>
                          </span>

                          <span class="https font--light"> https://</span>foxedfolio.com/community/
                          <span class="font--medium endpoint" v-bind:class="createCategory.slug | removespace">{{createCategory.slug | removespace}}</span>
                        </div>
                      </p>

                      <form @submit.prevent="addCategory">

                        <div class="form-group mt-2 ">
                          <input class="form-control content__input--dark mb-2" name="title" id="title" cols="100" rows="1" width="100%" v-model="createCategory.name"
                            placeholder="Category name">
                          <p class="help-block mb-2 mt-2" v-for="error in errorHandling.name">{{error}}</p>
                          <input class="form-control content__input--dark mb-2" name="body" id="body" cols="100" rows="1" width="100%" v-model="createCategory.slug"
                            placeholder="Assign unique key to your new category. (Can only be assigned once.)">
                          <p class="help-block mb-2 mt-2" v-for="error in errorHandling.slug">{{error}}</p>
                          <textarea class="form-control content__input--dark mb-2" name="body" id="body" cols="100" rows="3" width="100%" v-model="createCategory.description"
                            placeholder="A brief description about your topic."></textarea>
                          <p class="help-block mb-2 mt-2" v-for="error in errorHandling.description">{{error}}</p>
                          <button type="submit" class="btn form__button--register-dark">
                            Publish
                            <div class="spinner p-1 d-flex align-items-center" v-if="loading">
                              <i class="animate__spin fas fa-circle-notch m-auto"></i>
                            </div>
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-6">
              Did you know?
            </div>
          </div>
          <div class="col">
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
  //import Navigation from '../components/navigation.vue';
  import classFeedBlock from '../components/community/class-feed-block.vue';
  import hotTopics from '../components/community/hot-topics.vue';
  import swal from 'sweetalert';
  // import forumReplies from '../components/forum-replies.vue';
  //import Thread from '../models/thread';

  export default {

    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics
      // 'forum-replies': forumReplies
    },
    // props: [
    //   'thread',
    //   'authenticatedUser'
    // ],
    data() {
      return {
        createCategory: {},
        errorHandling: {},
        loading: false
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
    filters: {
      removespace(str) {
        if (str) {
          return str.replace(/\s+/g, '');
        }
      }
    },
    methods: {
      removeSpace() {
        if (this.createCategory.slug) {
          this.createCategory.slug = this.createCategory.slug.replace(/\s+/g, '');
        }
      },
      addCategory() {
        this.removeSpace();
        this.errorHandling = "";
        this.loading = true;
        this.$http.post(`api/community/create`, this.createCategory)
          .then(function (response) { // do something 
            this.loading = false;
            swal("Discussion posted!", {
              icon: "success",
            });
            this.$router.push(`/community/`);
          })
          .catch(response => {
            this.loading = false;
            console.log(response.body.errors)
            this.errorHandling = response.body.errors;
          })
      }
    },
    created() {
      // this.$http.get(`api/currentChannel/${this.$route.params.slug}`)
      //   .then(function (data) {
      //     this.createThread.channel_id = data.body.id;
      //   })
    }
    // },
    // authenticatedUser() {
    //     return this.$auth.getAuthenticatedUser()
    //   }
  }

</script>

<style scoped lang="scss">
  .picture-placeholder {
    width: 50px;
  }

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
