<template>
  <div class="home mt-5">
    <div class="container">
      <div class="row d-flex justify-content-sm-center section-block mt-5">
        <div class="col-12">
          <avatarForm :user="user"></avatarForm>
          <div class="col-12 d-flex mb-5">
            <router-link class="btn content__button--passive content__helper" :to="'/editor'">new code</router-link>
            <!-- <router-link class="btn btn-default" :to="'/settings'">settings</router-link> -->
            <button type="button" class="btn content__button--passive content__helper" data-toggle="modal" data-target="#imageport">
              Upload Image
            </button>
            <i class="fa fa-print" aria-hidden="true"></i>
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
          </div>
        </div>
        <div class="col-12">
          <code-works></code-works>
        </div>
      </div>
    </div>
        <div class="modal fade" id="imageport" tabindex="-1" role="dialog" aria-labelledby="imageportLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imageportLabel">Upload Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column justify-content-center align-items-center">
            </div>
            <input type="file" class="form-control" @change="imageChanged">
                        <div  class="d-flex flex-column justify-content-center align-items-center">
                            <input v-model="imageport.title"  type="text" placeholder="title">
                            <button @click="submitImage">save</button>
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
        imageport: {},
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
      },
      imageChanged(e) {
                    console.log(e.target.files[0]);
                    var fileReader = new FileReader();

                    fileReader.readAsDataURL(e.target.files[0]);

                    fileReader.onload = e => {
                    this.imageport.image = e.target.result;
                    };
                    console.log(this.activity);
                },
      submitImage(){
          this.$http.post('api/imageport/', this.imageport)
      .then(response => {
          console.log(response)
                  swal("Succesfully submitted!", {
              icon: "success",
              });
              location.reload()  
      })
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
