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
        created (){
            this.getActivity();
        },
        data () {
            return {
                activity: {},
                newTime:''
            }
        },
        methods: {
            getActivity (){
                
                this.$http.get('api/activities/show/' + this.$route.params.id)
                .then(response => {
                    this.activity = response.body
                })
            },
            update () {
                var time = new Date();
                var checkTime = moment(time).format("YYYY-MM-DD HH:mm:ss");
                this.activity.due = moment(this.newTime).format("YYYY-MM-DD HH:mm:ss");
                if(this.activity.due >= checkTime){
                    if(this.newTime){
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
                }
                else{
                swal("Invalid Date", {
                    icon: "error"
                    });
                }
            }
        },
    }
</script>
