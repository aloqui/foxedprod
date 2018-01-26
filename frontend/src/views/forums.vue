<template>
  <div class="forums mt-4">
    <div class="container">
      <div class="row no-gutters justify-content-sm-center">
        <div class="col-12 mt-4">
          <div class="forum-post">
            <div>
              <ais-index app-id="TN5MR9QHP4" api-key="a933713f38f230be88643278a41c7281" :query="q" index-name="channels" :query-parameters="{'page': page} ">
                <!-- <ais-results-per-page-selector :options="[10, 20, 30]"></ais-results-per-page-selector> -->
                <div class="section-block mt-2 mb-2">
                  <router-link to="/community/create" v-if="isAuth">
                    <button class="btn form__button--positive-dark ml-1 mr-1" type="submit">
                      <i class="fas fa-expand"></i>
                      <span class="ml-2">Create a room</span>
                    </button>
                  </router-link>
                  <router-link :to="`/${user.username}/threads`" v-if="isAuth">
                    <button class="btn form__button--passive-dark " type="submit">View posted topics</button>
                  </router-link>
                  <!-- <router-link :to="`/threads/search`">
                    <button class="btn form__button--passive-dark" type="submit">Global thread search</button>
                  </router-link> -->
                </div>
                <div class="section-block mb-2">
                  <p class="content__helper">Search for topic</p>
                  <ais-search-box autofocus v-on:click="resetPage">
                    <ais-input class="" placeholder="Need help?" autofocus v-on:click="resetPage"></ais-input>
                  </ais-search-box>
                </div>
                <ais-results class="section-block mb-5" :results-per-page="5" :stack="true">
                  <template slot-scope="{ result }">
                    <div>
                      <router-link class="no-decoration" :to="result.path">
                        <div class="d-flex align-items-center">
                          <div>
                            <p class="content__helper ml-auto result__slug">@{{result.slug}}</p>
                            <div class="forum__title">
                              <ais-highlight :result="result" attribute-name="name">
                              </ais-highlight>
                            </div>
                            <p class="content__helper text-uppercase">Description:</p>
                            <p class="content--paragraph">

                            <ais-highlight :result="result" attribute-name="description">
                            </ais-highlight>
                            </p>
                          </div>
                          <div class="ml-auto category__owner">
                            <p class="ml-auto font--light">{{result.owner.name}}</p>
                            <p class="content__helper">@{{result.owner.username}}</p>
                          </div>
                        </div>
                      </router-link>
                      <hr>
                    </div>
                  </template>
                </ais-results>
                <div class="" v-if="page < last_page && !searchQuery">

                  <div class="text-center m-5 pb-5" v-observe-visibility="loadMore">
                    <i class="animate__spin animate__spin--dark fas fa-circle-notch m-auto"></i>
                    <p class="font--light">Loding..</p>
                  </div>
                </div>
                <div v-else v-cloak>
                  <p class="text-center m-5">I'm sorry, I can't give you more..</p>
                </div>
                <ais-no-results class="text-center"></ais-no-results>
              </ais-index>
            </div>

            <!-- <forum-category></forum-category> -->
            <!-- <hot-topics></hot-topics> -->
          </div>
        </div>
        <div class="col">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  //import Navigation from '../components/community/navigation.vue';
  import classFeedBlock from '../components/community/class-feed-block.vue';
  import hotTopics from '../components/community/hot-topics.vue';
  import forumCategories from '../components/community/forum-category.vue';
  export default {
    data() {
      return {
        isAuth: null,
        user: null,
        page: 1,
        last_page: null,
        searchQuery: "",
        q: this.$route.query.q
      }
    },
    components: {
      //'nav-list': Navigation,
      'class-feed-block': classFeedBlock,
      'hot-topics': hotTopics,
      'forum-category': forumCategories
    },
    methods: {
      loadMore: function (isVisible) {
        if (isVisible) {
          this.page++;
        }
      },
      authenticatedUser() {
        this.$http.get('api/user')
          .then(this.refresh)
      },
      refresh(data) {
        this.isAuth = this.$auth.isAuthenticated();
        this.user = data.body
        console.log(data);
      },
      fetch() {
        this.$http.get('api/channel/search')
          .then(data => {
            this.page = 1;
            this.last_page = data.body.last_page;
          })
      },
      resetPage() {
        this.page = 1;
        alert("reset")
      }
    },
    mounted() {
      this.fetch();
      this.authenticatedUser();
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
