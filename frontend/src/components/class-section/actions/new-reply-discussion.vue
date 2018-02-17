<template v-cloak>
  <div class="new-reply">
    <div>
      <div class="forum-post__form">
        <form @submit.prevent="addReply">
          <div class="form-group">
            <!-- <wysiwyg v-model="newReply.body" :value="newReply.body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg> -->
            <textarea class="mt-2 form-control section-block" rows="1" v-model="newReply.body" placeholder="Have something to say?">
            </textarea>
            <!-- <textarea class="form-control mb-1" name="body" id="body" cols="100" rows="5" width="100%" placeholder="Have something to say?" v-model="reply.body" required></textarea> -->
            <button type="submit" class="btn content__helper content__button--passive mt-3">Post Reply</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  import Wysiwyg from '../../community/wysiwyg.vue';
  export default {
    components: {
      'wysiwyg': Wysiwyg
    },
    props: ['classDetails', 'discussion', 'dataSet'],
    data() {
      return {
        newReply: {},
        endpoint: '',
        completed: false
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
    methods: {
      addReply() {
        this.$http.post(`api/classroom/${this.classDetails.id}/${this.discussion.id}/replies`, this.newReply)
          .then(response => {
            this.newReply.body = ''
            this.completed = !this.completed
            swal(`Reply sent!`, {
              icon: "success",
            });
          })
          .catch(response => {
            swal(`Oops! There was a problem!`, {
              icon: "error",
            });
          })
      },
    },
    sockets: {
      message(response) {
        this.$emit('created', this.newReply)
        console.log(response)
        this.$emit('changed', this.dataSet.last_page)
        console.log('replied ')
      }
    }
  }

</script>
<style>


</style>
