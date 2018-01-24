<template>

  <div class="home">
    <!-- BELONGS TO -->
    <div class="container-fluid">
      <div class="row d-flex justify-content-sm-center">
        <div class="col-xl-8 col-md-10">
          <div class="row">
            <div class="col-12 d-flex flex-column align-items-center justify-content-center ">
              <avatarForm :user="user"></avatarForm>
              <h1>{{user.name}}</h1>
            </div>
            <div>
              <div class="forum-post__header full-block__post m-2 p-3" v-for="thread in threads">
                <a class="forum-post__title mb-5">
                  <router-link class="nav-item" :to="`/community/${thread.channel.slug}/${thread.id}`">
                    <a class="nav-link" href="">{{thread.title}}</a>
                  </router-link>
                </a>
                <div class=" d-flex flex-row justify-content-start  align-items-center mt-3">
                  <!-- <img class="picture-placeholder mr-3" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" -->
                  <!-- alt=""> -->
                  <!-- <a class="mb-0" href="">{{thread.owner.name}} </a> said {{thread.created_at}} -->
                  <!-- <p class="mb-0 ml-1"> posted this 2 minutes ago</p> -->
                </div>
                <!-- <hr> {{thread.body}} -->
                <hr> Replies: {{thread.replies.length}}
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</template>

<script>
import avatarForm from '../components/community/avatarForm.vue';
  export default {
    components: {
      'avatarForm': avatarForm
    },
    data() {
      return {
        user: {},
        threads: {},
        avatar: ''
      }
    },
    methods: {
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/threads`)
          .then(this.refresh);
      },
      fetchImage() {
        this.avatar = this.$auth.getAuthenticatedUser().avatar_path;
      },
      refresh(data) {
        console.log(data)
        this.threads = data.body[0]
        this.user = data.body.user
      }
    },
    mounted() {
      this.fetch()
      this.fetchImage()
    }

  }

</script>

<style scoped>
  form input {
    width: 100%;
  }

  .green {
    background-color: green;
  }

  img {
    width: 100%;
  }

  .picture {
    background-color: #efefef;
    width: 200px;
    height: 200px;
    border-radius: 50%;
  }

  i {
    margin: 0 10px;
    font-size: 24px;
    color: #a2a2a2;
  }

  ul {
    list-style: none;
    padding: 0;
  }

  li {
    margin: 0;
  }

</style>
