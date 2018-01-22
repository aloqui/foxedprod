<template v-cloak>
  <div class="new-reply">
    <div v-if="authenticatedUser" class="">
      <div class="forum-post__form">
        <form @submit.prevent="addReply">

          <div class="form-group">
            <wysiwyg v-model="newReply.body" :value="newReply.body"></wysiwyg>
            <!-- <textarea class="form-control mb-1" name="body" id="body" cols="100" rows="5" width="100%" placeholder="Have something to say?" v-model="reply.body" required></textarea> -->
            <button type="submit" class="btn content__helper content__button--passive mt-3">Post Reply</button>
          </div>
        </form>
      </div>
    </div>

    <p class="text-center pb-2 pt-2" v-else>Please
      <a href="#/login">sign in</a> to participate in this discussion.</p>
  </div>
</template>
<script>
  import Wysiwyg from './wysiwyg.vue';
  export default {
    components: {
      'wysiwyg': Wysiwyg
    },
    props: ['attributes', 'dataSet'],
    data() {
      return {
        newReply: {},
        // body: this.attributes.body,
        endpoint: '',

        // authenticatedUser: this.$auth.getAuthenticatedUser()
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
    methods: {
      addReply() {
        this.$http.post(`api/community/${this.$route.params.slug}/${this.$route.params.id}/replies`,
          this.newReply
        ).then(({
          data
        }) => {
          this.newReply.body = '';
          this.$router.push(`${this.$route.path}?page=${this.dataSet.last_page}`);
          this.$emit('created', data);
          this.$emit('changed', this.dataSet.last_page);
          swal("Replied!", {
            icon: "success",
          });

        }, function (response) { // do something t
          swal("Error!", {
            icon: "error",
          });
        });
      },

    },
    created() {

      // this.$http.get(`api/community/${this.$route.params.slug}/${this.$route.params.id}`)
      //   .then(data => {
      //     this.reply = data.body.replies
      //     console.log(data);
      //   });

    }
  }

</script>
<style>


</style>
