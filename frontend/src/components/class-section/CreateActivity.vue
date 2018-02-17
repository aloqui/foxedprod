<template>
  <div class="create--activity mb-3">
    <div class="p-0">
      <div class="">
        <div class="">
          <div class="row">
            <div class="col-12">
              <img :src="image" class="" />
              <form @submit.prevent="create">
                <div class="form-group">
                  <label class="content__helper">Title</label>
                  <input name="title" type="text" class="form-control" v-model="activity.title" v-validate="'required'">
                  <div class="help-block alert alert-danger" v-show="errors.has('title')">
                    {{errors.first('title')}}
                  </div>
                </div>
                <div class="form-group">
                  <label class="content__helper">Instructions</label>
                  <textarea name="question" type="text" class="form-control" v-model="activity.body" v-validate="'required'"></textarea>
                  <div class="help-block alert alert-danger" v-show="errors.has('question')">
                    {{errors.first('question')}}
                  </div>
                </div>
                <div class="form-group m-auto row no-gutters">
                  <div class="col-12 d-flex flex-column justify-content-center">
                    <label class="content__helper">Type</label>
                    <select class="section-block hover-pointer" v-model="activity.type">
                      <option value="code" default>Code</option>
                      <option value="image">Image</option>
                    </select>
                  </div>
                  <div class="col-12 mt-2 d-flex flex-column justify-content-center">
                    <label class="content__helper">Header Image</label>
                    <label for="files" class="section-block hover-pointer ">
                      <div class="d-flex">
                      <i class="far fa-image" aria-hidden="true"></i>
                      <p class="content__helper ml-2">Select an Image</p>
                      </div>
                    </label>
                    <input id="files" type="file" accept="image/*" class="form-control  content__helper pull-right" @change="imageChanged" style="visibility:hidden;">
                  </div>
                  <div class="col-12">
                    <label class="content__helper">Deadline for submission</label>
                    <input class="form-control section-block" type="datetime-local" v-model="tomorrow" id="datePicker" :min="limit">
                  </div>
                  <div class="col-12 mt-2">
                    <input type="submit" class="btn content__button--passive content__helper pull-right m-0"  data-toggle="modal" data-target="#createActivity"  value="Post Activity">
                  </div>
                </div>

              </form>
            </div>
          </div>


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
          due: ""
        },
        tomorrow: '',
        limit: '',
        image: ''
      };
    },
    methods: {
      imageChanged(e) {
        console.log(e.target.files[0]);
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.activity.image = e.target.result;
          this.image = e.target.result;
        };
        console.log(this.activity);
      },
      create() {
        var time = new Date();
        var checkTime = moment(time).format("YYYY-MM-DD HH:mm:ss");

        this.activity.due = moment(this.tomorrow).format("YYYY-MM-DD HH:mm:ss");

        if (this.activity.due >= checkTime) {
          this.$http.post("api/activity", this.activity).then(response => {
              console.log(response);
              swal("Succesfully created!", {
                icon: "success"
              });
              this.$router.push("/activity/" + response.body.id);
            })
            .catch(response => {
              console.log(response)
            })
        } else {
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
    mounted() {
      // var dateControl = document.querySelector('input[type="datetime-local"]');
      // dateControl.value = Date.now();
      var tom = new Date();
      // this.limit = tom;
      // var calendarTom = tom.getFullYear() +'-'+ tom.getDate() +'-'+(tom.getMonth() + 1)+'T'+(tom.getHours()+ 1)+':'+(tom.getMinutes()+ 1);
      // moment(tom.getMilliseconds())
      // this.activity.due = '2017-06-01T08:30';

      // console.log(tom + "asdas")
      this.limit = moment(tom).format("YYYY-MM-DDTHH:mm")
    }
  };

</script>
<style lang="scss">
  .create--activity {}

  img {
    width: 100%;
  }

  .form {
    width: 100%;

    input {
      width: 100%;
    }
    .btn {}
  }

</style>
