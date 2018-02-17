<template>
  <div>
    <p class="content__helper text-uppercase">Discussions</p>
    <hr>
    <div class="d-flex flex-column">
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
        <hr>
      </div>
      <div v-show="!hasDiscussion">
        <p class="text-uppercase content__helper">0 Discussions Found.</p>
      </div>
    </div>
  </div>
</template>
<script>
    import Replies from './fetch/replies.vue';
  export default {
    props: ['classDetails'],
    components: {
        'replies': Replies
    },
    data() {
      return {
        discussions: {},
        hasDiscussion: false
      }
    },
    mounted() {
      this.fetch()
    },
    methods: {
      fetch() {
        this.$http.get(`api/classroom/discussion/${this.classDetails.id}`)
          .then(this.refresh)
      },
      refresh(data) {
        this.discussions = data.body
        if (data.body.length > 0)
          this.hasDiscussion = true
      }
    }
  }

</script>
