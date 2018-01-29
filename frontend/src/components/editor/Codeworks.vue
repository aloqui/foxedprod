<template>
  <div class="row">
    <div class="col-lg-4 col-sm-6 portfolio-item"  v-for="code in codes.codes">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x700" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">{{ code.title }}</a>
              </h4>
              <p v-if="code.user_id == authenticatedUser.id">
              <!-- <a class="btn btn-danger" role="button" @click="$emit('delete-code')"> delete </a> -->
              <router-link class="btn btn-secondary" :to="'codes/' + code.id">edit</router-link>
            </p>
            <p v-else>
              <router-link class="btn btn-secondary" :to="'codes/' + code.id">view</router-link>
            </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-sm-6 portfolio-item"  v-for="code in codes.images">
          <div class="card h-100">
            <span v-if="code.image != 'none'">
                  <img :src="'http://localhost:8000/images/' + code.image"  @click="pass(code)" data-toggle="modal" data-target="#preview">
              </span>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">{{ code.title }}</a>
              </h4>
            </div>
          </div>
        </div>


    <div class="col-12">

         <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{modal.title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span v-if="modal.image != 'none'">
                            <img :src="'http://localhost:8000/images/' + modal.image">
                        </span>
                            
                    </div>
                    <div class="modal-footer">
                      <button v-if="modal.user_id == authenticatedUser.id">
                        <!-- <button> -->
                       <input type="file" class="form-control" @change="imageChanged">
                            <input v-model="modal.title"  type="text" placeholder="title">
                            <button @click="update">update</button>
                      </button>
                      <button @click="deleteimg"> 

                      </button>
                    </div>
                    </div>
                </div>
                </div>
      </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        codes: {},
      modal:{},
      newImage:'',
      oldImage:''
      }
    },

    mounted() {

      this.fetch();
    },
    methods: {
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/codes`)
          .then(this.refresh)
      },
      refresh(data) {
        this.codes = data.body
      },
      pass(a){
        this.modal = a;
        this.modal.oldImage = this.modal.image;
        
      },

       imageChanged(e) {
                console.log(e.target.files[0]);
                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0]);
                console.log(e.target.files[0])
                
                fileReader.onload = e => {
                this.modal.newImage = e.target.result;
                };
                
            },
            update(){
              if(!this.modal.activity_id){
                this.modal.evaluated = false;
              }
              this.$http.put('api/imageport/update/' + this.modal.id, this.modal)
                    .then(response => {
                        console.log(response)
                                swal("Succesfully Updated!", {
                            icon: "success",
                            });
                        //   this.$router.push('/feed')
                        location.reload()
                    })
            },
            deleteimg() {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        this.$http.delete('api/imageport/' + this.modal.id)
                        .then(response => {
                            
                            swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                        
                        });
                        location.reload()
                        })
                        
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                    });
            },
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
  }

</script>

<style lang="scss" scoped>
.code-card{
  width: 100%;
  display: flex;
  
  .code-container{
    display: flex;
    width: 100%;
    justify-content: space-around;
  }
}
.card {
  flex:1;
  width: 100%;
  .card-body{
    width: 100%;
  }
}
img{
  width: 100%;
}
</style>

