<template>
  <div class="forum-post__header full-block__post m-2 p-3" :id="`reply-${reply.id}`">
    <div>
      <p>
        
      </p>
      <div class=" d-flex flex-row justify-content-start  align-items-center mt-3">
        <!-- <p class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
        <img class="picture-placeholder mr-3" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
          alt="">
        <a class="nav-link" href="">{{reply.owner.name}}</a> said
        <span v-text="ago"></span>
        <button class="btn btn-default ml-auto" @click="favorite" :disabled="reply.isFavorited" v-if="isAuthenticated">{{reply.favorites_count}} <i class="far fa-star"></i></button>
      </div>
      <hr>
      <div v-if="editing">
        <div class="form-group">
          <wysiwyg v-model="body" :value="body"></wysiwyg>
          <!-- <textarea class="form-control" v-model="body"></textarea> -->
        </div>
        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing = false; body = attributes.reply.body">Cancel</button>
      </div>
      <div class="forum__topic-content" v-else v-html="body"></div>

      <hr>
      <div class="level d-flex panel-footer" v-if="authenticatedUser.id == reply.user_id">
        <button class=" btn btn-xs mr-2" @click="editing = true">Edit</button>
        <button class=" btn btn-xs btn-danger mr-2" @click="destroy">Delete</button>
      </div>
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
    props: ['attributes'],
    name: 'reply',
    data() {
      return {
        editing: false,
        reply: this.attributes.reply,
        body: this.attributes.reply.body,
      }
    },
    computed: {
      favoriteClasses() {
        return ['btn']
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
        this.reply.favorites_count++;
        this.reply.isFavorited = true;
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      },
      isAuthenticated() {
        return this.$auth.isAuthenticated()
      },
      ago() {
        return moment(this.attributes.reply.created_at).fromNow() + '...';
      }
    },
    created: {

    }
  }

</script>

<style lang="scss">
  .picture-placeholder {
    width: 50px;
  }

</style>
