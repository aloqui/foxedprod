<template>
  <div class="row">
      <div class="col-md-8 col-md-offser-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <h1> {{activity.title}}</h1>
                        <!-- <input type="text" class="form-control" v-model="activity.title"> -->
                        
                    </div>
                    <div class="form-group">
                        <p>{{activity.body}}</p>
                        <span v-if="activity.image != 'none'">
        <img  :src="'http://localhost:8000/' + activity.image">
    </span>
                        <!-- <textarea type="text" class="form-control" v-model="activity.body"></textarea> -->
                    </div>
                    <!-- <button @click="update" class="btn btn-success" v-if="activity.body && activity.title">Update</button> -->
                </div>
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
          activity: {}
      }
  },
  methods: {
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
