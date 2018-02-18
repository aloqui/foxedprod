<template>
  <div>
    <form action="POST" enctype="multipart/form-data">
      <div class="d-flex mt-3">
        <div class="picture-placeholder--large mr-4">
          <img :src="avatar" class="picture" alt="" id="picture">
        </div>
        <div class="d-flex flex-column justify-content-start">
          <h1 class="forum__title font--semi-bold pb-2">{{user.name}}</h1>
          <p class="content__helper mt-2">Bio</p>
          <p class="content--paragraph">{{ userInfo.bio }}</p>
          <div>
            <button type="button" class="btn content__button--passive content__helper mt-2" data-toggle="modal" data-target="#exampleModal"
              v-show="user.id == Auth.id">
              Change Profile Image
            </button>
          </div>
          <!-- <button type="submit" class="btn">Add Avatar</button> -->
        </div>
      </div>
    </form>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="content__helper text-uppercase mt-auto mb-auto" id="exampleModalLabel">Quick Settings</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column justify-content-center align-items-start">
              <div class="picture-placeholder--large mr-4">
                <img :src="avatar" class="picture" alt="" id="picture">
              </div>
              <input class="mt-3 content__helper" type="file" name="avatar" accept="image/*" @change="onChange" v-if="isAuth">
              <router-link class="no-decoration mt-5" :to="`/account`">
                <p class="content__helper text-left text-uppercase" data-toggle="modal" data-target="#exampleModal">Advanced Options</p>
              </router-link>
            </div>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="onChange">Save changes</button>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import PictureMixin from '../../mixins/pictureMixin.js';
  export default {
    name: 'avatarForm',
    mixins: [PictureMixin],
    props:['userInfo'],
    data() {
      return {
        avatar: '',
        Auth: {},
        user: {}
      }
    },
    mounted() {
      this.fetchAuth()
      this.fetchProfile() 
      this.fixPicture()

    },
    methods: {

      onChange(e) {

        if (!e.target.files.length) return;

        let avatar = e.target.files[0];

        let reader = new FileReader();

        reader.readAsDataURL(avatar);

        reader.onload = e => {
          this.avatar = e.target.result;
        };

        // Persist to the server
        this.persist(avatar);
      },

      persist(avatar) {
        let data = new FormData;
        data.append('avatar', avatar);
        this.$http.post(`api/${this.$route.params.user}/avatar`, data)
          .then(() => {
              this.fixPicture()

          })
      },
      fetchAuth() {
        this.$http.get(`api/user`)
          .then(this.refreshAuth)
      },
      fetchProfile() {
        this.$http.get(`api/${this.$route.params.user}/threads`)
          .then(this.refresh)
      },
      refreshAuth(data) {
        this.Auth = data.body
      },
      refresh(data) {
        this.user = data.body.user
        this.avatar = data.body.user.avatar_path

      },

    },

    computed: {
      isAuth() {
        return this.user.id == this.Auth.id
      }
    }

  }
  //$is_args$args

</script>
<style scoped lang="scss">


</style>
