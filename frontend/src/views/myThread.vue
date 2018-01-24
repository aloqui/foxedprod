<template>

  <div class="home">
    <!-- BELONGS TO -->
    <div class="container">
      <div class="row ">
        <div class="col-12 section-block mt-5">
          <avatarForm :user="user"></avatarForm>
        </div>
        <div class="section-block topic__results">
          <span class="content__helper text-uppercase">Threads posted</span>
          <div class="topic__results-block" v-for="thread in threads">
            <router-link class="nav-item no-decoration" :to="`/community/${thread.channel.slug}/${thread.id}`">
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
