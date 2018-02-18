<template v-cloak>
  <div class="new-reply">
    <div v-if="isAuth" class="">
      <div class="forum-post__form">
        <form @submit.prevent="addReply">
          <div class="form-group">
            <wysiwyg v-model="newReply.body" :value="newReply.body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
            <!-- <textarea class="form-control mb-1" name="body" id="body" cols="100" rows="5" width="100%" placeholder="Have something to say?" v-model="reply.body" required></textarea> -->
            <button type="submit" class="btn content__helper content__button--passive mt-3">Post Reply</button>
          </div>
        </form>
      </div>
    </div>
    <div v-else>
      <p class="text-center pb-2 pt-2">Please
        <a href="#/login">sign in</a> to participate in this discussion.</p>
    </div>
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
        endpoint: '',
        completed: false,
        
      }
    },
    computed: {
      isAuth() {
        return this.$auth.isAuthenticated()
      }
    },
    methods: {
      addReply() {
        this.$http.post(`api/community/${this.$route.params.slug}/${this.$route.params.id}/replies`,
            this.newReply
          )
          .then(response => {
            this.$router.push(`${this.$route.path}?page=${this.dataSet.last_page}`)
            this.completed = !this.completed
            swal("Replied!", {
              icon: "success"
            })
          })
          .catch(response => {
            swal("Replied!", {
              icon: "success"
            })
          })
      },
    },
    sockets: {
      message(response) {
        this.$emit('created', this.newReply)
        this.$emit('changed', this.dataSet.last_page)
        console.log('replied ')
      }
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
