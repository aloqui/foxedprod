<template>
  <div>
    <form action="POST" enctype="multipart/form-data">
      <div class="d-flex mt-3">
        <div class="picture mr-4">
          <img :src="avatar" class=" " alt="">
        </div>
        <div class="d-flex flex-column justify-content-start">
          <h1 class="font--semi-bold">{{user.name}}</h1>
          <div>
            <button type="button" class="btn content__button--passive content__helper" data-toggle="modal" data-target="#exampleModal">
              Edit Profile
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
            <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column justify-content-center align-items-center">
              <div class="picture mr-4">

                <img :src="avatar" class="" alt="">
              </div>
              <input class="mt-5 content__helper" type="file" name="avatar" accept="image/*" @change="onChange" v-if="isAuth">
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
  export default {
    name: 'avatarForm',
    data() {
      return {
        avatar: '',
        Auth: {},
        user: {}
      }
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
            alert("success");
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
    mounted() {
      this.fetchAuth();
      this.fetchProfile();
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
  .picture {
    background-color: #efefef;
    max-width: 130px;
    max-height: 130px;
    border-radius: 130px;
    overflow: hidden;
    img {
      width: 110%;
      transform: translateX(-4px);
    }
  }

</style>
