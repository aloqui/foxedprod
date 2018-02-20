<template>

  <div class="home pt-4">
    <!-- BELONGS TO -->
    <div class="container">
      <div class="row section-block  ">
        <div class="col-12 ">
          <avatarForm :user="user" :userInfo="userInfo"></avatarForm>
        </div>
        <div class="topic__results mt-5">
          <span class="content__helper text-uppercase">Threads posted</span>
          <div class="topic__results-block" v-for="thread in threads" :key="thread.id">
            <router-link class="nav-item no-decoration" :to="`/community/${thread.channel.slug}/${thread[0].id}`">
              <a class="forum__title" href="">{{thread.title}}</a>
              <p class="content__helper">Replies: {{thread.replies.length}}</p>
              <p class="content__limit-characters  content--paragraph" v-html="thread.body"></p>
              <p class="content__helper mt-3">
                <span class="content__helper-highlight">Read more..</span>
              </p>
              <hr>
            </router-link>
            <!-- <hr> {{thread.body}} -->
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
        avatar: '',
        userInfo: {}
      }
    },
    mounted() {
      this.fetch()
      this.fetchImage()
      this.fetchDetails()
    },
    methods: {
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/threads`)
          .then(this.refresh);
      },
      fetchDetails() {
        this.$http.get(`api/${this.$route.params.user}/profile/info`)
          .then(this.refreshDetails)
      },
      refreshDetails(data) {
        this.userInfo = data.body
      },
      fetchImage() {
        this.avatar = this.$auth.getAuthenticatedUser().avatar_path;
      },
      refresh(data) {
        console.log(data)
        this.threads = data.body.threads
        this.user = data.body.user
      }
    },

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
