<template>
  <div class="row">
    <div class="col-md-8 col-md-offser-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" v-model="activity.title">
          </div>
          <div class="form-group">
            <label>Question</label>
            <textarea type="text" class="form-control" v-model="activity.body"></textarea>
          </div>
          <div class="form-group row">
            <label for="" class="col-2 col-form-label">Date and time</label>
            <div class="col-10">
              <input class="form-control" type="datetime-local" v-model="newTime" id="datePicker" min="2018-01-04T08:30">
            </div>
          </div>
          <span v-if="activity.image != 'none' || this.img">
            <img :src="imagePath + activity.image">
          </span>
          <div class="form-group">

            <label>UPDATE IMAGE</label>
            <input type="file" class="form-control" @change="imageChanged"> {{activity.oldImage}}
          </div>
          <button @click="update" class="btn btn-success">Update</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import swal from 'sweetalert'
  import moment from 'moment'
  export default {
    created() {
      this.getActivity();
      // this.setOldImage();

    },
    data() {
      return {
        activity: {},
        newImage: '',
        newTime: '',
        oldImage: '',
        img: '',
        imagePath: ""
      }
    },
    mounted() {
      this.getImagePath()
    },
    methods: {
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
      imageChanged(e) {
        console.log(e.target.files[0]);
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);
        console.log(e.target.files[0])

        fileReader.onload = e => {
          this.activity.newImage = e.target.result;
        };

      },
      setOldImage() {
        this.newImage = this.activity.image;
        // console.log(this.activity.image + ' asdasdasd')
      },
      getActivity() {

        this.$http.get('api/activities/show/' + this.$route.params.id)
          .then(response => {
            this.activity = response.body
            this.activity.oldImage = response.body.image;
          })
      },
      update() {
        var time = new Date();
        var checkTime = moment(time).format("YYYY-MM-DD HH:mm:ss");
        this.activity.due = moment(this.newTime).format("YYYY-MM-DD HH:mm:ss");
        if (this.activity.due >= checkTime) {
          if (this.newTime) {
            this.activity.due = this.newTime;
            this.activity.enabled = 1;
          }
          this.$http.put('api/activities/update/' + this.$route.params.id, this.activity)
            .then(response => {
              console.log(response)
              swal("Succesfully Updated!", {
                icon: "success",
              });
              //   this.$router.push('/feed')
            })
        } else {
          swal("Invalid Date", {
            icon: "error"
          });
        }
      }
    },
  }

</script>
<style lang="scss" scoped>
  img {
    width: 150px;
  }

</style>
