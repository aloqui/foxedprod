<template v-cloak>
  <div class="topics mt-2">
    <div class="container" v-if="threads.length > 0">
      <div class="row mt-4">
        <div class="col-12">
          <div class="section-block mb-2">
            <p class="content__helper text-uppercase">Browsing</p>
            <h1 class="font--semi-bold text-uppercase">{{channel.name}}</h1>
            <p class="content__helper">{{channel.description}}</p>
          </div>
          <ais-index app-id="TN5MR9QHP4" api-key="a933713f38f230be88643278a41c7281" :query="q" :query-parameters="{'filters': `(channel.slug: ${endpoint})`,'page': 1}"
            index-name="threads">
            <div class="section-block mb-2 d-flex align-items-center">
              <div>
                <p class="content__helper text-uppercase">Search</p>
                <ais-search-box autofocus v-on:click="resetPage">
                  <ais-input class="" placeholder="I can help!" autofocus v-on:click="resetPage"></ais-input>
                </ais-search-box>
              </div>
              <div class="ml-auto">
                <ais-powered-by></ais-powered-by>
              </div>
            </div>
            <div class="section-block mb-2" v-if="isAuth">
              <p class="content__helper text-uppercase">Actions</p>
              <router-link :to="`/community/${endpoint}/create`">
                <button class="btn form__button--positive-dark ml-2 mt-2" type="submit">
                  <i class="fab fa-wpforms"></i>
                  <span class="ml-2">Start a Discussion</span>
                </button>
              </router-link>
            </div>
            <ais-results class="section-block mb-5" :results-per-page="5" :stack="true">
              <template slot-scope="{ result }">
                <div>
                  <router-link class="no-decoration" :to="`/community/${endpoint}/${result.id}`">
                    <div class="d-flex align-items-center topic__results">
                      <div>
                        <div class="forum__title">
                          <ais-highlight :result="result" attribute-name="title">
                          </ais-highlight>
                        </div>
                        <p class="content__helper">{{result.created_at | formatDateFormal}}</p>
                        <!-- <p class="content__helper text-uppercase">Content:</p> -->
                        <div class="content__limit-characters content--paragraph">
                          <p v-html="result.body"></p>
                        </div>
                        <p class="content__helper mt-3">
                          <span class="content__helper-highlight">Read more..</span>
                        </p>
                      </div>
                      <div class="ml-auto category__owner">
                        <p class="content__helper">Posted {{result.created_at | formatDate}} by</p>
                        <p class="ml-auto content__username font--light">{{result.owner.name}}</p>
                        <p class="content__helper">
                          <span class="content__helper-highlight">@{{result.owner.username}}</span>
                        </p>
                      </div>
                    </div>
                  </router-link>
                  <hr>
                </div>
              </template>
            </ais-results>
            <ais-no-results class="text-center"></ais-no-results>
          </ais-index>

        </div>

      </div>
    </div>

    <div class="d-flex flex-column block-half-height" v-else>
      <div class="m-auto text-center">
        <h2 v-cloak class="content m-3 font--light ">There are no current discussions in this category.
          <br>Start a new one.</h2>
        <router-link class="" :to="`/community/${endpoint}/create`">
          <button class="btn form__button--positive-dark">
            <i class="fab fa-wpforms"></i>
            <span class="ml-2">Start a Discussion</span>
          </button>
        </router-link>
        <p class="text-uppercase m-2 content__helper font--bold">or</p>
        <router-link class="" :to="`/community`">
          <button class="btn form__button--positive-dark">
            <i class="fas fa-chevron-circle-left"></i>
            <span class="ml-2">Go back</span>
          </button>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
  //import Thread from '../models/thread';

  export default {
    name: 'hot-topics',
    data() {
      return {
        threads: [],
        channel: {},
        endpoint: this.$route.params.slug,
        isAuth: null
      }
    },

    methods: {
      fetch() {
        this.$http.get(`api/community/${this.$route.params.slug}`)
          .then(this.refresh);
      },
      refresh(data) {
        this.channel = data.body.channel;
        this.threads = data.body.thread
        this.isAuth = this.$auth.isAuthenticated();
      }
    },
    mounted() {
      this.fetch()
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      },
      threadAgo() {
        return moment(this.threads.created_at).fromNow() + '...';
      }
    },
  }

</script>

<style scoped lang="scss">
  a {
    text-decoration: none;
  }

  .picture-placeholder {
    width: 50px;
  }

  .feed-block {

    width: 100%;
    .feed-block-inner {
      //border: 1px solid #000;
      .feed-block-inner__header {}
      .feed-block-inner__post {
        img {
          width: 40px;
        }
      }
    }
  }

</style>
