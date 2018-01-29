<template>
  <div class="forum-post__header mt-2 " :id="`reply-${reply.id}`">
    <div class="mt-4">
      <div class=" d-flex">
        <!-- <p class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
        <div class="d-flex">
          <div>
            <img class="picture-placeholder mr-3" :src="reply.owner.avatar_path" alt="">
          </div>
          <router-link :to="`/${reply.owner.username}/threads`" class="no-decoration">
          <div class="d-flex flex-column">
            <a class="m-0 content__username" href="">{{reply.owner.name}}</a>
            <span class="content__helper">@{{reply.owner.username}} said {{reply.created_at | formatDate}}</span>
          </div>
          </router-link>
        </div>
        <button class="btn content__button--passive ml-auto mt-auto mb-auto" @click="favorite" :disabled="reply.isFavorited" v-if="isAuthenticated">
          <span class="font--light">{{reply.favorites_count}}</span>
          <i class="fas fa-star"></i>
        </button>
      </div>

      <div v-if="editing">
        <div class="form-group mt-3">
          <wysiwyg v-model="body" :value="body"></wysiwyg>
          <!-- <textarea class="form-control" v-model="body"></textarea> -->
        </div>
        <div class="level d-flex">
          <div>
            <button class="btn content__helper text-uppercase" @click="update">
              <i class="fas fa-check"></i>
              <div class="content__helper-visual--update">
                <p class="content__helper">Update</p>
              </div>
            </button>

            <button class="btn content__helper text-uppercase" @click="editing = false; body = attributes.reply.body">
              <i class="fas fa-times"></i>
              <div class="content__helper-visual--cancel">
                <p class="content__helper">Cancel</p>
              </div>
            </button>
          </div>
          <div class="ml-auto">
            <button class="btn content__helper text-uppercase " @click="destroy">
              <i class="far fa-trash-alt"></i>
              <div class="content__helper-visual--delete">
                <p class="content__helper">Delete</p>
              </div>
            </button>
          </div>
        </div>
      </div>
      <div class="content--paragraph mt-4 mb-4" v-else v-html="body"></div>
      user id : {{user.id}}, owner id: {{attributes.reply.user_id}}
      <div class="level d-flex panel-footer" v-if="user.id == attributes.reply.user_id && !editing">
        <button class="btn content__helper text-uppercase" @click="editing = true">
          <i class="far fa-file-alt"></i>
          <div class="content__helper-visual">
            <p class="content__helper">Edit</p>
          </div>
        </button>
        <button class="btn content__helper text-uppercase" @click="destroy">
          <i class="far fa-trash-alt"></i>
          <div class="content__helper-visual--delete">
            <p class="content__helper">Delete</p>
          </div>
        </button>
      </div>
      <hr>
    </div>
  </div>
</template>
<script>
  import Wysiwyg from "./wysiwyg.vue";
  import moment from 'moment';
  export default {
    components: {
      'wysiwyg': Wysiwyg,
    },
    props: ['attributes', 'user'],
    name: 'reply',
    data() {
      return {
        editing: false,
        reply: this.attributes.reply,
        body: this.attributes.reply.body
      }
    },
    methods: {
      update() {
        this.$http.patch(`api/replies/${this.attributes.reply.id}`, {
            body: this.body
          })
          .then(data => {
            this.attributes.reply.body = this.body;
            this.editing = false,
              this.threads = data.body
            swal("Edited!", {
              icon: "success",
            });

          });
      },
      destroy() {
        this.$http.delete(`api/replies/${this.attributes.reply.id}`)
          .then(({
            data
          }) => {
            this.$emit('deleted', data);
            // this.$router.push(`/community/${this.$route.params.slug}/${this.$route.params.id}`)
            this.attributes.reply.body = this.body;
            this.editing = false,
              this.threads = data.body
            swal("Reply Deleted!", {
              icon: "success",
            });
          });
      },
      favorite() {
        this.$http.post(`api/replies/${this.attributes.reply.id}/favorites`)
          .then(this.pushFavorite)
          .catch(response => {
            alert(response.body.message)
          })
      },
      pushFavorite() {
        this.reply.isFavorited = true;
      }
    },
    computed: {
      isAuthenticated() {
        return this.$auth.isAuthenticated()
      },
      ago() {
        return moment(this.attributes.reply.created_at).fromNow() + '...';
      },
      favoriteClasses() {
        return ['btn']
      }
    },
    mounted() {
    },
    sockets: {
      favoriteReply(response) {
        var data = JSON.parse(response)
        this.reply.favorites_count++
      }
    },
  }

</script>

<style lang="scss">


</style>
