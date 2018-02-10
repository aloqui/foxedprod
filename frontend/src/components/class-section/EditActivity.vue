<template>
<div class="container">
  <div class="row pt-5">
      <div class="col-md-12 edit-form pb-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span v-if="activity.image != 'none' || this.img">
                            <img :src="imagePath + activity.image">
                        </span>
                        <div class="form-group ">
                        <label for="files" class="btn content__button--passive content__helper pull-right m-0">Change Image</label>
                        <input id="files" type="file" accept="image/*" class="form-control  content__helper pull-right" @change="imageChanged" style="visibility:hidden;">
                            
                        </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="activity.title">
                    </div>
                    <div class="form-group">
                        <label>Question</label>
                        <textarea type="text" class="form-control" v-model="activity.body"></textarea>
                    </div>
                    <div class="form-group">
                    <label for="">Date and time</label>
                        <input class="form-control" type="datetime-local" v-model="activity.due" id="datePicker"  :min="timeTod">
                    </div>
                        
                    <button @click="update" class="btn content__button--passive content__helper pull-right">Update</button>
                </div>
            </div>
          </div> 
          <button @click="update" class="btn btn-success">Update</button>
        </div>
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
            // this.setOldImage();
            
        },
        data () {
            return {
                activity: {},
                newImage:'',
                newTime:'',
                oldImage:'',
                img:'',
                timeTod:'',
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
            setOldImage(){
                this.newImage = this.activity.image;
                // console.log(this.activity.image + ' asdasdasd')
            },
            getActivity (){
                
                this.$http.get('api/activities/show/' + this.$route.params.id)
                .then(response => {
                    this.activity = response.body
                    this.activity.oldImage = response.body.image;
                    this.activity.due = moment(response.body.due).format("YYYY-MM-DDTHH:mm")
                    console.log(this.activity.due)
                    
                })
                var time = new Date();
                this.timeTod = moment(time).format("YYYY-MM-DDTHH:mm");
            },
            update () {
                var time = new Date();
                var checkTime = moment(time).format("YYYY-MM-DD HH:mm");
                this.activity.due = moment(this.activity.due).format("YYYY-MM-DD HH:mm");
                
                if(this.activity.due >= checkTime){
                    if(this.activity.due){
                        this.activity.due = this.activity.due;
                        this.activity.enabled = 1;
                    }
                    this.$http.put('api/activities/update/' + this.$route.params.id, this.activity)
                    .then(response => {
                        console.log(response)
                                swal("Succesfully Updated!", {
                            icon: "success",
                            });
                            this.activity.due = moment(response.body.due).format("YYYY-MM-DDTHH:mm")
                            this.activity.oldImage = response.body.image;
                            this.activity.image = response.body.image;
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
<style lang="scss" scoped>
img{
    width: 100%;
}
.edit-form{
    display: flex;
    justify-content: center;
}
.panel{
    width: 60%;
    background: #fff;
    padding: 20px;
}
@media (max-width: 576px) {
    .panel{
    width: 100%;
    }
}
@media (max-width: 766px) {
    .panel{
    width: 70%;
}
 }
 @media (max-width: 991px) {
    .panel{
    width: 90%;
}
 }
</style>
