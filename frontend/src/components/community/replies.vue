<template>
  <div>
    <div v-for="(reply, index) in replies" :key="reply.id">
      <reply :attributes="{reply}" v-cloak @deleted="remove(index)"></reply>
    </div>
    <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    <div v-if="user.id">
      <new-reply :dataSet="dataSet" @created="add" @changed="fetch"></new-reply>
    </div>
    <div v-else>
      <p>Please sign in to reply to this topic.</p>
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
        user: null
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
        console.log(data.body.data);
        this.dataSet = data.body;
        this.replies = data.body.data;
        this.user = this.$auth.getAuthenticatedUser();
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
