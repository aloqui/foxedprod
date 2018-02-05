<template>
  <div class="row create--activity">
    <div class="col-md-12 p-0">
      <div class="panel panel-default">
        <div class="panel-body">
          <form @submit.prevent="create">
            <div class="form-group">
              <label>Image</label>
              <input type="file" class="form-control" @change="imageChanged">
            </div>
            <div class="form-group">
              <label>Title</label>
              <input name="title" type="text" class="form-control" v-model="activity.title" v-validate="'required'">
              <div class="help-block alert alert-danger" v-show="errors.has('title')">
                {{errors.first('title')}}
              </div>
            </div>
            <div class="form-group">
              <label>Instructions</label>
              <textarea name="question" type="text" class="form-control" v-model="activity.body" v-validate="'required'"></textarea>
              <div class="help-block alert alert-danger" v-show="errors.has('question')">
                {{errors.first('question')}}
              </div>
            </div>
            <div class="form-group mr-0 text-left row">
              <div class="col-4">
                <label>Type</label><br>
                <select v-model="activity.type">
                  <option value="code" default>Code</option>
                  <option value="image">Image</option>
                </select>
              </div>
              
              <div class="col-8">
                <label>Date and time</label>
                <input class="form-control" type="datetime-local" v-model="tomorrow" id="datePicker" :min="limit">
              </div>
            </div>
            <div class="form-group row">
              
                <div class="col-8">
                 
                </div>
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
  import moment from 'moment';
  export default {
    data() {
      return {
        activity: {
          title: "",
          body: "",
          image: "",
          classroom_id: JSON.parse(this.$route.params.id),
          type: "code",
          due:""
        },
        tomorrow:'',
        limit:''
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
        var time = new Date();
        var checkTime = moment(time).format("YYYY-MM-DD HH:mm:ss");
        this.activity.due = moment(this.tomorrow).format("YYYY-MM-DD HH:mm:ss");

        if(this.activity.due >= checkTime){
          this.$http.post("api/activity", this.activity).then(response => {
            console.log(response);
            swal("Succesfully created!", {
              icon: "success"
            });
            this.$router.push("/activity/"+response.body.id);
          });
        }
        else{
          swal("Invalid Date", {
              icon: "error"
            });
        }
        // this.$validator.validateAll().then(() => {
          // this.$http.post("api/activity", this.activity).then(response => {
          //   console.log(response);
          //   swal("Succesfully created!", {
          //     icon: "success"
          //   });
          //   this.$router.push("/activity/"+response.body.id);
          // });
        // });
      },
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser();
      },

    },
    mounted(){
      // var dateControl = document.querySelector('input[type="datetime-local"]');
      // dateControl.value = Date.now();
      var tom = new Date();
      this.limit = tom;
      var calendarTom = tom.getFullYear() +'-'+ tom.getDate() +'-'+(tom.getMonth() + 1)+'T'+(tom.getHours()+ 1)+':'+(tom.getMinutes()+ 1);
      moment(tom.getMilliseconds())
      this.activity.due = '2017-06-01T08:30';

      console.log(tom + "asdas")
    }
  };

</script>
<style lang="scss">
.create--activity{
}
.panel{
  padding: 10px;
}
  .form{
    
    input{
      width: 100%;
    }
    .btn{

    }
  }
</style>
