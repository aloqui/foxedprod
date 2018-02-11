<template>
<div class="container">
  <div class="row pt-5">
            <div class="col-md-5">
            <span v-if="activity.image != 'none'"> <img :src="imagePath + activity.image"> </span>
            <span v-else> <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt=""> </span>
        </div>
        <div class="col-md-7">
          <h3>{{activity.title}}</h3>
            <p>{{activity.body}}</p>
          <router-link v-if="userMe.prof" class="btn btn-primary" :to="'/activity/' + activity.id +'/evaluate'">evaluation</router-link>
        </div>
  </div>
  </div>
</template>
<script>
import swal from 'sweetalert'
export default {
    created (){
        this.getActivity();
    },
  data () {
      return {
          activity: {},
           imagePath: "",
           userMe:''
      }
  },
  mounted() {
      this.getImagePath()
      this.$http.get(`api/user`)
        .then(mes => this.userMe = mes.body)
        .catch()
  },
  methods: {
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
      getActivity (){
          this.$http.get('api/activity/'+ this.$route.params.activity)
          .then(response => {
              this.activity = response.body
          })
      },
      update () {
          this.$http.put('api/activity/' + + this.$route.params.activity, this.activity)
          .then(response => {
              console.log(response)
                    swal("Succesfully Updated!", {
                icon: "success",
                });
              this.$router.push('/feed')
          })
      }
  },
}
</script>
<style lang="scss" scoped>
.panel{
    width: 100%;
    .form-group{
            img{
                width: 100%;
        }
    }
    
}
img{
    width: 100%
}
    
</style>
