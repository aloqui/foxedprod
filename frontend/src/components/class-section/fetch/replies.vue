<template>
  <div class="mt-2">
    <div class="content m-auto">
      <div class="section-block">
      <span class="content__helper text-uppercase mb-4">Responses</span>
        <div v-for="(reply, index) in replies" :key="reply.id" >
          <reply :attributes="{reply}" v-cloak @deleted="remove(index)" :user="user"></reply>
          <hr>
        </div>
      </div>
      <paginator :dataSet="dataSet" @changed="fetch"></paginator>

      <div class="mt-3" v-if="user.id">
        <new-reply-discussion class="" :classDetails="classDetails" :dataSet="dataSet"  @created="add" @changed="fetch"></new-reply-discussion>
        <!-- <new-reply :dataSet="dataSet" @created="add" @changed="fetch"></new-reply> -->
      </div>
      <div v-else>
        <p class="text-center m-5 content__helper text">Please sign in to reply to this topic.</p>
      </div>
    </div>
  </div>

</template>

<script>
  import Reply from "./reply.vue";
  import Paginator from '../../community/paginator.vue';
  import collection from '../../../mixins/collection.js';
  import NewReply from '../actions/new-reply-discussion.vue';

  export default {
    components: {
      'reply': Reply,
      'new-reply-discussion': NewReply,
      'paginator': Paginator
    },
    mixins: [collection],
    props: ['classDetails'],
    name: 'replies',
    data() {
      return {
        dataSet: false,
        pageQuery: this.$route.query.page,
        endpoint: `api/class/${this.$route.params.id}/${this.$route.params.discussionId}/replies`,
        user: {}
      }

    },
    mounted() {
      this.fetch()
    },
    methods: {
      fetch(page) {
        this.$http.get(this.url(page)).then(this.refresh);
      },
      url(page) {
        if (!page) {
          let query = this.$route.query.page;

          page = query ? query[0] : 0;
        }
        return `${this.endpoint}?page=${page}`;
      },
      refresh(data) {
        this.user = this.$auth.getAuthenticatedUser();
        this.replies = data.body.data;
        this.dataSet = data.body
      }

    },
    sockets: {
      message(response) {
        this.$emit('changed', this.dataSet.last_page)
        console.log('replied')
      }
    },

    // computed: {
    //   authenticatedUser() {
    //     return this.$auth.getAuthenticatedUser()
    //   }
    // },
  }

</script>

<style scoped lang="scss">


</style>
