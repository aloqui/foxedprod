<template>
  <div class="create-category ">
    <!-- <nav-list></nav-list> -->
    <div class="container">
      <div class="row mt-2">
        <div class="col-12 section-block block-full-height d-flex align-items-center mt-4 mb-3">
          <div class="card box-shadow m-auto">
            <div class="p-5">
              <div class="forum-post">
                <div class="content">
                  <p class="mb-2 font--medium text-center content__helper">This is how we'll call you:</p>
                  <div class="url pt-2 pb-2">
                    <span class="https font--light ssl  pl-2 pt-2 pb-2">
                      <i class="fa fa-lock mr-2" aria-hidden="true"></i>FoxedFolio Devs
                      <span class="font--light pl-1 divider">|</span>
                    </span>
                    <span class="https font--light"> https://</span>foxedfolio.com/community/
                    <span class="font--medium endpoint" v-bind:class="createCategory.slug | removespace">{{createCategory.slug | removespace}}</span>
                  </div>
                  <form class="trix__edit " @submit.prevent="addCategory">
                    <div class="form-group mt-5 ">
                      <div class="mb-5 ">

                        <span class="content__helper text-uppercase">Category Name</span>
                        <h1 class="">
                          <input class="font--semi-bold" name="title" id="title" cols="100" rows="1" width="100%" v-model="createCategory.name" placeholder="Your Category name">
                        </h1>
                        <p class="content__helper help-block mt-2" v-for="error in errorHandling.name">{{error}}</p>
                      </div>
                      <div class="mb-5 ">
                        <span class="content__helper text-uppercase">Category Username</span>
                        <input class="font--normal " name="body" id="body" cols="100" rows="1" width="100%" v-model="createCategory.slug" placeholder="YourCategoryName">
                        <p class="help-block mb-5" v-for="error in errorHandling.slug">{{error}}</p>
                      </div>
                      <span class="content__helper text-uppercase">Description</span>
                      <textarea class="form-control" name="body" id="body" cols="100" rows="3" width="100%" v-model="createCategory.description"
                        placeholder="A brief description about your topic."></textarea>
                      <span class="content__helper" v-if="createCategory.description.length >= 0">{{charactersLeft}} characters left</span>

                      <p class="help-block mb-2 mt-2" v-for="error in errorHandling.description">{{error}}</p>
                      
                      <div class="form-group ">
                        <vue-recaptcha 
                        ref="recaptcha"
                        @verify="onVerify"
                        :sitekey="'6LdNMUQUAAAAANCzAoEF4rLP5xK4zOk-nsneku70'">
                        
                        </vue-recaptcha>
                      </div>
                      <p class="help-block mb-2 mt-2" v-for="error in errorHandling.recaptcha">Recaptcha Error.</p>
                      
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
  import VueRecaptcha from 'vue-recaptcha';
  // import forumReplies from '../components/forum-replies.vue';
  //import Thread from '../models/thread';

  export default {

    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics,
      VueRecaptcha
      // 'forum-replies': forumReplies
    },
    // props: [
    //   'thread',
    //   'authenticatedUser'
    // ],
    data() {
      return {
        createCategory: {
          name: '',
          slug: '',
          description: ''
        },
        errorHandling: {},
        emailHandling: null,
        loading: false
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      },
      charactersLeft() {
        let left = 280 - this.createCategory.description.length;
        return left;
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
      onVerify(response) {
        this.createCategory.recaptcha = response
      },
      removeSpace() {
        if (this.createCategory.slug) {
          this.createCategory.slug = this.createCategory.slug.replace(/\s+/g, '');
        }
      },
      addCategory() {
        this.errorHandling = {}
        this.removeSpace()
        this.errorHandling = ""
        this.loading = true
        this.$http.post(`api/community/create`, this.createCategory)
          .then(function (response) { // do something 
            console.log(response)
            this.loading = false;
            swal("Discussion posted!", {
              icon: "success",
            });
            this.$router.push(`/community/${response.body.slug}`);
          })
          .catch(response => {
            console.log(response)
            this.loading = false;
            if (response.body.errors) 
              this.errorHandling = response.body.errors;

          })
      }
    }
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
