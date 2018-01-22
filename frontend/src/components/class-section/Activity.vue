<template>
    <div>
           <div class="card">
  <div class="card-body">
      
    <h4 class="card-title"><router-link  :to="'/activity/' + activity.id">{{ activity.title }}</router-link></h4>
    <span v-if="activity.image != 'none'">
        <img :src="'http://localhost:8000/' + activity.image">
    </span>
    
    <p class="card-text">{{ activity.body }}</p>
    <span v-if="activity.enabled">
        <router-link v-if="activity.type == 'code'" v-show="activity.user_id != authenticatedUser.id" class="btn btn-primary" :to="'/'+ activity.id + '/activity'">Start</router-link>
        <button v-if="activity.type == 'image'" v-show="activity.user_id != authenticatedUser.id">Submit</button>
        <p>
            until: {{activity.due}} 
        </p>
    </span>
    <span v-if="!activity.enabled && activity.user_id != authenticatedUser.id">
        <p>
            Closed
        </p>
    </span>
    <span  v-if="!activity.enabled && activity.user_id == authenticatedUser.id">
        <p>
            Already ended
        </p>
    </span>
        
  </div>
  <hr>
  <p  v-if="activity.user_id == authenticatedUser.id">
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
            return{
                dataTime: {
                    enabled:''
                }
                
            }
        },
        props: [
            'activity',
            'authenticatedUser',
            'datea'
        ],
        mounted(){
            // this.activity.due = moment(this.activity.due).format('LLLL');
            var tod = new Date();
            var s = moment(tod).format("YYYY-MM-DD HH:mm:ss")
            var d = moment(this.activity.due).format("YYYY-MM-DD HH:mm:ss")
            
                var c = moment(s).valueOf()
                var cc = moment(d).valueOf()
            
                console.log(this.activity.due)
                console.log(c + " and " + cc)
                if (d <= s){
                    if(this.activity.enabled){
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
            }
    }
</script>
<style lang="scss">
</style>
