<template>
  <div class="section-block mt-2">
    <div class="content m-auto">
      <span class="content__helper text-uppercase mb-4">Responses</span>
      <div v-for="(reply, index) in replies" :key="reply.id">
        <reply :attributes="{reply}" v-cloak @deleted="remove(index)"></reply>
      </div>
      <paginator :dataSet="dataSet" @changed="fetch"></paginator>
      
      <div class="" v-if="user.id">
        <new-reply :dataSet="dataSet" @created="add" @changed="fetch"></new-reply>
      </div>
      <div v-else>
        <p>Please sign in to reply to this topic.</p>
      </div>
    </div>
  </div>

</template>

<script>
  import Reply from "./reply.vue";
  import Paginator from './paginator.vue';
  import collection from '../../mixins/collection.js';
  import NewReply from './new-reply.vue';

  export default {
    components: {
      'reply': Reply,
      'new-reply': NewReply,
      'paginator': Paginator
    },
    mixins: [collection],
    name: 'replies',
    data() {
      return {
        dataSet: false,
        pageQuery: this.$route.query.page,
        endpoint: `api${this.$route.path}/replies`,
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
        this.dataSet = data.body;
        this.replies = data.body.data;
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
