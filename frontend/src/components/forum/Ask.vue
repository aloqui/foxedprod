<template>
  <div class="row">
      <div class="col-md-8 col-md-offser-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form @submit.prevent="create" >
                        <div class="form-group">
                            <label>Title</label>
                            <input type="file" class="form-control"
                            @change="imageChanged">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input name="title" type="text" class="form-control" v-model="thread.title" v-validate="'required'">
                                <div class="help-block alert alert-danger" v-show="errors.has('title')">
                                    {{errors.first('title')}}
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Question</label>
                            <textarea name="question" type="text" class="form-control" v-model="thread.body" v-validate="'required'"></textarea>
                            <div class="help-block alert alert-danger" v-show="errors.has('question')">
                                {{errors.first('question')}}
                            </div>
                        </div>
                    <input type="submit" class="btn btn-success" v-if="thread.title && thread.body" value="submit">
                    </form>
                </div>
            </div>
      </div>
  </div>
</template>
<script>
import swal from 'sweetalert'
export default {
  data () {
      return {
          thread: {
              title:'',
              body:'',
              image:'',
              user_id:15
          }
      }
  },
  methods: {
      imageChanged (e) {
          console.log(e.target.files[0])
          var fileReader = new FileReader()

          fileReader.readAsDataURL(e.target.files[0])

          fileReader.onload = (e) => {
              this.thread.image = e.target.result
          }
          console.log(this.thread)
      },
      create () {
          this.$validator.validateAll().then(() => {

            this.$http.post('api/forums', this.thread)
                .then(response => {
                    console.log(response)
                            swal("Succesfully created!", {
                        icon: "success",
                        });
                    this.$router.push('/feed')
                })
            })
          
      },
      authenticatedUser () {
                return this.$auth.getAuthenticatedUser()
            }
  },
}
</script>
