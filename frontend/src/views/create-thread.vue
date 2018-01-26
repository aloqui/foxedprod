<template>
  <div class="create-thread ">
    <!-- <nav-list></nav-list> -->
    <div class="container">
      <div class="row mt-2">
        <div class="col-12 ">
          <div class="">
            <div class="block-full-height d-flex flex-column  section-block mt-4 mb-3 ">
              <div class="m-5">
                <h2 class="content__title text-center font--bold">Create a Discussion</h2>
                <p class="content__sub-title text-center">Explore and learn from other developers around you.</p>
              </div>
              <form class="content ml-auto mr-auto card box-shadow p-5" @submit.prevent="addThread">
                <div class="form-group mt-2 p-3 trix__edit ">
                  <h5 class="content__helper mb-2 text-uppercase">Title</h5>
                  <h1 class="mb-5">
                    <input class="font--semi-bold" name="title" id="title" cols="100" rows="1" width="100%" v-model="createThread.title" placeholder="Your Title here"
                      required>
                  </h1>
                  <h5 class="content__helper mb-2 text-uppercase">Body</h5>
                  <wysiwyg name="body" v-model="createThread.body"></wysiwyg>
                  <p class="help-block" v-if="inputError" v-for="error in inputError">{{error}}</p>
                  <!-- <textarea class="form-control mb-2" name="body" id="body" cols="100" rows="5" width="100%" v-model="createThread.body" placeholder="Have something to say?" required></textarea> -->
                  <button type="submit" class="btn form__button--register-dark mt-5">
                    <i class="fas fa-align-left"></i>
                    <span class="ml-2">Publish</span>
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
      <div class="col">
      </div>
    </div>
  </div>
</template>

<script>
  //import Navigation from '../components/navigation.vue';
  import classFeedBlock from '../components/community/class-feed-block.vue';
  import hotTopics from '../components/community/hot-topics.vue';
  import swal from 'sweetalert';
  import Wysiwyg from '../components/community/wysiwyg.vue'
  // import forumReplies from '../components/forum-replies.vue';
  //import Thread from '../models/thread';

  export default {

    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics,
      'wysiwyg': Wysiwyg
      // 'forum-replies': forumReplies
    },
    // props: [
    //   'thread',
    //   'authenticatedUser'
    // ],
    data() {
      return {
        createThread: {},
        inputError: {},
        loading: false
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
    methods: {
      addThread() {
        this.loading = true;
        this.$http.post(`api/community/${this.$route.params.slug}`,
            this.createThread)
          .then(function (response) { // do something 
            this.loading = false;
            this.$router.push(`/community/${this.$route.params.slug}/${response.body.id}`);
            swal("Discussion posted!", {
              icon: "success",
            });
          })
          .catch(function (error) {
            this.loading = false;
            this.inputError = error.body.errors.body;
            console.log(error.body.errors.body)
          })
      }
    },

    created() {
      this.$http.get(`api/currentChannel/${this.$route.params.slug}`)
        .then(function (data) {
          this.createThread.channel_id = data.body.id;
        })
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
