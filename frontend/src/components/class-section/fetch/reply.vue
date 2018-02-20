<template>
  <div class="forum-post__header reply-discussion  mt-2 " :id="`reply-${reply.id}`">
    <div class="">
      <div class="d-flex flex-column" v-if="!editing">
        <!-- <p class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
        <div class="d-flex align-items-start">
          <router-link :to="`/${reply.owner.username}/threads`" class="no-decoration d-flex">
            <div class="picture-placeholder mr-3">
              <img class="picture" :src="reply.owner.avatar_path" alt="">
            </div>
          </router-link>
          <div class="d-flex flex-column">
            <div class="d-flex justify-content-between">
              <p class="content__helper mt-0 mb-2 ">{{ reply.owner.name }}</p>
              <p class="content__helper mt-0 mb-2 ml-2">{{ reply.created_at | formatDate }}</p>
            </div>
            <p class="reply-discussion__response" v-text="reply.body"></p>
          </div>

        </div>
        <div class="d-flex align-self-end justify-content-center mt-2">
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
        </div>
      </div>

      <div v-else>
        <div class="form-group mt-3">
          <!-- <wysiwyg v-model="body" :value="body"></wysiwyg> -->
          <textarea class="mt-2 form-control" rows="10" cols="10" v-model="body" placeholder="Have something to say?"></textarea>
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

    </div>
  </div>
</template>
<script>
  import Wysiwyg from "../../community/wysiwyg.vue";
  import moment from 'moment';
  import PictureMixin from '../../../mixins/pictureMixin.js';
  export default {
    components: {
      'wysiwyg': Wysiwyg,
    },
    props: ['attributes', 'user'],
    mixins: [PictureMixin],
    name: 'reply',
    data() {
      return {
        editing: false,
        reply: this.attributes.reply,
        body: this.attributes.reply.body
      }
    },
    mounted() {
      this.fixPicture()
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
