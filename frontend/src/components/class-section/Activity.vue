<template>
  <div class="activity">
    <div class="">
      <div class="">
        <router-link class="" :to="`/${classOwner.username}/codes`">
            <div class="d-flex align-items center activity__owner mb-3">
              <div class="picture-placeholder mr-3">
                <img class="picture" :src="classOwner.avatar_path" alt="">
              </div>
              <div class="d-flex flex-column">
                <p class="content__username" v-text="classOwner.name"></p>
                <p class="content__helper">{{ activity.created_at | formatDate }}</p>
              </div>
            </div>
          </router-link>
        <p class="content__helper">Activity ID #{{ activity.id }}</p>
        <div class="d-flex align-items-center justify-content-between mb-3">
          <router-link :to="'/activity/' + activity.id">
            <h4 class="forum__title mb-2">{{ activity.title }}</h4>
          </router-link>
        </div>
        <span v-if="activity.image != 'none'">
          <img :src="imagePath + activity.image">
        </span>
          <p class="content__helper content__helper--negative mt-2">Instructions:</p>
        <div class="d-flex flex-column align-items-start justify-content-center section-block mt-2">
          <p class="">{{ activity.body }}</p>
          <span v-if="activity.enabled">
            <router-link v-if="activity.type == 'code'" v-show="activity.user_id != user.id" class="btn content__button--passive content__helper"
              :to="'/'+ activity.id + '/activity'">Start</router-link>
            <button v-if="activity.type == 'image'" v-show="activity.user_id != user.id" @click="$emit('cons')" type="button" class="btn content__button--passive content__helper"
              data-toggle="modal" data-target="#exampleModal">
              submit
            </button>
            <p class="content__helper">
              Due {{momentize(activity.due) | formatDate }} ({{ momentize(activity.due) }})
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
      </div>
      <div class="d-flex ml-auto mt-4 mb-4" v-if="activity.user_id == user.id">
        <a class="btn content__button--passive content__helper mr-1" @click="$emit('delete-activity')"> delete </a>
        <router-link class="btn content__button--passive content__helper ml-1" :to="'/activity/' + activity.id + '/update'">edit</router-link>
      </div>
          <hr>
    </div>
  </div>

</template>
<script>
  import moment from 'moment';
  import PictureMixin from '../../mixins/pictureMixin.js';
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
    mixins: [PictureMixin],
    props: [
      'activity',
      'authenticatedUser',
      'datea',
      'user',
      'classOwner'
    ],
    mounted() {
      this.fixPicture()
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

  h4 {
    color: #333 !important;
    padding-bottom: 5px;
  }

</style>
