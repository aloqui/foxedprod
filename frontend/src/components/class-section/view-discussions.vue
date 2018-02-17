<template>
  <div class="classroom">
    <div class="section-block mb-2">
      <p class="content__helper text-uppercase">Discussions</p>
    </div>
    <ais-index app-id="TN5MR9QHP4" api-key="a933713f38f230be88643278a41c7281" :query="q" :query-parameters="{'filters': `(classroom_id: ${classDetails.id})`,'page': 1}"
      index-name="threads">
      <div class="section-block mb-2 d-flex align-items-center">
        <div>
          <p class="content__helper text-uppercase">Search</p>
          <ais-search-box autofocus >
            <ais-input class="" placeholder="Search..." autofocus></ais-input>
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
            <router-link class="no-decoration" :to="`/class/${classDetails.id}/discussion/${result.id}`">
              <div class="d-flex align-items-center topic__results">
                <div class="topic__results-block">
                  <p class="content__helper">Discussion ID#{{ result.id }}</p>
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
      <ais-no-results class="text-center section-block content__helper"></ais-no-results>
    </ais-index>
    <!-- <div class="d-flex flex-column">
      <div v-for="discussion in discussions" :key="discussion.id">
        <div class="d-flex justify-content-between">
          <p class="content__helper">Discussion Title</p>
          <p class="content__helper text-uppercase">Discussion ID #{{ discussion.id }}</p>
        </div>
        <h1 class="forum__title font--semi-bold mb-2">{{ discussion.title }}</h1>
        <div class="section-block">
            <p class="content__helper text-uppercase">Description</p>
          <p class="" v-text="discussion.body"></p>
        </div>
        
        <replies :classDetails="classDetails" :discussion="discussion"></replies>
        <!-- <new-reply-discussion :classDetails="classDetails" :discussion="discussion"></new-reply-discussion> -->
    <!-- <hr>
  </div>
  <div v-show="!hasDiscussion">
    <p class="text-uppercase content__helper">0 Discussions Found.</p>
  </div>
  </div> -->
  </div>
</template>
<script>
  import Replies from './fetch/replies.vue';
  export default {
    props: ['classDetails', 'discussions', 'hasDiscussion'],
    components: {
      'replies': Replies
    },
    data() {
      return {

      }
    },
    mounted() {

    },
    methods: {


    }

  }

</script>
