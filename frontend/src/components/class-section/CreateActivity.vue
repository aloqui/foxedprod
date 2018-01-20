<template>
  <div class="row">
    <div class="col-md-8 col-md-offser-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <form @submit.prevent="create">
            <div class="form-group">
              <label>Image</label>
              <input type="file" accept="image/*" class="form-control" @change="imageChanged">
            </div>
            <div class="form-group">
              <label>Title</label>
              <input name="title" type="text" class="form-control" v-model="activity.title" v-validate="'required'">
              <div class="help-block alert alert-danger" v-show="errors.has('title')">
                {{errors.first('title')}}
              </div>
            </div>
            <div class="form-group">
              <label>Question</label>
              <textarea name="question" type="text" class="form-control" v-model="activity.body" v-validate="'required'"></textarea>
              <div class="help-block alert alert-danger" v-show="errors.has('question')">
                {{errors.first('question')}}
              </div>
            </div>
            <div class="form-group mr-0 text-left">
                <select v-model="activity.type">
                  <option value="code" default>Code</option>
                  <option value="image">Image</option>
                </select>
            </div>
            <input type="submit" class="btn btn-success" v-if="activity.title && activity.body" value="submit">
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import swal from "sweetalert";
  export default {
    data() {
      return {
        activity: {
          title: "",
          body: "",
          image: "",
          classroom_id: JSON.parse(this.$route.params.id),
          type: "code"
        }
      };
    },
    methods: {
      imageChanged(e) {
        console.log(e.target.files[0]);
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.activity.image = e.target.result;
        };
        console.log(this.activity);
      },
      create() {
        // this.$validator.validateAll().then(() => {
          this.$http.post("api/activity", this.activity).then(response => {
            console.log(response);
            swal("Succesfully created!", {
              icon: "success"
            });
            // this.$router.push("/feed");
          });
        // });
      },
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser();
      }
    }
  };

</script>
