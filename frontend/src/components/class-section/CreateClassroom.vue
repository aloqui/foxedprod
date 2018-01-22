<template>
  <div class="row">
    <div class="col-md-8 col-md-offser-2">
      <div class="panel panel-default">
          <h1>Create Classroom</h1>
        <div class="panel-body">
          <form @submit.prevent="create">
            <div class="form-group">
              <label>Subject</label>
              <input name="name" type="text" class="form-control" v-model="classroom.name" v-validate="'required'">
              <div class="help-block alert alert-danger" v-show="errors.has('name')">
                {{errors.first('name')}}
              </div>
            </div>
            <div class="form-group">
              <label>Overview</label>
              <textarea name="question" type="text" class="form-control" v-model="classroom.body" v-validate="'required'"></textarea>
              <div class="help-block alert alert-danger" v-show="errors.has('question')">
                {{errors.first('question')}}
              </div>
            </div>
            <input type="submit" class="btn btn-success" v-if="classroom.name && classroom.body" value="submit">
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
        classroom: {
          name: "",
          body: "",
        }
      };
    },
    methods: {
      create() {
        this.$validator.validateAll().then(() => {
          this.$http.post("api/classroom/create/a", this.classroom).then(response => {
            console.log(response);
            swal("Succesfully created!", {
              icon: "success"
            });
          });
        });
      },
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser();
      }
    }
  };

</script>
