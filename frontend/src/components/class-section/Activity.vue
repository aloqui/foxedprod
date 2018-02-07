<template>
  <div class="forum-post__header text-left font--light">
    <div class="card">
      <div class="card-body">

        <h4 class="card-title">
          <router-link :to="'/activity/' + activity.id">{{ activity.title }}</router-link>
        </h4>
        <span v-if="activity.image != 'none'">
          <img :src="imagePath + activity.image">
        </span>

        <p class="card-text">{{ activity.body }}</p>
        <span v-if="activity.enabled">
          <router-link v-if="activity.type == 'code'" v-show="activity.user_id != user.id" class="btn content__button--passive content__helper"
            :to="'/'+ activity.id + '/activity'">Start</router-link>

          <button v-if="activity.type == 'image'" v-show="activity.user_id != user.id" @click="$emit('cons')" type="button" class="btn content__button--passive content__helper"
            data-toggle="modal" data-target="#exampleModal">
            submit
          </button>

          <p>
            until: {{momentize(activity.due)}}
          </p>
        </span>
        <span v-if="!activity.enabled && activity.user_id != user.id">
          <p>
            Closed
          </p>
        </span>
        <span v-if="!activity.enabled && activity.user_id == user.id">
          <p>
            Already ended
          </p>
        </span>

      </div>
      <hr>
      <p v-if="activity.user_id == user.id">
        <a class="btn btn-danger" role="button" @click="$emit('delete-activity')"> delete </a>
        <router-link class="btn btn-secondary" :to="'/activity/' + activity.id + '/update'">edit</router-link>
      </p>
    </div>



  </div>
</template>
<script>
  import moment from 'moment';
  export default {
    data() {
      return {
        dataTime: {
          enabled: ''
        },
        imageport: {},
        modal: {},
        imagePath: ""

      }
    },
    props: [
      'activity',
      'authenticatedUser',
      'datea',
      'user'
    ],
    mounted() {
      // this.activity.due = moment(this.activity.due).format('LLLL');
      this.getImagePath()

      var tod = new Date();
      var s = moment(tod).format("YYYY-MM-DD HH:mm:ss")
      var d = moment(this.activity.due).format("YYYY-MM-DD HH:mm:ss")

      var c = moment(s).valueOf()
      var cc = moment(d).valueOf()

      console.log(this.activity.due)
      console.log(c + " and " + cc)
      if (d <= s) {
        if (this.activity.enabled) {
          this.dataTime.enabled = 0;

          this.$http.put('api/activities/timesup/' + this.activity.id, this.dataTime)
            .then(response => {
              console.log(response)
              //     swal("Succesfully Updated!", {
              // icon: "success",
              // });
              location.reload();
            })
        }

      }
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

        fileReader.onload = e => {
          this.imageport.image = e.target.result;
        };
        console.log(this.activity);
      },
      submitImage() {
        this.imageport.submitted = true;
        this.imageport.activity_id = this.activity.id;
        this.$http.post('api/imageport/', this.imageport)
          .then(response => {
            console.log(response)
            swal("Succesfully submitted!", {
              icon: "success",
            });
          })
      },
      momentize(date) {
        return moment(date).calendar()
      },
    }
  }

</script>
<style lang="scss" scoped>
  img {
    width: 100%;
  }

</style>
