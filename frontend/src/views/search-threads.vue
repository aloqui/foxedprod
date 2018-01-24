<template>
  <div class="search-thread mt-5 pt-5">
    <!-- {{user.username}} -->
    <div class="container-fluid">
      <div class="row no-gutters justify-content-sm-center">
        <div class="col-10">
          <div class="row mt-5">
            <div class="col-12  m-2 ml-0 p-3">
              <!-- <form class="d-flex" @submit.prevent="searchQuery">
                    <div class="form-group">
                        <input type="text" v-model="query" class="form-control m-auto" >
                    </div>
                    <div class="form-group">
                      <button type="submit" @>Submit</button>
                    </div>
                </form>
              <h5>Query results:</h5>
              <div v-for="result in results" :key="result.id">
                <div class="forum-post__header">
                  <router-link class="nav-item forum-post__title" :to="`/community/${result.channel.slug}/${result.id}`">
                    <h1 class="content__title font--bold mb-5">{{result.title}} </h1>
                  </router-link>

                  {{result.title}}


                  <div class=" d-flex flex-row justify-content-start  align-items-center mt-3">
                    <img class="picture-placeholder mr-3" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
                      alt="">
                    <router-link class="nav-item" :to="`/${result.owner.username}/threads`">
                      <a class="mb-0" href="">{{result.owner.name}} </a>
                    </router-link>
                    <span class="ml-1">said {{result.created_at}}</span>
                    <!-- <p class="mb-0 ml-1"> posted this 2 minutes ago</p> 
                  </div>
                  <hr>
                  <div v-html="result.body"></div>
                  <hr> Replies: {{result.replies.length}}
                </div>
              </div>
              <div v-if="results.length == 0">
                Sorry, No Query results for {{query}}
              </div> -->
            </div>
            <div class="col-12 m-2 ml-0 p-3">
              <ais-index 
                app-id="TN5MR9QHP4" 
                api-key="a933713f38f230be88643278a41c7281" 
                :query="q"
                
                index-name="threads">
                <ais-search-box @change="fetchSearch" ></ais-search-box>
                <ais-refinement-list attribute-name="channel.name">
                  
                </ais-refinement-list>
                <!-- :results-per-page="1" -->
                <ais-results >
                  <template slot-scope="{ result }" >
                    <p>
                      <router-link :to="result.path">
                        <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                      </router-link>
                    </p>
                  </template>
                </ais-results>
              </ais-index>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        endpoint: `api${this.$route.path}`,
        query: '',
        results: {},
        q: this.$route.query.q
      }
    },
    computed: {
    
    },
    mounted() {
      
    },
    methods: {
     

    }
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
