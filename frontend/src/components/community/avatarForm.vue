<template>
  <div>
    <form action="POST" enctype="multipart/form-data">
      <div class="d-flex mt-5">
        <img :src="avatar" class="picture mr-4" alt="">
        <div class="d-flex flex-column justify-content-start">
          <h1 class="font--bold">{{user.name}}</h1>
          <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
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
            <img :src="avatar" class="picture mr-4" alt="">
            <input type="file" name="avatar" accept="image/*" @change="onChange" v-if="isAuth">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
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

</script>
<style scoped lang="scss">
  .picture {
    background-color: #efefef;
    width: 160px;
    height: 160px;
    border-radius: 100%;
  }

</style>
