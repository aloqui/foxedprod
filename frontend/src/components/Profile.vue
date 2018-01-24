<template>
  <div class="home mt-5">
    <div class="container">
      <div class="row d-flex justify-content-sm-center section-block mt-5">
        <div class="col-12">
          <avatarForm :user="user"></avatarForm>
          <div class="col-12 d-flex mb-5">
            <router-link class="btn btn-default" :to="'/'+ authenticatedUser.name + '/editor'">new code</router-link>
            <router-link class="btn btn-default" :to="'/settings'">settings</router-link>
            <i class="fa fa-print" aria-hidden="true"></i>
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
          </div>
        </div>
        <div class="col-12">
          <code-works></code-works>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</template>

<script>
  import Works from '../components/editor/Codeworks.vue';
  import avatarForm from './community/avatarForm.vue';

  export default {
    components: {
      'code-works': Works,
      'avatarForm': avatarForm
    },
    data() {
      return {
        // profile: {},
        user: {},
        authenticatedUser: {}
      }
    },
    methods: {
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/user`)
          .then(this.refresh)
      },
      refresh(data) {
        this.authenticatedUser = this.$auth.getAuthenticatedUser();
        this.user = data.body;
      }

    },
    mounted() {
      this.fetch()
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
